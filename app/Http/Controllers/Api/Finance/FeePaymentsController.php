<?php

namespace Scalex\Zero\Http\Controllers\Api\Finance;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\OfStudent;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
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

    public function index(Request $request)
    {
        $person = $request->user()->person;

        if (!($person instanceof Student)) {
            abort(400, 'Only students can pay fees.');
        }

        $this->repository->pushCriteria(new OfStudent($person))
                         ->pushCriteria(new OrderBy('id', 'desc'));

        if ($request->input('pending') === true) {
            $this->repository->onlyPending();
        }

        if ($request->input('paid') === true) {
            $this->repository->onlyPaid();
        }

        return $this->repository->paginate();
    }
}
