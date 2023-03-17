<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        // 'name'=>"mohamed badah",
        // "email"=>"mohamed@g.com",
        // "password"=>Hash::make("password"),
        // "phone"=>'0597112096'
        // ]);

        DB::table('users')->insert([
            'name'=>"mohamed badah",
        "email"=>"mohamed@g.com",
        "password"=>Hash::make("password"),
        "phone"=>'0597112096'
        ]);
    }
}
