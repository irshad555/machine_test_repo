<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use function bcrypt;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        if (!User::where('id', 1)->exists()) {
            $user = new User();
            $user->id = 1;
            $user->name = "Super Admin";
            $user->email = "admin@admin.com";
            $user->password = bcrypt('password'); 
            $user->email_verified_at = Carbon::now();
            $user->created_at = Carbon::now();
            $user->updated_at = Carbon::now();
            $user->save();
        }  
    }

}
