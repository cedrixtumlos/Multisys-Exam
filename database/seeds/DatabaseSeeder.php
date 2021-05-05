<?php

use App\User;
use App\Products;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
        User::truncate();
        Products::truncate();
       
        // $this->call(UserSeeder::class);
        factory(User::class,10)->create();
        factory(Products::class,10)->create();
        
    }
}
