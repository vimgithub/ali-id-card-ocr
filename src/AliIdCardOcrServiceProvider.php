<?php

namespace Zev\AliIdCardOcr;

use Illuminate\Support\ServiceProvider;


class AliIdCardOcrServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //发布配置文件（可根据需要发布配置、路由、控制器、前端文件、视图等）
      $this->publishes([
            __DIR__.'/config/aliIdCardOcr.php' => config_path('aliIdCardOcr.php')
        ], 'aliIdCardOCR-config');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Register the application bindings.
        $this->app->bind('aliIdCardOcr', function () {
            return new AliIdCardOcr();
        });


    }
}
