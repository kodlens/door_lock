<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DoorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data = [
            [
                'door_name' => 'DOOR 1',
                'mac_add' => '48:55:19:C8:C2:B9'
            ],
            [
                'door_name' => 'DOOR 2',
                'mac_add' => '48:55:19:C8:C2:B8'
            ],
       
        ];

        \App\Models\Door::insertOrIgnore($data);

    }
}