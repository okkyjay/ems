<?php

namespace App\EMS\LeaveType;


use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{

    public $table = 'leave_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
