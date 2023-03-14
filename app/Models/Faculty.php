<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculty';

    protected $primaryKey = 'faculty_id';
    protected $fillable = [
        'rfid',
        'lname', 
        'fname', 
        'mname', 
        'suffix',
        'sex',
        'contact_no', 
    ];
}
