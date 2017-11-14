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
            'api_token' => str_random(60),
        ]); // generic user

        $admin = User::forceCreate([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'api_token' => str_random(60),
        ]); // librarian

        $admin->assignRole('librarian');
    }
}
