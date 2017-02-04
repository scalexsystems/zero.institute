<?php

namespace Scalex\Zero\Events\Group;

use Illuminate\Support\Collection;
use Scalex\Zero\Models\Group;

class MemberLeft extends AbstractGroupEvent
{
    public $members;

    /**
     * MemberLeft constructor.
     *
     * @param \Scalex\Zero\Models\Group $group
     * @param \Illuminate\Support\Collection $members
     */
    public function __construct(Group $group, Collection $members)
    {
        parent::__construct($group);

        $this->members = $members;
    }
}
