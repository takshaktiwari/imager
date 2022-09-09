<?php

namespace Takshak\Imager;

use Illuminate\Support\ServiceProvider;
use Takshak\Imager\Console\SeedImagesCommand;

class ImagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->commands([SeedImagesCommand::class]);
    }

    public function provides()
    {
    }

    public function register()
    {
    }
}
