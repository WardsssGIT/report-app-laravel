<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temp_data extends Model
{
    use HasFactory;
    protected $table = 'temporary_data';

    protected $fillable = [
        'date_of_report',
        'report_type',
        'report_name',
        'department_id',
        'description',
        'is_active',
        'user_id',
        'user_verify_id',
        'report_status',
        'remarks',
    ];
}
