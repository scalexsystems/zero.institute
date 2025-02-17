<?php namespace Scalex\Zero\Http\Controllers\Api\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Scalex\Zero\Criteria\FilterIntents;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Models\Intent;
use Scalex\Zero\Services\IntentService;

/**
 * @deprecated
 */
class IntentController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('index', Intent::class);

        if (!$request->has('tag')) {
            $request->query->set('tag', 'account');
        }
        $intents = repository(Intent::class)->pushCriteria(new FilterIntents($request));

        if ($request->has('q')) {
            $intents->search($request->query('q'));
        }

        return $intents->paginate();
    }

    public function show(Request $request, Intent $intent)
    {
        $this->authorize($intent);

        $request->query->set('with', ['user', 'user.profilePhoto']);

        return $intent;
    }

    public function store(Request $request)
    {
        $this->authorize('store', Intent::class);

        $type = $request->input('tag');

        if (!$this->canHandleIntent($type)) {
            abort(422, ['errors' => ['tag' => 'Unknown intent type.']]);
        }

        $intent = repository(Intent::class)->create($request->all());

        return $intent;
    }

    public function update(Request $request, Intent $intent)
    {
        $this->authorize($intent);

        $this->validateIntent($request, $intent);
        repository(Intent::class)->update($intent, ['body' => $request->all()]);

        return $this->accepted();
    }

    public function lock(Intent $intent)
    {
        $this->authorize($intent);

        repository(Intent::class)->update($intent, ['locked' => true]);

        return $this->accepted();
    }

    public function accept(Request $request, Intent $intent)
    {
        $this->authorize($intent);

        $this->validateIntent($request, $intent);
        $this->processIntent($request, $intent);

        return $this->accepted();
    }

    public function reject(Request $request, Intent $intent)
    {
        $this->authorize($intent);

        $this->processIntent($request, $intent, false);

        return $this->accepted();
    }

    protected function validateIntent(Request $request, Intent $intent):void
    {
        $method = 'validate'.Str::studly($intent->tag).'Intent';
        $service = app(IntentService::class);
        if (!method_exists($service, $method)) {
            abort(400, 'Cannot handle unknown intent.');
        }
        $service->$method($request, $intent);
    }

    protected function processIntent(Request $request, Intent $intent, bool $accept = true)
    {
        $method = 'handle'.Str::studly($intent->tag).'Intent';
        $service = app(IntentService::class);
        if (!method_exists($service, $method)) {
            abort(400, 'Cannot handle unknown intent.');
        }
        $service->$method($request, $intent, $accept);
    }

    protected function canHandleIntent(string $type): bool
    {
        $method = 'handle'.Str::studly($intent->tag).'Intent';
        $service = app(IntentService::class);

        return method_exists($service, $method);
    }
}
