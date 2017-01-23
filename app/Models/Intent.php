<?php namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\User;

class Intent extends BaseModel  implements BelongsToSchool
{
    use SoftDeletes;

    protected $fillable = [
        'tag',
        'body',
        'remarks',
        'locked',
        'status',
    ];

    protected $casts = [
        'body' => 'json',
        'locked' => 'bool',
        'closed' => 'bool',
    ];

    public function school() {
        return $this->belongsTo(School::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
