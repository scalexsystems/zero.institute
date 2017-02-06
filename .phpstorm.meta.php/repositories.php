<?php

namespace PHPSTORM_META {

    override(
        \repository(0),
        map([
                \Scalex\Zero\User::class => \Scalex\Zero\Repositories\UserRepository::class,
                \Scalex\Zero\Models\Group::class => \Scalex\Zero\Repositories\GroupRepository::class,
                \Scalex\Zero\Models\Message::class => \Scalex\Zero\Repositories\MessageRepository::class,
                \Scalex\Zero\Models\Student::class => \Scalex\Zero\Repositories\StudentRepository::class,
                \Scalex\Zero\Models\Geo\City::class => \Scalex\Zero\Repositories\Geo\CityRepository::class,
                \Scalex\Zero\Models\Geo\Address::class => \Scalex\Zero\Repositories\Geo\AddressRepository::class,
            ]));
};