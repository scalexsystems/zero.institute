<?php
use Scalex\Zero\Models\Group;

class CurrentUserControllerTest extends TestCase
{
    public function createGroup($attributes = [])
    {
        return factory(Group::class)->create($attributes);
    }

    public function test_it_can_list_all_groups()
    {
        $user = $this->createAnUser();
        $groups = factory(Group::class, 2)->create([
            'school_id' => $user->school_id,
            'owner_id' => $user->id,
        ]);

        collect($groups)->each(function ($group) use ($user) {
            $group->addMembers([$user->id]);
        });

        $this->actingAs($user)
            ->json('GET', "/api/me/groups")
            ->seeStatusCode(200)
            ->seeJsonContains(transform($groups));
    }

    public function test_it_can_join_group()
    {
        $user = $this->createAnUser();
        $group = $this->createGroup(['school_id' => $user->school_id, 'private' => false]);

        $this->actingAs($user)
            ->json('POST', "/api/groups/{$group->id}/join")
            ->seeStatusCode(200)
            ->seeInDatabase('group_user', [
                'user_id' => $user->id,
                'group_id' => $group->id,
            ]);
    }

    public function test_it_can_remove_members()
    {
        $user = $this->createAnUser();
        $group = $this->createGroup(['school_id' => $user->school_id]);
        $group->addMembers([$user->id]);

        $this->actingAs($user)
            ->json('DELETE', "/api/groups/{$group->id}/leave")
            ->seeStatusCode(202)
            ->dontSeeInDatabase('group_user', [
                'user_id' => $user->id,
                'group_id' => $group->id,
            ]);
    }
}
