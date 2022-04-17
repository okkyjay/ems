<?php

namespace App\EMS\LeaveType;


use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{

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
