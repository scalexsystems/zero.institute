<?php namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\User;

class Intent extends Model implements BelongsToSchool
{
    use SoftDeletes;

    protected $fillable = [
        'tag',
        'body',
        'remarks',
        'locked',
        'retry',
    ];

    protected $casts = [
        'body' => 'json',
        'locked' => 'bool',
        'retry' => 'bool',
    ];

    public function school() {
        return $this->belongsTo(School::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
