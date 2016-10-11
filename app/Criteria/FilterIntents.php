<?php namespace Scalex\Zero\Criteria;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class FilterIntents implements Criteria
{
    protected $request;

    /**
     * FilterIntents constructor.
     *
     * @param array|Request $request
     */
    public function __construct($request) {
        $this->request = new Collection($request instanceof Request ? $request->query() : $request);
    }

    public function apply($query, Repository $repository) {
        if ($this->request->has('tag')) {
            $query->where('tag', $this->request->get('tag'));
        }

        if ($this->request->has('locked')) {
            $query->where('locked', $this->request->get('locked'));
        }

        $query->where('retry', $this->request->has('rejected'));

        if ($this->request->has('type')) {
            $query->where('body->type', $this->request->get('type'));
        }
    }
}
