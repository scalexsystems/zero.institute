<?php

namespace Scalex\Zero\Models;

use Znck\Trust\Models\Role as TrustRole;
use Scalex\Zero\User;

class Role extends TrustRole {
    public function users() {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('school_id');
    }
}
