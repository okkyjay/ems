<?php

namespace App\EMS\Employee;

use App\EMS\Complaint\Complaint;
use App\EMS\Notification\Notification;
use App\EMS\Payroll\Payroll;
use App\EMS\Todo\Todo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Employee extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable;
    use InteractsWithMedia;
    use SoftDeletes;

    public $table = 'employees';

    public function registerMediaConversions(Media $media = null): void
    {
            $this->addMediaConversion('thumb')->fit('crop', 50, 50);
            $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'employee_number',
        'gender',
        'address',
        'basic_salary',
        'access_code',
        'bank_account_number',
        'bank_account_name',
        'department_id',
        'designation_id',
        'bank_id',
        'state_id',
        'country_id',
        'status',
        'date_of_birth',
        'date_hired',
    ];

    public const STATUS_CONSTANT = [
        '1' => 'Active',
        '2' => 'Resigned',
        '3' => 'Sacked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'access_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'date_hired'
    ];

    protected $appends = [
        'avatar',
        'resume',
    ];

    public function getAvatarAttribute()
    {
        $file = $this->getMedia('avatar')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getResumeAttribute()
    {
        $file = $this->getMedia('resume')->last();
        if ($file) {
            $file->url = $file->getUrl();
        }
        return $file;
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'employee_id');
    }

    public function todos()
    {
        return $this->hasMany(Todo::class, 'employee_id');
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'employee_id');
    }

    public function employeeNotifications()
    {
        return $this->hasMany(Notification::class, 'employee_id', 'id');
    }
}
