<?php

declare(strict_types=1);

namespace Bvtterfly\Replay;

use Bvtterfly\Replay\Commands\CacheReset;
use Bvtterfly\Replay\Contracts\Policy;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ReplayServiceProvider extends PackageServiceProvider
{
    public function packageBooted()
    {
        Blade::directive('idempotencytoken', function () {
            return "<input hidden value=\"<?php echo \Illuminate\Support\Str::uuid(); ?>\" name=\"<?php echo config('replay.header_name'); ?>\">";
        });
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('replay')
            ->hasTranslations()
            ->hasConfigFile()
            ->hasCommands(
                CacheReset::class,
            );
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Policy::class, config('replay.policy'));
        $this->app->singleton(Storage::class, fn () => new Storage(Cache::store(config('replay.use'))));
        $this->app->alias(Storage::class, 'replay-storage');
    }
}
