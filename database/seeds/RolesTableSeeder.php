<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $librarian = Role::create(['name' => 'librarian']);

        Permission::create(['name' => 'add users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'add books']);
        Permission::create(['name' => 'update books']);

        $librarian->givePermissionTo('add users');
        $librarian->givePermissionTo('update users');
        $librarian->givePermissionTo('add books');
        $librarian->givePermissionTo('update books');
    }
}
