<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Door;

class TestController extends Controller
{
    //

    
    public function test(){
        Door::create([
            'door_name' => 'DOOR',
            'mac_add' => 'sample test debug',
        ]);
    }
}
