<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Group;
use Znck\Transformers\Transformer;

class GroupTransformer extends Transformer
{
    public function show(Group $group) {
        return $this->index($group) + [
            'owner' => transform($group->owner),
        ];
    }

    public function index(Group $group) {
        return [
            'name' => (string)$group->name,
            'bio' => trans_choice('groups.count_members', $group->count_members + 1 ?? 0).
                     ' ・ '.trans_choice('groups.private', $group->private ? 1 : 0),
            'photo' => attach_url($group->profilePhoto) ?? asset('img/placeholder-64.jpg'),
            'type' => is_null($group->school_id) ? 'open' : 'closed',
            'private' => (bool)$group->private,
            'member_count' => $group->count_members ?? 0,
            'channel' => $group->getChannelName(),
            'active_at' => $group->lastMessageAt ? iso_date($group->lastMessageAt->created_at) : null,
            'is_member' => $group->isMember(current_user()),
            'is_admin' => (int)$group->owner_id === (int)current_user()->id,
        ];
    }
}
