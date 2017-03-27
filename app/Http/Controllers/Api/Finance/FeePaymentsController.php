<?php

namespace Scalex\Zero\Http\Controllers\Api\Finance;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\OfStudent;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\FeeSession;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Repositories\FeePaymentRepository;

class FeePaymentsController extends Controller
{
    /**
     * @var \Scalex\Zero\Repositories\FeePaymentRepository
     */
    protected $repository;

    public function __construct(FeePaymentRepository $repository)
    {
        $this->middleware('auth:api,web');
        $this->repository = $repository;
    }

    public function index(Request $request, FeeSession $session)
    {
        $this->authorize('view', $session);

        $this->repository->pushCriteria(
            criteria(function (
                /* @var $query \Illuminate\Database\Query\Builder */
                $query
            ) use ($session) {
                return $query->where('fee_session_id', $session->getKey());
            })
        )
                         ->pushCriteria(new OrderBy('id', 'desc'));

        if ($request->input('pending') === true) {
            $this->repository->onlyPending();
        } else {
            $this->repository->onlyPaid();
        }

        return $this->repository->paginate();
    }
}
