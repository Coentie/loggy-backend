<?php

namespace DeepDigital\Loggy\Commands;

use Sentry\Dsn;
use Illuminate\Support\Str;
use DeepDigital\Loggy\Loggy;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use DeepDigital\Loggy\Client\Client;
use Symfony\Component\Process\Process;
use DeepDigital\Loggy\Project\Project;
use DeepDigital\Loggy\Client\ClientInterface;
use DeepDigital\Loggy\Intergration\Exception\ProjectNotCreatedException;

class PublishSettingsCommand extends Command
{
    /**
     * Key to identify empty lines in the .env
     * Required to filter out only new lines when creating a newly env.
     */
    private const EMPTY_LINE_ENV_KEY = 'empty_';

    /**
     * @var \Illuminate\Support\Collection
     */
    private Collection $env;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loggy:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes and configures the Loggy config.';

    /**
     * Loggy client.
     *
     * @var \DeepDigital\Loggy\Client\ClientInterface
     */
    protected ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @throws \DeepDigital\Loggy\Intergration\Exception\ProjectNotCreatedException
     * @return int
     */
    public function handle(): int
    {
        $this->processEnv();

        if (! $this->isEnvKeySet(Loggy::PROJECT_ENV_KEY)) {
            $this->info('No project key found.. creating one for you!');

            $project = $this->createProject();
            $this->setEnvValue(Loggy::PROJECT_ENV_KEY, $project['key']);
        }

        $this->recreateEnv();

        return Command::SUCCESS;
    }

    /**
     * Replaces the .env file with newly added values
     *
     * @return void
     */
    private function recreateEnv(): void
    {
        $envFilePath = app()->environmentFilePath();

        file_put_contents($envFilePath, $this->mapNewEnvContent());
    }

    private function mapNewEnvContent(): string
    {
        $content = '';
            $this->env->each(function ($item, $key) use (&$content) {
                // Check if the line should be a new line instead of a key /value pair
                if (str_starts_with($key, static::EMPTY_LINE_ENV_KEY)) {
                    return $content .= PHP_EOL;
                }

                return $content .= "$key=$item" . PHP_EOL;
            });

        return $content;
    }

    /**
     * Processes the .env file to a key/value array
     *
     * @return void
     */
    private function processEnv(): void
    {
        $envFilePath = app()->environmentFilePath();

        $envFileContents = file_get_contents($envFilePath);

        $this->env = collect(preg_split("/(\r\n|\n|\r)/", $envFileContents))
            ->push() // Push an extra space to the file
            ->mapWithKeys(function ($item, $oriKey) {

                // In order to preserve original line breaks we don't filter out empty lines
                if (str_contains($item, '=')) {
                    [$key, $value] = explode('=', $item);

                    return [$key => $value];
                }

                // identifier to later filter out these keys.
                return [static::EMPTY_LINE_ENV_KEY . $oriKey => $item];
            });
    }

    /**
     * Creates a project
     *
     * @throws \DeepDigital\Loggy\Intergration\Exception\ProjectNotCreatedException
     * @return array
     */
    private function createProject(): array
    {
        $name = $this->getEnvValue('APP_NAME') ?? Project::generateRandomName();

        try {
            $res = $this->client->post('projects', [
                'json' => ['name' => $name],
            ]);

            return $res;
        } catch (\Exception $e) {
            dd($e);
            throw new ProjectNotCreatedException("Could not create project. Failed to make request...");
        }
    }

    /**
     * Sets the env value.
     *
     * @param string $envKey
     * @param string $value
     *
     * @return null
     */
    private function setEnvValue(string $envKey, string $value)
    {
        $this->env[$envKey] = $value;

        return null;
    }

    /**
     * Check if a key is set in the current .env
     *
     * @param string $envKey
     *
     * @return bool
     */
    private function isEnvKeySet(string $envKey): bool
    {
        return $this->env->has($envKey);
    }

    /**
     * Fetches the value from an .env key.
     *
     * @param string $envKey
     *
     * @return string|null
     */
    private function getEnvValue(string $envKey): ?string
    {
        if ($this->env->has($envKey)) {
            return $this->env->get($envKey);
        }

        return null;
    }

    private function askForDsnInput(): string
    {
        if ($this->option('no-interaction')) {
            return '';
        }

        while (true) {
            $this->info('');

            $this->question('Please paste the DSN here');

            $dsn = $this->ask('DSN');

            // In case someone copies it with SENTRY_LARAVEL_DSN= or SENTRY_DSN=
            $dsn = Str::after($dsn, '=');

            try {
                Dsn::createFromString($dsn);

                return $dsn;
            } catch (Exception $e) {
                // Not a valid DSN do it again
                $this->error('The DSN is not valid, please make sure to paste a valid DSN!');
            }
        }
    }

    private function installJavaScriptSdk(): void
    {
        $framework = $this->choice(
            'Which frontend framework are you using?',
            [
                self::SDK_CHOICE_BROWSER,
                self::SDK_CHOICE_VUE,
                self::SDK_CHOICE_REACT,
                self::SDK_CHOICE_ANGULAR,
                self::SDK_CHOICE_SVELTE,
            ],
            self::SDK_CHOICE_BROWSER
        );

        $snippet = '';

        switch ($framework) {
            case self::SDK_CHOICE_BROWSER:
                $this->updateNodePackages(function ($packages) {
                    return [
                            '@sentry/browser' => '^7.40.0',
                        ] + $packages;
                });
                $snippet = file_get_contents(__DIR__.'/../../../../stubs/sentry-javascript/browser.js');
                break;
            case self::SDK_CHOICE_VUE:
                $this->updateNodePackages(function ($packages) {
                    return [
                            '@sentry/vue' => '^7.40.0',
                        ] + $packages;
                });
                $snippet = file_get_contents(__DIR__.'/../../../../stubs/sentry-javascript/vue.js');
                break;
            case self::SDK_CHOICE_REACT:
                $this->updateNodePackages(function ($packages) {
                    return [
                            '@sentry/react' => '^7.40.0',
                        ] + $packages;
                });
                $snippet = file_get_contents(__DIR__.'/../../../../stubs/sentry-javascript/react.js');
                break;
            case self::SDK_CHOICE_ANGULAR:
                $this->updateNodePackages(function ($packages) {
                    return [
                            '@sentry/angular' => '^7.40.0',
                        ] + $packages;
                });
                $snippet = file_get_contents(__DIR__.'/../../../../stubs/sentry-javascript/angular.js');
                break;
            case self::SDK_CHOICE_SVELTE:
                $this->updateNodePackages(function ($packages) {
                    return [
                            '@sentry/svelte' => '^7.40.0',
                        ] + $packages;
                });
                $snippet = file_get_contents(__DIR__.'/../../../../stubs/sentry-javascript/svelte.js');
                break;
        }

        $env['VITE_SENTRY_DSN_PUBLIC'] = '"${SENTRY_LARAVEL_DSN}"';
        $this->setEnvValues($env);

        if (file_exists(base_path('pnpm-lock.yaml'))) {
            $this->runCommands(['pnpm install']);
        } elseif (file_exists(base_path('yarn.lock'))) {
            $this->runCommands(['yarn install']);
        } else {
            $this->runCommands(['npm install']);
        }

        $this->newLine();
        $this->components->info('Sentry JavaScript SDK installed successfully.');
        $this->line('Put the following snippet into your JavaScript entry file:');
        $this->newLine();
        $this->line('<bg=blue>'.$snippet.'</>');
        $this->newLine();
        $this->line('For the best Sentry experience, we recommend you to set up dedicated projects for your Laravel and JavaScript applications.');
    }

    private function updateNodePackages(callable $callback)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages['dependencies'] = $callback(
            array_key_exists('dependencies', $packages) ? $packages['dependencies'] : [],
            'dependencies'
        );

        ksort($packages['dependencies']);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    private function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });
    }
}
