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

        Permission::create(['name' => 'add books']);

        $librarian->givePermissionTo('add books');
    }
}
