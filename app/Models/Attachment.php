<?php namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Scalex\Zero\User;
use Znck\Attach\Contracts\Attachment as AttachmentContract;

class Attachment extends BaseModel implements AttachmentContract
{
    use \Znck\Attach\Traits\Attachment;

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
}
