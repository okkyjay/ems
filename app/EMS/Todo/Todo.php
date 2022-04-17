<?php

namespace App\EMS\Todo;


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

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'due_date',
    ];
}
