<?php

namespace Scalex\Zero\Models;

use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\User;

class Role extends BaseModel implements \Znck\Trust\Contracts\Role
{
    use \Znck\Trust\Traits\Role;

    protected $fillable = ['name', 'slug', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('school_id');
    }
}
