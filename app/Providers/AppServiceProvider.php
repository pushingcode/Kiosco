<?php

namespace App\Providers;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\ServiceProvider;
use App\Config;
use App\Ejercicio;
use Carbon\Carbon;

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
                    'can'           => 'crear-empresa',
                ]);
            } else {
                $event->menu->add('EMPRESA');
                $event->menu->add([
                    'text'          => 'Configuracion',
                    'url'           => 'admin/config',
                    'icon_color'    => 'green',
                    'can'           => 'crear-empresa',
                ]);
                //verificamos si existe un ejercicio y creamos el menu
                $fisc = Ejercicio::all();
                if ($fisc->isEmpty()) {
                    $event->menu->add([
                        'text'          => 'Ejercicio',
                        'url'           => 'ejercicio/create',
                        'icon_color'    => 'red',
                        'can'           => 'crear-ejercicio',
                    ]);
                } else {
                    //verificamos fechas para cierre
                    //paso1 cargamos el ultimo ejercicio
                    //paso2 verificamos si esta abierto
                    //paso3 verificamos si esta en fecha para cierre
                    $ejercicio = Ejercicio::orderBy('created_at', 'desc')->first(); // paso1
                    $fisco = $ejercicio->toArray();
                    $date = Carbon::parse($fisco['fin']);
                    if ($fisco['estado'] == 'abierto' && $date->isPast()) {
                        $event->menu->add([
                            'text'          => 'Ejercicio',
                            'url'           => 'ejercicio/"' .$fisco['id']. '"/edit',
                            'icon_color'    => 'yellow',
                            'can'           => 'editar-ejercicio',
                        ]);
                    }
                    
                    if ($fisco['estado'] == 'cerrado') {
                        $event->menu->add([
                            'text'          => 'Ejercicio',
                            'url'           => 'ejercicio/create',
                            'icon_color'    => 'yellow',
                            'can'           => 'crear-ejercicio',
                        ]);
                    }

                    if ($fisco['estado'] == 'abierto') {
                        $event->menu->add([
                            'text'          => 'Ejercicio',
                            'url'           => '/ejercicio',
                            'icon_color'    => 'green',
                            'can'           => 'crear-ejercicio',
                        ]);
                    }
                }
                
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
