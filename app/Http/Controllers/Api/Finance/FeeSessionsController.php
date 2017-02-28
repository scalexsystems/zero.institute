<?php

namespace Scalex\Zero\Http\Controllers\Api\Finance;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\FeeSession;
use Scalex\Zero\Repositories\FeeSessionRepository;

class FeeSessionsController extends Controller
{
    /**
     * @var FeeSessionRepository
     */
    protected $repository;

    public function __construct(FeeSessionRepository $repository)
    {
        $this->middleware('auth:api,web');
        $this->repository = $repository;
    }

    public function index()
    {
        $this->authorize('browse', FeeSession::class);

        return $this->repository->pushCriteria(new OrderBy('created_at', 'desc'))->paginate();
    }

    public function show(FeeSession $session)
    {
        $this->authorize('view', $session);

        return $session;
    }

    public function store(Request $request)
    {
        $this->authorize('create', FeeSession::class);

        return $this->repository->create($request->all());
    }

    public function update(Request $request, FeeSession $session)
    {
        $this->authorize('update', $session);

        return $this->repository->update($session, $request->all());
    }

    public function destroy(FeeSession $session)
    {
        $this->authorize('delete', $session);

        $this->repository->delete($session);

        return $this->accepted();
    }
}
