<?php

namespace App\EMS\Holiday;


use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{

    public $table = 'holidays';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'start_date',
        'end_date'
    ];
}
