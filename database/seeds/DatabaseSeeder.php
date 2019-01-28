<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // disparador para todos los Seeders
        //verificamos si el usuario Superadmin existe
        $user = User::all();
        if (count($user) == 0) {
        	$this->call('UsersTableSeeder');
        	$this->command->info('Los usuarios han sido creados!');

            $this->call('RolesAndPermissionsSeeder');
            $this->command->info('Los permisos y roles se han creado!');

        } else {
        	$this->command->info('la tabla usuarios no se encuenta vacia, no es posible ejecutar el Seed');
        }
        
        
    }

}

class UsersTableSeeder extends Seeder 
{
    public function run()
    {
       //corriendo seeding para users
        $timer = Carbon\Carbon::now()->format('Y-m-d H:i:s');
        
        $users =[
        'usuario1' => array(
                'user'      => 'superadmin',
                'email'     => config('app.super_email'),
                'password'  => bcrypt(config('app.super_password'))
                ),
        ];

        foreach ($users as $value) {
            \DB::table('users')->insert([
            'name'      		=> $value['user'],
            'email'     		=> $value['email'],
            'password' 		 	=> $value['password'],
            'created_at'    	=> $timer,
            'updated_at'   		=> $timer
            ]);
        }
        
        
    }

}
/**
 * Clase para creacion y asignacion de roles y permisos basados en
 * Spatie/permission
 * @TODO completar los permisos a los roles planteados
 * @return void
 */
class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // create permissions

        Permission::create(['name' => 'crear-ejercicio']);
        Permission::create(['name' => 'editar-ejercicio']);
        Permission::create(['name' => 'eliminar-ejercicio']);

        Permission::create(['name' => 'crear-permisos']);
        Permission::create(['name' => 'editar-permisos']);
        Permission::create(['name' => 'eliminar-permisos']);
        Permission::create(['name' => 'ver-lista-permisos']);

        Permission::create(['name' => 'crear-usuario']);
        Permission::create(['name' => 'editar-usuario']);
        Permission::create(['name' => 'eliminar-usuario']);
        Permission::create(['name' => 'ver-lista-usuario']);
        Permission::create(['name' => 'activar-usuario']);
        Permission::create(['name' => 'desactivar-usuario']);

        Permission::create(['name' => 'crear-producto']);
        Permission::create(['name' => 'editar-producto']);
        Permission::create(['name' => 'eliminar-producto']);
        Permission::create(['name' => 'ver-lista-producto']);
        Permission::create(['name' => 'activar-producto']);
        Permission::create(['name' => 'desactivar-producto']);

        Permission::create(['name' => 'crear-inventario']);
        Permission::create(['name' => 'ver-lista-inventario']);
        Permission::create(['name' => 'agregar-inventario']);
        Permission::create(['name' => 'extraer-inventario']);
        Permission::create(['name' => 'eliminar-inventario']);
        Permission::create(['name' => 'activar-inventario']);
        Permission::create(['name' => 'desactivar-inventario']);

        Permission::create(['name' => 'crear-impuestos']);
        Permission::create(['name' => 'agregar-impuestos']);
        Permission::create(['name' => 'eliminar-impuestos']);
        Permission::create(['name' => 'ver-lista-impuestos']);

        Permission::create(['name' => 'crear-documento']);
        Permission::create(['name' => 'editar-documento']);
        Permission::create(['name' => 'eliminar-documento']);
        Permission::create(['name' => 'ver-lista-documento']);

        Permission::create(['name' => 'crear-nota-credito']);
        Permission::create(['name' => 'editar-nota-credito']);
        Permission::create(['name' => 'eliminar-nota-credito']);
        Permission::create(['name' => 'ver-lista-nota-credito']);

        Permission::create(['name' => 'crear-nota-debito']);
        Permission::create(['name' => 'editar-nota-debito']);
        Permission::create(['name' => 'eliminar-nota-debito']);
        Permission::create(['name' => 'ver-lista-nota-debito']);

        Permission::create(['name' => 'crear-factura']);
        Permission::create(['name' => 'editar-factura']);
        Permission::create(['name' => 'eliminar-factura']);
        Permission::create(['name' => 'ver-lista-factura']);

        Permission::create(['name' => 'crear-presupuesto']);
        Permission::create(['name' => 'editar-presupuesto']);
        Permission::create(['name' => 'eliminar-presupuesto']);
        Permission::create(['name' => 'ver-lista-presupuesto']);

        Permission::create(['name' => 'crear-compra']);
        Permission::create(['name' => 'editar-compra']);
        Permission::create(['name' => 'eliminar-compra']);
        Permission::create(['name' => 'actualizar-compra']);
        Permission::create(['name' => 'ver-lista-compra']);
        
        Permission::create(['name' => 'crear-pedido']);
        Permission::create(['name' => 'editar-pedido']);
        Permission::create(['name' => 'eliminar-pedido']);
        Permission::create(['name' => 'actualizar-pedido']);
        Permission::create(['name' => 'ver-lista-pedido']);

        Permission::create(['name' => 'crear-empresa']);
        Permission::create(['name' => 'editar-empresa']);
        Permission::create(['name' => 'eliminar-empresa']);
        Permission::create(['name' => 'actualizar-empresa']);
        Permission::create(['name' => 'ver-lista-empresa']);

        Permission::create(['name' => 'crear-cliente']);
        Permission::create(['name' => 'editar-cliente']);
        Permission::create(['name' => 'eliminar-cliente']);
        Permission::create(['name' => 'actualizar-cliente']);
        Permission::create(['name' => 'ver-lista-cliente']);

        // create roles and assign existing permissions
        $role = Role::create(['name' => 'superadmin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'gerencia']);
        $role->givePermissionTo([
            'crear-ejercicio',
            'crear-usuario',
            'editar-usuario',
            'eliminar-usuario',
            'ver-lista-usuario',
            'activar-usuario',
            'desactivar-usuario',
            'crear-producto',
            'editar-producto',
            'eliminar-producto',
            'ver-lista-producto',
            'activar-producto',
            'desactivar-producto',
            'crear-inventario',
            'ver-lista-inventario',
            'agregar-inventario',
            'extraer-inventario',
            'activar-inventario',
            'desactivar-inventario',
            'crear-impuestos',
            'agregar-impuestos',
            'crear-documento',
            'editar-documento',
            'eliminar-documento',
            'ver-lista-documento',
            'crear-nota-credito',
            'editar-nota-credito',
            'eliminar-nota-credito',
            'ver-lista-nota-credito',
            'crear-nota-debito',
            'editar-nota-debito',
            'eliminar-nota-debito',
            'ver-lista-nota-debito',
            'crear-factura',
            'editar-factura',
            'eliminar-factura',
            'ver-lista-factura',
            'crear-presupuesto',
            'editar-presupuesto',
            'eliminar-presupuesto',
            'ver-lista-presupuesto',
            'crear-compra',
            'editar-compra',
            'eliminar-compra',
            'actualizar-compra',
            'ver-lista-compra',
            'crear-pedido',
            'editar-pedido',
            'eliminar-pedido',
            'ver-lista-pedido',
            'actualizar-pedido',
            'crear-empresa',
            'editar-empresa',
            'eliminar-empresa',
            'actualizar-empresa',
            'ver-lista-empresa',
            'crear-cliente',
            'editar-cliente',
            'eliminar-cliente',
            'actualizar-cliente',
            'ver-lista-cliente',
        ]);
        
        $role = Role::create(['name' => 'almacen']);
        $role->givePermissionTo([
            'crear-producto',
            'editar-producto',
            'eliminar-producto',
            'activar-producto',
            'desactivar-producto',
            'ver-lista-producto',
            'ver-lista-inventario',
            'agregar-inventario',
            'extraer-inventario',
            'crear-documento',
            'editar-documento',
            'eliminar-documento',
            'ver-lista-documento',
            'crear-pedido',
            'editar-pedido',
            'actualizar-pedido',
            'ver-lista-pedido',
        ]);

        $role = Role::create(['name' => 'caja']);
        $role->givePermissionTo([
            'crear-nota-debito',
            'crear-factura',
            'crear-presupuesto',
            'editar-presupuesto',
            'crear-cliente',
            'editar-cliente',
            'actualizar-cliente',
        ]);


        $user = \App\User::find(1);
        
        $user->assignRole('superadmin');

        //$role = Role::create(['name' => 'admin']);
        //$role->givePermissionTo(['publish articles', 'unpublish articles']);
    }
}
