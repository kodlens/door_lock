<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppLog extends Model
{
    use HasFactory;


    protected $table = 'app_logs';
    protected $primaryKey = 'id';
    
    protected $fillable = ['user_id', 
        'user', 'activity', 
        'role', 
        'door_id', 'door',
        'schedule_id',
        'log_type'
    ];

}
