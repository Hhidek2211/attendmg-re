<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use DateTime;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')-> insert([
            'id' => 1,
            'name' => 'てす太郎',
            'email'=> 'test@test.com',
            //'email_verified_at'=> 'test@test.com',
            'password'=> Hash::make('test1234'),
            'ismanager'=> TRUE,
            'manager_id'=> null,
            'created_at'=> new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
