<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'dateofreport',
        'reporttype',
        'vesselname',
        'departmentinvolved',
        'description',
        'rank',
        'name',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
