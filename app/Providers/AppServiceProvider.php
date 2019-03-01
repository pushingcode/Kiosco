<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\ServiceProvider;
use App\Config;
use App\Ejercicio;
use Carbon\Carbon;
use App\Almacen;

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
                    'icon'          => 'tools',
                    'icon_color'    => 'red',
                    'can'           => 'crear-empresa',
                ]);
            } else {
                $event->menu->add('EMPRESA');
                $event->menu->add([
                    'text'          => 'Ajustes',
                    'icon'          => 'tools',
                    'icon_color'    => 'green',
                    'submenu'       => [
                        [
                            'text'          => 'Configuracion',
                            'url'           => route('config'),
                            'icon'          => 'tools',
                            'can'           => 'crear-empresa'
                        ],
                        [
                            'text'  => 'Impuestos',
                            'url'   => '#',
                            'icon'  => 'percent'
                        ],
                        [
                            'text'  => 'Ganacias',
                            'url'   => '#',
                            'icon'  => 'hand-holding-usd'
                        ]
                    ]
                ]);
                //seccion de almacen
                $almacen = Almacen::all();
                if ($almacen->isEmpty()) {
                    $event->menu->add([
                        'text'          => 'Crear Almacen',
                        'url'           => 'almacen/create',
                        'icon'          => 'warehouse',
                        'icon_color'    => 'red',
                        'can'           => 'crear-empresa',
                    ]);
                } else {
                    $event->menu->add([
                        'text'          => 'Almacenes',
                        'url'           => '/almacen',
                        'icon'          => 'warehouse',
                        'icon_color'    => 'green',
                        'can'           => 'crear-empresa',
                    ]);
                }
                
                //verificamos si existe un ejercicio y creamos el menu
                $fisc = Ejercicio::all();
                if ($fisc->isEmpty()) {
                    $event->menu->add([
                        'text'          => 'Ejercicio',
                        'url'           => 'ejercicio/create',
                        'icon'          => 'calendar-alt',
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
                            'icon'          => 'calendar-alt',
                            'icon_color'    => 'yellow',
                            'can'           => 'editar-ejercicio',
                        ]);
                    }
                    
                    if ($fisco['estado'] == 'cerrado') {
                        $event->menu->add([
                            'text'          => 'Ejercicio',
                            'url'           => 'ejercicio/create',
                            'icon'          => 'calendar-alt',
                            'icon_color'    => 'yellow',
                            'can'           => 'crear-ejercicio',
                        ]);
                    }

                    if ($fisco['estado'] == 'abierto') {
                        $event->menu->add([
                            'text'          => 'Ejercicio',
                            'url'           => '/ejercicio',
                            'icon'          => 'calendar-alt',
                            'icon_color'    => 'green',
                            'can'           => 'crear-ejercicio',
                        ]);
                        $event->menu->add('PRODUCTOS');
                        $event->menu->add([
                            'text'          => 'Categorias',
                            'url'           => 'categoria',
                            'icon'          => 'star',
                            'icon_color'    => 'aqua',
                            'can'           => 'crear-producto',
                        ]);
                        $event->menu->add([
                            'text'          => 'Crear Unidades',
                            'url'           => 'unidad',
                            'icon'          => 'boxes',
                            'icon_color'    => 'aqua',
                            'can'           => 'crear-producto',
                        ]);
                        $event->menu->add([
                            'text'          => 'Crear Producto',
                            'url'           => '#',
                            'icon'          => 'box',
                            'icon_color'    => 'aqua',
                            'can'           => 'crear-producto',
                        ]);
                        $event->menu->add('ENTRADAS');
                        $event->menu->add([
                            'text'          => 'Compras',
                            'url'           => '#',
                            'icon'          => 'cart-plus',
                            'icon_color'    => 'aqua',
                            'can'           => 'crear-compra',
                        ]);
                        $event->menu->add([
                            'text'          => 'Devolucion',
                            'url'           => '#',
                            'icon'          => 'cart-arrow-down',
                            'icon_color'    => 'red',
                            'can'           => 'editar-factura',
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
