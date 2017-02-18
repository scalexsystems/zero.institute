<?php namespace Scalex\Zero\Http\Controllers\Api\Schools;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Session;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request)
    {
        return cache()->rememberForever(
            schoolScopeCacheKey('sessions'),
            function () use ($request) {
                return repository(Session::class)->with('semester')->all();
            }
        );
    }

    public function store(Request $request)
    {
        $this->authorize('store', Session::class);

        $session = repository(Session::class)->createForSchool(
            $request->user()->school,
            $request->all()
        );

        return $session;
    }

    public function update(Request $request, $session)
    {
        $session = repository(Session::class)->find($session);
        $this->authorize('update', $session);

        if ($session->ended_on->isPast()) {
            abort(400, 'You cannot update past sessions.');
        }

        repository(Session::class)->update($session, $request->all());

        return $session;
    }
}
