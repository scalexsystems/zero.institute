<?php

use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Student;

class GroupControllerTest extends TestCase
{
    public function test_it_can_list_groups()
    {
        $user = $this->createAnUser();
        factory(Group::class, 2)->create(['school_id' => $user->school_id, 'private' => false]);
        factory(Group::class)->create(['school_id' => $user->school_id, 'private' => true]);

        $this->actingAs($user)
            ->json('GET', '/api/groups')
            ->seeJson()
            ->seeJsonContains(transform(Group::where('private', false)->paginate()));
    }
    public function test_it_shows_group()
    {
        $user = $this->createAnUser();
        $group = factory(Group::class)->create(['school_id' => $user->school_id]);

        $this->actingAs($user)
            ->json('GET', "/api/groups/{$group->id}")
            ->seeJson()
            ->seeJsonContains(transform($group));
    }

    public function test_it_can_create_a_group()
    {
        $user = $this->createAnUser();
        $data = [
            'name' => 'Test Group',
        ];
        $user->person()->associate(factory(Student::class)->create(['school_id' => $user->school_id]));
        $user->save();

        $this->actingAs($user)
            ->json('POST', '/api/groups', $data)
            ->seeStatusCode(200)
            ->seeJsonContains($data)
            ->seeInDatabase('groups', $data)
            ->seeInDatabase('group_user', ['user_id' => $user->id]);
        ;
    }

    public function test_it_can_create_a_group_with_members()
    {
        $user = $this->createAnUser();
        $other = $this->createAnUser(['school_id' => $user->school_id]);
        $data = [
            'name' => 'Test Group',
            'members' => [$other->id],
        ];
        $user->person()->associate(factory(Student::class)->create(['school_id' => $user->school_id]));
        $user->save();

        $this->actingAs($user)
            ->json('POST', '/api/groups', $data)
            ->seeStatusCode(200)
            ->seeInDatabase('group_user', ['user_id' => $other->id]);
    }

    public function test_it_can_update_a_group()
    {
        $user = $this->createAnUser();
        $group = factory(Group::class)->create(['school_id' => $user->school_id, 'owner_id' => $user->id]);
        $data = ['name' => 'Test Group'];

        $user->person()->associate(factory(Student::class)->create(['school_id' => $user->school_id]));
        $user->save();

        $this->actingAs($user)
            ->json('PUT', "/api/groups/{$group->id}", $data)
            ->seeStatusCode(200)
            ->seeJsonContains($data)
            ->seeInDatabase('groups', $data);
    }

    public function test_it_can_delete_a_group()
    {
        $user = $this->createAnUser();
        $group = factory(Group::class)->create(['school_id' => $user->school_id, 'owner_id' => $user->id]);

        $this->actingAs($user)
            ->json('DELETE', "/api/groups/{$group->id}")
            ->seeStatusCode(202)
            ->seeInDatabase('groups', ['id' => $group->id])
            ->dontSeeInDatabase('groups', ['deleted_at' => null]);
    }
}
