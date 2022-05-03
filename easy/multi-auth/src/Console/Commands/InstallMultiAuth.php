<?php

namespace Easy\MultiAuth\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class InstallMultiAuth extends Command
{
    const PATH = '/../../../stubs/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easy:multi-auth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish frontend assets and view files from easy theme to laravel application.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Update the "package.json" file.
     *
     * @param callable $callback
     * @param bool $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, bool $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    /**
     * @return void installInertiaVueStack
     */
    public function handle()
    {
        try {
            $this->installDependencies();

            $this->publishContents();

            $this->info('Project scaffolding installed successfully.');
            $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            $this->info('Something went wrong. Please check log file to fix and try again.');
        }
    }

    /**
     * @return void
     */
    public function installDependencies()
    {

        // Install Inertia...
        $this->requireComposerPackages(
            'inertiajs/inertia-laravel:^0.5.4',
            'laravel/sanctum:^2.8',
            'tightenco/ziggy:^1.0',
            'intervention/image: ^2.7'
        );
        $this->info('Composer packages gathered.');

        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                    '@inertiajs/inertia' => '^0.11.0',
                    '@inertiajs/inertia-vue3' => '^0.6.0',
                    '@inertiajs/progress' => '^0.2.6',
                    '@tailwindcss/forms' => '^0.4.0',
                    '@vue/compiler-sfc' => '^3.2.30',
                    'autoprefixer' => '^10.4.2',
                    'postcss' => '^8.4.6',
                    'postcss-import' => '^14.0.2',
                    'tailwindcss' => '^3.0.18',
                    'vue' => '^3.2.30',
                    'vue-loader' => '^16.1.2',
                    'alpinejs' => '^3.4.2',
                    '@mdi/font' => '^6.5.95',
                    'chart.js' => '^3.7.1',
                    'vue-chart-3' => '^3.1.4',
                    'vuedraggable' => '^4.1.0',
                    '@tinymce/tinymce-vue' => '^4.0.7',
                    'swiper' => '^8.0.7'
                ] + $packages;
        });
        $this->info('NPM packages gathered.');
    }

    /**
     * @return void
     */
    public function publishContents()
    {
        // Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views'));
        (new Filesystem)->ensureDirectoryExists(resource_path('css'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js'));
        (new Filesystem)->copyDirectory(__DIR__ . self::PATH . 'resources', resource_path());
        $this->info('resources published.');

        (new Filesystem)->ensureDirectoryExists(database_path('migrations'));
        (new Filesystem)->copyDirectory(__DIR__ . self::PATH . 'database/migrations', database_path('migrations'));
        $this->info('database table published.');

        Artisan::call('migrate');
        $this->info('database migrated');

        // Tailwind / Webpack...
        copy(__DIR__ . self::PATH . 'tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__ . self::PATH . 'webpack.mix.js', base_path('webpack.mix.js'));
        copy(__DIR__ . self::PATH . 'webpack.config.js', base_path('webpack.config.js'));
        copy(__DIR__ . self::PATH . 'jsconfig.json', base_path('jsconfig.json'));
        $this->info('config, json, mix files are published.');
    }

    /**
     * Installs the given Composer Packages into the application.
     *
     * @param mixed $packages
     * @return void
     */
    protected function requireComposerPackages($packages)
    {
        $command = array_merge(
            $command ?? ['composer', 'require'],
            is_array($packages) ? $packages : func_get_args()
        );

        (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }
}
