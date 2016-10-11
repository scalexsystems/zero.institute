<?php namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Database\ExtendibleModel;
use Scalex\Zero\User;
use Znck\Attach\Contracts\Attachment as AttachmentContract;

class Attachment extends ExtendibleModel implements AttachmentContract
{
    use \Znck\Attach\Traits\Attachment;

    use SoftDeletes;

    protected $fillable = [
        'title',
        'filename',
        'collection',
        'disk',
        'path',
        'mime',
        'visibility',
        'size',
        'order',
        'manipulations',
        'properties',
    ];

    protected $casts = [
        'manipulations' => 'array',
        'properties' => 'array',
    ];

    public function owner() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function related() {
        return $this->morphTo();
    }

    public function getAttachmentKeyName() : string {
        return 'uuid';
    }
}
