<?php
namespace Deployer;

set('default_timeout', 3000);

require_once __DIR__ . '/deploy/tasks.php';

// Project name
set('application', 'my_project');

// Project repository
set('repository', 'https://github.com/ejjoj/sdiwpil-app.git');

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

//host('raspberry')
//    ->hostname('192.168.0.66')
//    ->user('sdiwpil')
//    ->identityFile('~/.ssh/id_rsa')
//    ->addSshOption('IdentitiesOnly', 'yes')
//    ->set('deploy_path', '/home/sdiwpil/www/app');

host('vps')
    ->setHostname('146.59.17.120')
    ->setRemoteUser('sdiwpil')
    ->setIdentityFile('~/.ssh/id_rsa')
//    ->addSshOption('IdentitiesOnly', 'yes')
    ->set('deploy_path', '/home/sdiwpil/www');

// Tasks

//task('build', function () {
//    run('cd {{release_path}} && build');
//});
//
//// [Optional] if deploy fails automatically unlock.
//after('deploy:failed', 'deploy:unlock');
//
//// Migrate database before symlink new release.
//
//before('deploy:symlink', 'database:migrate');

