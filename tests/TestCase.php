<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createLibrarianRole()
    {
        $librarianRole = Role::create(['name' => 'librarian']);

        Permission::create(['name' => 'add books']);

        $librarianRole->givePermissionTo('add books');
    }

    protected function getLibrarian()
    {
        $this->createLibrarianRole();

        return tap(factory(User::class)->create(), function ($librarian) {
            $librarian->assignRole('librarian');
        });
    }
}
