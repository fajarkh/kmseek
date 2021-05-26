<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@kmsdayak.com',
            // 'password' => bcrypt('admin123'),
            'password' => app('hash')->make('admin123'),
            'level' => '1',
            'remember_token' => Str::random(10)
        ]);
    }
}
