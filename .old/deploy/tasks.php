<?php

namespace Deployer;

require_once __DIR__ . '/src/FileHelper.php';
require_once __DIR__ . '/src/DotEnvHelper.php';
require 'recipe/common.php';

task(
    'deploy',
    [
        'install',
        'configure',
        'link',
    ]
);

// Symfony console opts
set('console_options', function () {
    return '--no-interaction --env=prod';
});

task('deploy:vendors', function () {
    if (!commandExist('unzip')) {
        writeln('<comment>To speed up composer installation setup "unzip" command with PHP zip extension https://goo.gl/sxzFcD</comment>');
    }

    run("cd {{release_path}} && wget https://getcomposer.org/download/2.2.6/composer.phar -O composer.phar");
    run('cd {{release_path}} && {{bin/php}} composer.phar install {{composer_options}} --no-cache');
});

task(
    'prepare',
    function () {
        set('allow_anonymous_stats', false);
        set('ssh_type', 'native');
        set('ssh_multiplexing', true);
        set('writable_mode', 'chmod');
        set('dump_assets', false);
        set('stage', 'vps');

        // Deploy branch
        $branch = input()->hasOption('branch') ? input()->getOption('branch') : null;
        $localBranch = runLocally('git rev-parse --abbrev-ref HEAD');
        if (!$branch) {
            $branch = $localBranch;
        }
        set('local_branch', $localBranch);
        set('branch', $branch);

        $default = [
            'shared_files' => [
                '.env',
            ],
            'shared_dirs' => [
                'public/uploads',
                'public/data',
                'var/log',
            ],
            'writable_dirs' => [
                'var',
            ],
            'clear_paths' => [],
            'maintenance_whitelist_ips' => '127.0.0.1',
            'bin/node' => 'node',
            'bin/npm' => 'npm',
            'bin/yarn' => 'yarn',
            'fastcgi_pass' => 'unix:/run/php/php7.4-fpm.sock',
            'nginx_config_dst_filename' => '/etc/nginx/sites-available/default',
            'bin_dir' => 'bin',
            'var_dir' => 'var',
            'bin/console' => '{{release_path}}/bin/console',
            'working_path' => '{{release_path}}',
            'server_name' => 'sdiwpil.online',
            'parameters' => [
                'branch' => '{{branch}}',
                'router.request_context.host' => '{{server_name}}',
                'router.request_context.base_url' => '',
                'asset.request_context.base_path' => '%router.request_context.base_url%',
                'asset.request_context.secure' => true,
            ],
        ];

        foreach ($default as $key => $value) {
            set($key, $value);
        }
    }
)
    ->desc('Update configuration options depends on stage')
    ->once();

task(
    'configure:copy_files',
    function () {
        $stage = get('stage');

        $srcDir = parse('{{release_path}}/deploy/templates_env/' . $stage);
        $dstDir = parse('{{release_path}}');
        FileHelper::generateFiles($srcDir, $dstDir);
    }
)
    ->desc('Generate files from templates');

task('configure:database:migrate', function () {
    run('{{bin/php}} {{bin/console}} doctrine:migrations:migrate --allow-no-migration');
})
    ->desc('Database migrations');

task('deploy:assets:install', function () {
    run('{{bin/php}} {{bin/console}} assets:install {{console_options}} {{release_path}}/public');
})
    ->desc('Install bundle assets');

task('deploy:assetic:dump', function () {
    if (get('dump_assets')) {
        run('{{bin/php}} {{bin/console}} assetic:dump {{console_options}}');
    }
})
    ->desc('Dump assets');

task('configure:database:cache_clear', function () {
    run('{{bin/php}} {{bin/console}} doctrine:cache:clear-metadata {{console_options}}');
    run('{{bin/php}} {{bin/console}} doctrine:cache:clear-query {{console_options}}');
    run('{{bin/php}} {{bin/console}} doctrine:cache:clear-result {{console_options}}');
})
    ->desc('Database cache clear');

task('configure:webpack', function () {
    invoke('prepare');

    run('{{bin/php}} {{bin/console}} fos:js-routing:dump --format=json --target={{release_path}}/public/js/fos_js_routes.json');

    run('cd {{release_path}} && {{bin/yarn}}');
    run('cd {{release_path}} && {{bin/yarn}} build', []);
})
    ->desc('Configure webpack');

/**
 * Clear Cache
 */
task('configure:cache:clear', function () {
    run('{{bin/php}} {{bin/console}} cache:clear {{console_options}} --no-warmup');
})->desc('Clear cache');

/**
 * Warm up cache
 */
task('configure:cache:warmup', function () {
    run('{{bin/php}} {{bin/console}} cache:warmup {{console_options}}');
})->desc('Warm up cache');


task('configure:dotenv', function () {
//    if (get('stage') !== 'dev') {
//        (new DotEnvHelper(parse('{{deploy_path}}/shared/.env')))->handleDifferences();
//    }
})
    ->desc('Handle differences in dotenv file');

task('link:services:reload', function () {
    $commands = [
        'sudo -S /usr/sbin/service php7.4-fpm reload',
        'sudo cp {{release_path}}/etc/nginx.conf {{nginx_config_dst_filename}}',
        'sudo nginx -t && sudo nginx -s reload',
        'sudo systemctl stop nginx',
        'sudo systemctl start nginx',
    ];

    foreach ($commands as $command) {
        run($command);
    }
})
    ->desc('Update nginx');

task('install', function () {
    invoke('prepare');

    $tasks = [
        'deploy:info',
        'deploy:prepare',
//        'deploy:lock',
        'deploy:release',
        'deploy:update_code',
        'deploy:shared',
        'deploy:writable',
        'deploy:vendors',
    ];

    if ('dev' === get('stage')) {
        $tasks = [
            'deploy:vendors',
        ];
    }

    foreach ($tasks as $task) {
        invoke($task);
    }
})
    ->desc('Install project');

task('configure', function () {
    invoke('prepare');

    $tasks = [
        'configure:copy_files',
        'configure:database:cache_clear',
        'configure:database:migrate',
        'deploy:assets:install',
        'deploy:assetic:dump',
        'configure:dotenv',
        'configure:webpack',
        'configure:cache:clear',
        'configure:cache:warmup',
    ];

    foreach ($tasks as $task) {
        invoke($task);
    }
})
    ->desc('Configure project');

task('link', function () {
    if ('dev' === get('stage')) {
        return;
    }

    invoke('prepare');

    $tasks = [
        'deploy:symlink',
        'link:services:reload',
        'deploy:unlock',
//        'cleanup',
    ];

    foreach ($tasks as $task) {
        invoke($task);
    }
})
    ->desc('Link project');

after('deploy:failed', 'deploy:unlock');
