<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report_table extends Model
{
    use HasFactory;
    protected $table = 'Report_table';

    protected $fillable = [
        'Date_of_report',
        'Report_type',
        'Report_name',
        'Department_involved',
        'Description',
        'is_Active',
        'User_id',
        'User_verify_id',
        'Report_status',
        'Remarks',
    ];

    protected $casts = [
        'Report_status_active' => 'boolean',
    ];
}
