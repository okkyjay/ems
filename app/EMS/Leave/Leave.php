<?php

namespace App\EMS\Leave;


use App\EMS\Employee\Employee;
use App\EMS\LeaveType\LeaveType;
use App\Observers\LeaveActionObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Leave extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    public $table = 'leaves';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    protected $appends = [
        'attachment',
    ];

    protected $fillable = [
        'leave_from',
        'leave_to',
        'employee_remark',
        'leave_type_id',
        'employee_id',
        'status',
    ];

    public function getAttachmentAttribute()
    {
        $file = $this->getMedia('attachment')->last();
        if ($file) {
            $file->url = $file->getUrl();
        }
        return $file;
    }

    public const STATUS_CONSTANT = [
        '1' => 'Approved',
        '2' => 'Rejected',
        '0' => 'Pending',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public static function boot()
    {
        parent::boot();
        Leave::observe(new LeaveActionObserver());
    }
}
