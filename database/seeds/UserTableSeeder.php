<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador',
            'email' => env('ADMIN_EMAIL', 'admin@send4.com.br'),
            'password' => app('hash')->make(env('ADMIN_PASSWORD', 'admin'))
        ]);
    }
}
