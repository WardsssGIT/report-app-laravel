<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeRole extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'department_id','userrole',
    ];

    /**
     * Get the user that owns the department.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the department associated with the employee role.
     */
    public function department()
    {
        return $this->belongsTo(Departments::class);
    }


}
