<?php

namespace App\EMS\Department;


use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    public $table = 'departments';
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
