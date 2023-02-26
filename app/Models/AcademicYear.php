<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;


    protected $table = 'academic_years';
    protected $primaryKey = 'ay_id';


    protected $fillable = [
        'ay_code',
        'ay_desc',
        'semester'
    ];


}
