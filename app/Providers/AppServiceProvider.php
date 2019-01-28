<?php

namespace App\Providers;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\ServiceProvider;
use App\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        //
        $events->listen(BuildingMenu::class, function (BuildingMenu $event){
            //verificamos si se ha configurado la aplicacion con 
            //informacion de la empresa y creado el ejercicio economico
            $config = Config::all();
            if ($config->isEmpty()) {
                $event->menu->add('CONFIGURACION');
                $event->menu->add([
                    'text'          => 'Configuracion',
                    'url'           => 'admin/config',
                    'icon_color'    => 'red',
                    'can'           => 'crear-ejercicio',
                ]);
            } else {
                $event->menu->add('INICIO');
                $event->menu->add([
                    'text'          => 'Configuracion',
                    'url'           => 'admin/config',
                    'icon_color'    => 'green',
                    'can'           => 'crear-ejercicio',
                ]);
            }
            

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
