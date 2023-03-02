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
            ],
            [
                'door_name' => 'DOOR 2',
            ],
            [
                'door_name' => 'DOOR 3',
            ],
            

        ];

        \App\Models\Door::insertOrIgnore($data);

    }
}
