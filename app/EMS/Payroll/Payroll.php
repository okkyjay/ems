<?php

namespace App\EMS\Payroll;


use App\EMS\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Payroll extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    public $table = 'payrolls';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'basic_salary',
        'tax_deduction',
        'employee_id',
        'net_salary',
        'month',
        'year',
        'status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_CONSTANT = [
        '1' => 'Paid',
        '2' => 'Pending',
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
