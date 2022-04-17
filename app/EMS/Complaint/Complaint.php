<?php

namespace App\EMS\Complaint;


use App\EMS\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Complaint extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    public $table = 'complaints';

    protected $appends = [
        'attachment',
    ];

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
        'title',
        'description',
        'employee_id',
        'status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_CONSTANT = [
        '1' => 'Addressed',
        '2' => 'Pending',
        '3' => 'Rejected',
    ];

    public function getAttachmentAttribute()
    {
        $file = $this->getMedia('attachment')->last();
        if ($file) {
            $file->url = $file->getUrl();
        }
        return $file;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
