<?php

namespace App\EMS\Todo;


use App\EMS\Employee\Employee;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'employee_id',
        'due_date'
    ];

    public const STATUS_CONSTANT = [
        '1' => 'Completed',
        '0' => 'Pending',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'due_date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
