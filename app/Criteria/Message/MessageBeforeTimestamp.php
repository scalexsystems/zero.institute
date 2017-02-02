<?php namespace Scalex\Zero\Criteria\Message;

use Carbon\Carbon;
use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class MessageBeforeTimestamp implements Criteria
{

    protected $timestamp;

    /**
     * MessageBeforeTimestamp constructor.
     *
     * @param int $timestamp
     */
    public function __construct(int $timestamp) {
        $this->timestamp = $timestamp;
    }

    public function apply($model, Repository $repository) {
        $model->where('created_at', '<', Carbon::createFromTimestamp($this->timestamp));
    }
}
