<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employeedetails extends Model
{
    use HasFactory;
    protected $table = 'employee_details';


    protected $fillable = [
        'user_id',
        'birthday',
        'address',
        'gender',
        'contact_number',
        'first_name',
        'last_name',
    ];
}
