<?php
namespace WAIntegration;
use Illuminate\Support\ServiceProvider;
use WAIntegration\Services\InstanceService;
use WAIntegration\Services\MessageService;
use WAIntegration\WAconnection;

class WAServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->publishes([
            __DIR__ . '/../config/wa_integration.php' => config_path('wa_integration.php'),
            __DIR__ . '/../routes/wa_integration.php' => base_path('/routes/wa_integration.php')
        ]);
    }

    public function register(){
        $this->app->singleton(WAconnection::class,function (){
            return new WAconnection();
        });

        $this->app->bind('Instance', function ($app) {
            return new InstanceService();
        });

        $this->app->bind('Message', function ($app) {
            return new MessageService();
        });
    }
}
