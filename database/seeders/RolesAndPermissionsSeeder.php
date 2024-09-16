<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create articles']);
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'view articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);
        Permission::create(['name' => 'draft articles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'delete roles']);
        Permission::create(['name' => 'edit roles']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'delete permissions']);
        Permission::create(['name' => 'edit permissions']);
        Permission::create(['name' => 'comment']);

        // create role and assign permissions
        Role::create(['name' => 'author'])
            ->givePermissionTo(['create articles', 'edit articles', 'delete articles', 'view articles', 'publish articles', 'draft articles', 'unpublish articles']);

        Role::create(['name' => 'super-admin'])
            ->givePermissionTo(Permission::all());

        Role::create(['name' => 'viewer'])
            ->givePermissionTo(['view articles', 'comment']);
    }
}
