<?php

namespace App\EMS\Designation;


use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{

    public $table = 'designations';

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
