<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_details extends Model
{
    use HasFactory;
    protected $table = 'employee_details';


    protected $fillable = [
        'user_id',
        'birthday',
        'address',
        'contact_number',
        'first_name',
        'last_name',
    ];
}
