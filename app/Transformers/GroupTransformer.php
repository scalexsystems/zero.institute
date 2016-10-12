<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Group;
use Znck\Transformers\Transformer;

class GroupTransformer extends Transformer
{
    public function show(Group $group) {
        return [
            'name' => (string)$group->name,
            'photo' => attach_url($group->profilePhoto) ?? asset('img/placeholder-64.jpg'),
            'owner' => transform($group->owner),
            'member_count' => $group->members()->count(),
        ];
    }

    public function index(Group $group) {
        return [
            'name' => (string)$group->name,
            'photo' => attach_url($group->profilePhoto) ?? asset('img/placeholder-64.jpg'),
        ];
    }
}
