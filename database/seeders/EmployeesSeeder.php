<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesSeeder extends Seeder
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
            'id' => 1, // 'id' is a primary key, so it should be unique
            'name' => 'John Doe',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('employees')->upsert($data, ['id']);
    }
}
