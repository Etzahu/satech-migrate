<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Management;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserManageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $management = Management::all();
        foreach ($users as $user) {
            $ramdom = $management->random();
            $user->management_id = $ramdom->id;
            $user->save();
        }
    }
}
