<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
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
            'name' => 'テスト太郎',
            'email'=> 'test@test.com',
            'password'=> Hash::make('test1234'),
            'ismanager'=> TRUE,
            'manager_id'=> 1,
            'created_at'=> new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('users')-> insert([
            'id' => 2,
            'name' => 'テスト２',
            'email'=> 'test2@test.com',
            'password'=> Hash::make('test1234'),
            'ismanager'=> FALSE,
            'manager_id'=> 1,
            'created_at'=> new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        DB::table('users')-> insert([
            'id' => 3,
            'name' => 'テスト３',
            'email'=> 'test3@test.com',
            'password'=> Hash::make('test1234'),
            'ismanager'=> FALSE,
            'manager_id'=> null,
            'created_at'=> new DateTime(),
            'updated_at' => new DateTime(),
        ]);

        User::factory(9)-> create();
    }
}
