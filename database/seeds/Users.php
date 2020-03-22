<?php

use Illuminate\Database\Seeder;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            "name" => "zaldi",
            "email" => "mrizaldi2@gmail.com",
            "password" => bcrypt("cau")
        ]);
    }
}
