<?php

namespace Takshak\Imager;
use Illuminate\Support\ServiceProvider;

class ImagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }   

    public function provides()
    {
       
    }

    public function register()
    {

    }

}