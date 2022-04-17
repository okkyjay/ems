<?php

namespace App\EMS\Notification;


use App\EMS\Employee\Employee;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    public $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'employee_id',
        'read',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
