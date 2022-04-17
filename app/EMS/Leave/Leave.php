<?php

namespace App\EMS\Leave;


use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{

    public $table = 'leaves';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'leave_from',
        'leave_to',
        'employee_remark',
        'leave_type_id',
        'employee_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
