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

    /**
     * Get messages before given timestamp.
     *
     * @param \Illuminate\Database\Query\Builder $model
     * @param \Znck\Repositories\Contracts\Repository $repository
     *
     * @return void
     */
    public function apply($model, Repository $repository) {
        $model->where('created_at', '<', Carbon::createFromTimestamp($this->timestamp));
    }
}
