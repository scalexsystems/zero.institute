<?php namespace Scalex\Zero\Http\Controllers\Api;

use Illuminate\Http\Request;
use Scalex\Zero\Events\User\AccountIntentSubmitted;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Intent;

class AccountIntentController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return Intent
     */
    public function show(Request $request)
    {
        if ($request->user()->person) {
            abort(400, 'Your profile is already completed!');
        }

        $intent = $this->getAccountIntent($request);

        if ($intent instanceof Intent) {
            return $intent;
        }

        abort(404, 'No intent found.');
    }

    protected function store(Request $request)
    {
        $intent = repository(Intent::class)->create(
            [
                'user' => $request->user(),
                'user_id' => $request->user()->id,
                'school' => $request->user()->school,
                'school_id' => $request->user()->school_id,
                'tag' => 'account',
                'body' => $request->input(),
            ]);

        return $this->created($intent->getKey());
    }

    public function update(Request $request)
    {
        $intent = $this->getAccountIntent($request);
        if (!$intent instanceof Intent) {
            return $this->store($request);
        }

        if ($intent->locked) {
            abort(400, 'Your request has been submitted for approval. No changes are allowed now!');
        }

        repository($intent)->update($intent, ['body' => $request->input()]);

        return $this->accepted();
    }

    public function submit(Request $request)
    {
        $intent = $this->getAccountIntent($request);

        if (!$intent instanceof Intent) {
            abort(400, 'There is no active account approval request.');
        }

        if (!is_null(current_user()->verification_token)) {
            abort(400, 'Verify your email address before submitting the request.');
        }

        $this->validateIntent($request, $intent);
        repository($intent)->update($intent, ['locked' => true]);
        event(new AccountIntentSubmitted($intent));

        return $this->accepted();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getAccountIntent(Request $request):\Illuminate\Database\Eloquent\Collection
    {
        $intent = repository(Intent::class)->pushCriteria(criteria(function ($query) use ($request) {
            /** @var \Illuminate\Database\Query\Builder $query */
            $tag = $request->query('tag', 'account');
            $query->where('user_id', $request->user()->getKey());
            $query->where('tag', $tag);
        }))->first();

        return $intent;
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
}
