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
        $user = current_user();
        return [
            'name' => (string)$group->name,
            'description' => (string)$group->description,
            'photo' => attach_url($group->profilePhoto) ?? asset('img/placeholder-64.jpg'),
            'type' => (string) ($group->type ?? 'group'),
            'type_text' => trans_choice('groups.private', $group->private ? 1 : 0),
            'private' => (bool)$group->private,
            'member_count' => (int)($group->count_members ?? 0),
            'member_count_text' => trans_choice('groups.count_members', $group->count_members ?? 0),
            'channel' => (string)$group->getChannelName(),
            'active_at' => $group->lastMessageAt ? iso_date($group->lastMessageAt->created_at) : null,
            'is_member' =>  $user and $group->isMember($user),
            'is_admin' => $user and (int)$group->owner_id === (int)$user->id,
        ];
    }
}
