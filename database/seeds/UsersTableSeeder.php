<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::forceCreate([
            'name' => 'Miranda Jones',
            'email' => 'miranda@example.com',
            'password' => bcrypt('password'),
        ]); // generic user

        $admin = User::forceCreate([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]); // librarian

        $admin->assignRole('librarian');
    }
}
