<?php

namespace Deployer;

use Symfony\Component\Dotenv\Dotenv;

class DotEnvHelper
{
    private const LOCAL_DOT_ENV_PATH = './.env.dist';
    private const KERNEL_CLASS_KEY = 'KERNEL_CLASS';
    private const SYMFONY_DEPRECATIONS_HELPER_KEY = 'SYMFONY_DEPRECATIONS_HELPER';
    private const EXCLUDED_KEYS = [
        self::KERNEL_CLASS_KEY => self::KERNEL_CLASS_KEY,
        self::SYMFONY_DEPRECATIONS_HELPER_KEY => self::SYMFONY_DEPRECATIONS_HELPER_KEY,
    ];

    private Dotenv $dotEnv;
    private string $sharedDotEnvPath;
    private array $localEnvVars;
    private array $sharedEnvVars;

    private array $values = [];

    public function __construct(string $sharedDotEnvPath)
    {
        $this->dotEnv = new Dotenv();
        $this->sharedDotEnvPath = $sharedDotEnvPath;
        $this->localEnvVars = $this->getLocalEnvVars();
        $this->sharedEnvVars = $this->getSharedEnvVars();
    }

    public function handleDifferences(): void
    {
        $diff = array_diff_key($this->localEnvVars, $this->sharedEnvVars, self::EXCLUDED_KEYS);
        if (empty($diff)) {
            return;
        }
        $this->displayInfoAboutFindingNewVars($diff);
        $this->askForValues($diff);
        $this->copySharedDotEnvToBakFile();
        $this->saveValuesIntoSharedEnv();
    }

    private function getLocalEnvVars(): array
    {
        return $this->dotEnv->parse(runLocally('cat ' . self::LOCAL_DOT_ENV_PATH));
    }

    private function getSharedEnvVars(): array
    {
        return $this->dotEnv->parse(run('cat ' . $this->sharedDotEnvPath), $this->sharedDotEnvPath);
    }

    private function displayInfoAboutFindingNewVars(array $vars): void
    {
        writeln(sprintf(
            'New env variables found: %s. Type values for %s environment.',
            implode(', ', array_keys($vars)),
            get('stage')
        ));
    }

    private function askForValues(array $vars): void
    {
        foreach ($vars as $key => $value) {
            $this->values[$key] = ask(sprintf('Type value for: %s', $key));
        }
    }

    private function saveValuesIntoSharedEnv(): void
    {
        $date = (new \DateTime())->format('Y-m-d H:i:s');
        $data = sprintf(PHP_EOL . '###> deployer %s ###' . PHP_EOL, $date);
        foreach ($this->values as $key => $value) {
            $data .= sprintf('%s=%s' . PHP_EOL, $key, $value);
        }
        $data .= sprintf('###< deployer %s ###', $date);

        run(sprintf('echo "%s" >> %s', $data, $this->sharedDotEnvPath));
    }

    private function copySharedDotEnvToBakFile(): void
    {
        run(sprintf(
            'cp %s %s',
            $this->sharedDotEnvPath,
            $this->sharedDotEnvPath . '.bak'
        ));
    }
}
