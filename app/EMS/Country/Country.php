<?php

namespace App\EMS\Country;


use App\EMS\State\State;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

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

    public const STATUS_CONSTANT = [
        '1' => 'Enabled',
        '2' => 'Disabled',
    ];

    public function states()
    {
        return $this->hasMany(State::class, 'country_id', 'id');
    }
}
