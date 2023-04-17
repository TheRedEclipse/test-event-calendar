<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRoleId = UserRole::whereName('admin')->first()->id;

        $userRoleId = UserRole::whereName('user')->first()->id;

        $users = [
            [
                'username' => 'admin',
                'password' => Hash::make('password'),
                'user_role_id' => $adminRoleId
                
            ],
            [
                'username' => 'user',
                'password' => Hash::make('password'),
                'user_role_id' => $userRoleId
            ]
        ];

        User::insert($users);
    }
}
