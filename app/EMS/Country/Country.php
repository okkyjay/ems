<?php

namespace App\EMS\Country;


use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    public $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'short_code',
        'status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
