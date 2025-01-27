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
        $users = array(
            array('id' => '106','management_id' => '1'),
            array('id' => '123','management_id' => '1'),
            array('id' => '158','management_id' => '1'),
            array('id' => '166','management_id' => '1'),
            array('id' => '40','management_id' => '4'),
            array('id' => '168','management_id' => '4'),
            array('id' => '227','management_id' => '4'),
            array('id' => '269','management_id' => '4'),
            array('id' => '303','management_id' => '4'),
            array('id' => '304','management_id' => '4'),
            array('id' => '313','management_id' => '4'),
            array('id' => '53','management_id' => '5'),
            array('id' => '114','management_id' => '5'),
            array('id' => '120','management_id' => '5'),
            array('id' => '191','management_id' => '5'),
            array('id' => '249','management_id' => '5'),
            array('id' => '260','management_id' => '5'),
            array('id' => '287','management_id' => '5'),
            array('id' => '22','management_id' => '6'),
            array('id' => '50','management_id' => '6'),
            array('id' => '92','management_id' => '6'),
            array('id' => '137','management_id' => '6'),
            array('id' => '157','management_id' => '6'),
            array('id' => '205','management_id' => '6'),
            array('id' => '212','management_id' => '6'),
            array('id' => '253','management_id' => '6'),
            array('id' => '268','management_id' => '6'),
            array('id' => '270','management_id' => '6'),
            array('id' => '18','management_id' => '7'),
            array('id' => '152','management_id' => '7'),
            array('id' => '193','management_id' => '7'),
            array('id' => '199','management_id' => '7'),
            array('id' => '223','management_id' => '7'),
            array('id' => '230','management_id' => '7'),
            array('id' => '250','management_id' => '7'),
            array('id' => '257','management_id' => '7'),
            array('id' => '264','management_id' => '7'),
            array('id' => '292','management_id' => '7'),
            array('id' => '307','management_id' => '7'),
            array('id' => '331','management_id' => '7'),
            array('id' => '14','management_id' => '8'),
            array('id' => '131','management_id' => '8'),
            array('id' => '132','management_id' => '8'),
            array('id' => '36','management_id' => '9'),
            array('id' => '200','management_id' => '9'),
            array('id' => '266','management_id' => '9'),
            array('id' => '293','management_id' => '9'),
            array('id' => '301','management_id' => '9'),
            array('id' => '309','management_id' => '9')
          );
        $users = User::all();
        $management = Management::all();
        foreach ($users as $user) {
            $ramdom = $management->random();
            $user->management_id = $ramdom->id;
            $user->save();
        }
    }
}
