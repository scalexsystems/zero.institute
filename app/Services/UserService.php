<?php

namespace Scalex\Zero\Services;

use Illuminate\Http\Request;
use Scalex\Zero\User;

class UserService
{
    public function current()
    {
        return app(Request::class)->user();
    }

    public function currentTransformed()
    {
        return transform($this->current(), ['person']);
    }
}
