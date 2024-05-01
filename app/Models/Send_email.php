<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Send_email extends Model
{
    use HasFactory;
    protected $table = 'notifications';

    protected $fillable =[
        'type',
        'notifiable_type',
        'data',

    ];

}
