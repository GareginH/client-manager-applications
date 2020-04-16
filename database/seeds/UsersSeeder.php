<?php

use App\User;
use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->truncate();
        User::truncate();
        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@manager.com',
            'password' => Hash::make('password')
        ]);
        $managerRole = Role::where('name', 'manager')->first();
        $manager->roles()->attach($managerRole);
    }
}
