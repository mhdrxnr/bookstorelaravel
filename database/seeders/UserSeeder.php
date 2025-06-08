<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users =
             [
               [ 'email'=>'adminamine@gmail.com',
                'password'=>Hash::make('admin123'),
                'role'=>'admin'],
                [
                'email'=>'clientahmed@gmail.com',
                'password'=>Hash::make('client123'),
                'role'=>'client' 
                ]
             ];

             foreach ($users as $user)
             User::create($user);
    }
}
