<?php

namespace {

    /**
     * @return \Illuminate\Contracts\Cache\Repository
     */
    function cache() {

    }
}

namespace Scalex\Zero {

    use Scalex\Zero\Models\Message;

    /**
     * Class User
     *
     * @package Scalex\Zero
     * @property string $other_email
     * @property string $other_verification_token
     * @property-read Message|null $lastMessageAt
     */
    class User extends \Eloquent
    {

    }
}

namespace Scalex\Zero\Models {

    use Carbon\Carbon;
    use Scalex\Zero\Contracts\Communication\ReceivesMessage;
    use Scalex\Zero\User;

    /**
     * Scalex\Zero\Models\Message
     *
     * @property-read ReceivesMessage|User|Group $receiver
     * @property-read Carbon|null $userReadAt
     */
    class Message extends \Eloquent
    {

    }

    /**
     * Scalex\Zero\Models\Group
     *
     * @property int $count_members
     * @property-read Message|null $lastMessageAt
     */
    class Group extends \Eloquent
    {

    }
}

namespace {

    class Broadcast
    {

        /**
         * Register the routes for handling broadcast authentication and sockets.
         *
         * @param string $pattern
         * @param \Closure $callback
         *
         * @return void
         * @static
         */
        public static function channel($pattern, $callback) {
            \Illuminate\Broadcasting\BroadcastManager::channel($pattern, $callback);
        }
    }
}
