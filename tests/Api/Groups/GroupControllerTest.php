<?php

namespace Tests\Api\Groups;

use Scalex\Zero\Events\Group\Created;
use Scalex\Zero\Events\Group\Deleted;
use Scalex\Zero\Events\Group\Updated;

class GroupControllerTest extends \TestCase
{
    use MessagingTestHelper;

    public function test_index_api_format()
    {
        $this->createPublicGroup(2);

        $this->actingAs($this->getUser())->json('GET', '/api/groups')
             ->assertStatus(200)
             ->assertJsonStructure([
                 'groups' => [
                     '*' => [
                         'id',
                         '_type',
                         'name',
                         'description',
                         'photo',
                         'type',
                         'type_text',
                         'private',
                         'member_count',
                         'member_count_text',
                         'channel',
                         'active_at',
                         'is_member',
                         'is_admin',
                     ],
                 ],
                 'meta' => [
                     'pagination',
                 ],
             ]);
    }

    public function test_index_can_have_only_public_groups()
    {
        $groups = $this->createPublicGroup(2);
        $this->createPrivateGroup();

        $response = $this->actingAs($this->getUser())->json('GET', '/api/groups');

        $response->assertStatus(200);
        $this->seeResources($response, 'groups', $groups->modelKeys());
    }

    public function test_index_can_respond_with_zero_groups()
    {
        $response = $this->actingAs($this->getUser())->json('GET', '/api/groups');

        $response->assertStatus(200)
            // TODO: Hack it to change `items` to `groups`.
                 ->assertJsonStructure(['items', 'meta' => ['pagination']]);
        $this->seeResources($response, 'items', []);
    }

    /* TODO: Add tests for search.
    public function test_index_can_search() {
        $group = $this->createPublicGroup();

        $this->actingAs($this->getUser())->json('GET','/api/groups?q='.$group->name)->seeResources('groups', [$group->getKey()]);
    } */

    public function test_show_api_format()
    {
        $group = $this->createPublicGroup();

        $this->actingAs($this->getUser())->json('GET', '/api/groups/'.$group->id)
             ->assertStatus(200)
             ->assertJsonStructure([
                 'group' => [
                     'id',
                     '_type',
                     'name',
                     'description',
                     'photo',
                     'type',
                     'type_text',
                     'private',
                     'member_count',
                     'member_count_text',
                     'channel',
                     'active_at',
                     'is_member',
                     'is_admin',
                     'owner' => [
                         'id',
                         '_type',
                         'name',
                         'photo',
                     ],
                 ],
             ]);
    }

    public function test_show_can_return_public_group()
    {
        $group = $this->createPublicGroup();

        $this->actingAs($this->getUser())->json('GET', '/api/groups/'.$group->id)->assertStatus(200);
    }

    public function test_show_cannot_return_private_group()
    {
        $group = $this->createPrivateGroup();

        $this->actingAs($this->getUser())->json('GET', '/api/groups/'.$group->id)->assertStatus(401);
    }

    public function test_show_can_return_private_group_if_user_is_member()
    {
        $group = $this->createPrivateGroup();

        $group->addMembers($this->getUser());

        $this->actingAs($this->getUser())->json('GET', '/api/groups/'.$group->id)->assertStatus(200);
    }

    public function test_show_throws_not_found_error()
    {
        $this->actingAs($this->getUser())->json('GET', '/api/groups/1')->assertStatus(404);
    }

    public function test_store_can_create_group()
    {
//        $this->expectsModelEvents(Group::class, 'created');
        $this->expectsEvents(Created::class);
        $this->actingAs($this->getUserWithPerson())->post('/api/groups', ['name' => 'Foo'])
             ->assertStatus(200)
             ->assertJsonStructure(['group' => ['id', 'name']]);
        $this->assertDatabaseHas('groups', ['name' => 'Foo']);
    }

    public function test_store_throws_validation_exception()
    {
        $this->actingAs($this->getUserWithPerson())->post('/api/groups')
             ->assertStatus(422)
             ->assertJsonStructure(['errors' => ['name']]);
    }

    public function test_update_can_update_group()
    {
        $group = $this->createPublicGroup();

//        $this->expectsModelEvents(Group::class, 'updated');
        $this->expectsEvents(Updated::class);
        $this->actingAs($group->owner)->put('/api/groups/'.$group->id, ['name' => 'Foo'])
             ->assertStatus(200)
             ->assertJsonStructure(['group' => ['id', 'name']]);
        $this->assertDatabaseHas('groups', ['name' => 'Foo']);
    }

    public function test_update_cannot_be_updated_non_owner()
    {
        $group = $this->createPublicGroup();

        $group->addMembers($user = $this->createUser());

        $this->actingAs($user)->put('/api/groups/'.$group->id, ['name' => 'Foo'])
             ->assertStatus(401);
    }

    public function test_update_throws_validation_exception()
    {
        $group = $this->createPublicGroup();

        $this->actingAs($group->owner)->put('/api/groups/'.$group->id, ['private' => 'Foo'])
             ->assertStatus(422)
             ->assertJsonStructure(['errors' => ['private']]);
    }

    public function test_update_cannot_make_course_group_public()
    {
        $group = $this->createCourseGroup();

//        $this->doesntExpectModelEvents(Group::class, 'updated');
        $this->expectsEvents(Updated::class);
        $this->actingAs($group->owner)->put('/api/groups/'.$group->id, ['private' => false])
             ->assertStatus(200);
        $this->assertDatabaseHas('groups', ['private' => true]);
    }

    public function test_delete_can_delete_a_group()
    {
        $group = $this->createPublicGroup();

//        $this->expectsModelEvents(Group::class, 'deleted');
        $this->expectsEvents(Deleted::class);
        $this->actingAs($group->owner)->delete('/api/groups/'.$group->id)
             ->assertStatus(202);

        $this->assertDatabaseMissing('groups', ['id' => $group->id, 'deleted_at' => null]);
    }

    public function test_delete_cannot_be_deleted_by_non_owner()
    {
        $group = $this->createPublicGroup();

        $this->actingAs($this->getUser())->delete('/api/groups/'.$group->id)
             ->assertStatus(401);
    }

    public function test_delete_cannot_delete_course_type_group()
    {
        $group = $this->createCourseGroup();

        $this->actingAs($group->owner)->delete('/api/groups/'.$group->id)
             ->assertStatus(400);
    }
}
