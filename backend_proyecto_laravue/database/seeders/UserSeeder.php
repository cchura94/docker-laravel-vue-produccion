<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = new User();
        $user->name = "admin";
        $user->email = "admin@mail.com";
        $user->password = bcrypt("admin54321");
        $user->save();

        $user = new User();
        $user->name = "cristian";
        $user->email = "cristian@mail.com";
        $user->password = bcrypt("cristian54321");
        $user->save();
        
    }
}
