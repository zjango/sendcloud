<?php
/**
 */
namespace Zjango\Sendcloud;

use Illuminate\Support\ServiceProvider;

class SendcloudServiceProvider extends ServiceProvider
{

    public function boot()
    {
        require_once(dirname(dirname(__DIR__)).'/config/sendcloud.php');
    }

    public function register()
    {
        $this->app['sendcloud'] = $this->app->share(
            function ($app) {
                return new \Zjango\Sendcloud\Sendcloud();
            }
        );

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