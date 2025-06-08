<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

            

             Client::create(
                 [ 
            'firstName'=> 'ahmed',
            'lastName'=> 'dedouch',
            'wilaya'=> 'jelfa',
            'address'=> 'siyada',
            'number'=> '1234567891',
            'userID'=>'2'
             ]
             );
    }
}
