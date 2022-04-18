<?php

namespace App\EMS\MessageConversation;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MessageConversation extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    public $table = 'message_conversations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chat_employee_id',
        'message_id',
        'message',
        'is_read',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    protected $appends = [
        'attachment',
    ];

    public function getAttachmentAttribute()
    {
        $file = $this->getMedia('attachment')->last();
        if ($file) {
            $file->url = $file->getUrl();
        }
        return $file;
    }

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
