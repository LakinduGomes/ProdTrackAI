<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'first_name', 'last_name', 'date_of_birth', 'gender', 'national_id', 'profile_photo',
        'personal_email', 'work_email', 'phone',
        'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relation',
        'address_line1', 'address_line2', 'city', 'state', 'postal_code', 'country',
        'employee_code', 'job_title', 'department', 'employment_type', 'employment_status',
        'joining_date', 'probation_end_date', 'resignation_date', 'termination_date',
        'reporting_manager_id', 'basic_salary', 'bank_name', 'bank_branch', 'bank_account_number',
        'highest_qualification', 'field_of_study',
        'user_id', 'notes', 'status', 'created_by',
    ];

    protected $casts = [
        'date_of_birth'       => 'date',
        'joining_date'        => 'date',
        'probation_end_date'  => 'date',
        'resignation_date'    => 'date',
        'termination_date'    => 'date',
        'basic_salary'        => 'decimal:2',
    ];

    // Linked system user account
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Reporting manager (also an employee)
    public function reportingManager()
    {
        return $this->belongsTo(Employee::class, 'reporting_manager_id');
    }

    // Department name via join model
    public function departmentInfo()
    {
        return $this->belongsTo(UserDepartment::class, 'department');
    }

    // Tasks assigned to this employee's linked user account
    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_user_id', 'user_id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}