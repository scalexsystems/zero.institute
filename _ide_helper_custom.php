<?php

namespace {

    /**
     * @return \Illuminate\Contracts\Cache\Repository
     */
    function cache()
    {

    }
}

namespace Znck\Attach {

    class Builder
    {
        /**
         * @param array $attr
         *
         * @return \Znck\Attach\Contracts\Uploader
         */
        public function upload($attr)
        {
        }

        /**
         * @param $width
         * @param $name
         * @param $height
         * @param $mime
         *
         * @return $this
         */
        public function resize($width, $name = null, $height = null, $mime = null)
        {
        }
    }
}

namespace Znck\Attach\Contracts {

    class Uploader
    {
        /**
         * @return \Scalex\Zero\Models\Attachment
         */
        public function getAttachment()
        {
        }
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
     * @property-read Message|null $lastMessage
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
        public static function channel($pattern, $callback)
        {
            \Illuminate\Broadcasting\BroadcastManager::channel($pattern, $callback);
        }
    }
}
