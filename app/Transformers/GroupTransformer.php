<?php namespace Scalex\Zero\Transformers;

use Request;
use Scalex\Zero\Models\Group;
use Scalex\Zero\User;
use Znck\Transformers\Transformer;

class GroupTransformer extends Transformer
{
    /**
     * Transform Group for details.
     *
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return array
     */
    public function show(Group $group)
    {
        return $this->index($group) + [
                'owner' => transform($group->owner),
            ];
    }

    /**
     * Transform Group for index.
     *
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return array
     */
    public function index(Group $group)
    {
        if ($user = Request::user()) {
            return $this->indexPartial($group) + $this->me($group, $user);
        }

        return $this->indexPartial($group);
    }

    /**
     * Transform group for authenticated user.
     *
     * @param \Scalex\Zero\Models\Group $group
     * @param \Scalex\Zero\User $user
     *
     * @return array
     */
    public function me(Group $group, User $user)
    {
        return [
            'is_member' => $user and $group->isMember($user),
            'is_admin' => $user and (int)$group->owner_id === (int)$user->id,
            'unread_count' => $group->getAttribute('messages_count'),
            'last_message_id' => $group->getAttribute('last_message_id'),
        ];
    }

    /**
     * Index transform helper.
     *
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return array
     */
    protected function indexPartial(Group $group): array
    {
        return [
            'name' => (string)$group->name,
            'description' => (string)$group->description,
            'photo' => attach_url($group->photo) ?? asset('img/placeholder-64.jpg'),
            'type' => (string)($group->type ?? 'group'),
            'type_text' => trans_choice('groups.private', $group->private ? 1 : 0),
            'private' => (bool)$group->private,
            'member_count' => (int)($group->members_count ?? 0),
            'member_count_text' => trans_choice('groups.count_members', $group->members_count ?? 0),
            'channel' => (string)$group->getChannelName(),
            'active_at' => $group->lastMessage ? iso_date($group->lastMessage->created_at) : null,
        ];
    }
}
