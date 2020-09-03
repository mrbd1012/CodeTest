<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Admin User';
        $user->email = 'admin@abc.com';
        $user->password = Hash::make('123456');
        $user->role = 'administrator';
        $user->save();
    }
}
