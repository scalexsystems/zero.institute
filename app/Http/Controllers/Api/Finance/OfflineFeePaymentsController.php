<?php

namespace Scalex\Zero\Http\Controllers\Api\Finance;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\FeeSession;
use Scalex\Zero\Repositories\FeePaymentRepository;

class OfflineFeePaymentsController extends Controller
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

    public function store(Request $request, FeeSession $session)
    {
        $this->authorize('add-offline-payment', $session);

        return $this->repository->createTransactionForPayment($session, $request->all());
    }
}
