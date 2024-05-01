<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report_table extends Model
{
    use HasFactory;
    protected $table = 'Report_table';

    protected $fillable = [
        'date_of_report',
        'report_type',
        'report_name',
        'department_involved',
        'description',
        'is_active',
        'user_id',
        'user_verify_id',
        'report_status',
        'remarks',
    ];

    protected $casts = [
        'Report_status_active' => 'boolean',
    ];
}
