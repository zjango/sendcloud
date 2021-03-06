<?php
/**
 */
namespace Zjango\Sendcloud;

use Illuminate\Support\ServiceProvider;

class SendcloudServiceProvider extends ServiceProvider
{

    public function boot()
    {
        \Auth::provider('sendcloud', function ($app) {
            return new Sendcloud();
        });
    }

    public function register()
    {
        // $this->app['sendcloud'] = $this->app->share(
        //     function ($app) {
        //         return new \Zjango\Sendcloud\Sendcloud();
        //     }
        // );

        $this->app->booting(
            function () {
                $aliases = \Config::get('app.aliases');

                if(empty($aliases['Zjango\SendcloudClass'])){
                    $loader = \Illuminate\Foundation\AliasLoader::getInstance();
                    $loader->alias('Zjango\SendcloudClass','Zjango\Sendcloud\Facades\SendcloudClass');
                }

            }
        );
    }


}