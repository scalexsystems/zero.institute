<?php

use Scalex\Zero\Models\Group;
use Scalex\Zero\Transformers\GroupTransformer;

class GroupTransformerTest extends TestCase
{

    public function test_it_has_correct_output_format() {
        $group = factory(Group::class)->create();
        $transformer = new GroupTransformer;

        $transfored = $transformer->index($group);

        $keys = [
            'name', // Required.
            'description', // Required.
            'photo', // Required.
            'type', // Required.
            'type_text', // UI; Multiple places.
            'private',
            'member_count',
            'member_count_text', // UI; Multiple palces.
            'channel', // Echo connects to this channel.
            'is_member', // Used on groups directory page.
            'is_admin',
            'active_at', // Used to sort groups in recent groups list.
        ];

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $transfored);
        }
    }
}
