<?php

namespace Test\Api\Groups;

trait GroupTestsHelper
{

    /**
     * Create private groups.
     *
     * @param int $count
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Scalex\Zero\Models\Group
     */
    protected function createPrivateGroup($count = 1) {
        return $this->createGroup(['private' => true], $count);
    }

    /**
     * Create public groups.
     *
     * @param int $count
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Scalex\Zero\Models\Group
     */
    protected function createPublicGroup($count = 1) {
        return $this->createGroup(['private' => false], $count);
    }

    /**
     * Create course groups.
     *
     * @param int $count
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Scalex\Zero\Models\Group
     */
    protected function createCourseGroup($count = 1) {
        return $this->createGroup(['type' => 'course', 'private' => true], $count);
    }

    /**
     * @param array $attributes
     * @param int $count
     *
     * @return \Scalex\Zero\Models\Group|\Illuminate\Database\Eloquent\Collection
     */
    protected function createGroupWithMembers(array $attributes = [], $count = 2)
    {
        $group = $this->createGroup($attributes);
        $users = $this->createUser(['school_id' => $this->getSchool()->id], $count);

        $group->addMembers($users);

        return $group;
    }

    /**
     * Create groups.
     *
     * @param $attributes
     * @param int $count
     *
     * @return \Scalex\Zero\Models\Group|\Illuminate\Database\Eloquent\Collection
     */
    protected function createGroup($attributes, $count = 1) {
        $attributes += [
            'school_id' => $this->getSchool()->id,
        ];

        return factory(\Scalex\Zero\Models\Group::class, $count)->create($attributes);
    }
}
