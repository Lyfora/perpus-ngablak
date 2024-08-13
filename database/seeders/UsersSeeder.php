<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        //
        $data = [
            'name' => 'Admin Utama Perpus',
            'email' => 'axelliano95@gmail.com',
            'password' => bcrypt('Ngablak1234!'),
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->upsert($data, ['email']);
    }
}
