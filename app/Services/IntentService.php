<?php namespace Scalex\Zero\Services;

use Illuminate\Http\Request;
use Scalex\Zero\Models\Intent;
use Validator;

class IntentService
{
    protected function handleAccountIntent(Request $request, Intent $intent, bool $accept) {
        if ($accept === false) {
            repository($intent)->update($intent, [
                'retry' => true,
                'locked' => true,
                'remarks' => $request->input('reason'),
            ]);

            return;
        }

        $type = $intent->body['type'] ?? null;
        if (!in_array($type, ['student', 'teacher', 'employee'])) {
            abort(400, 'Cannot handle unknown account type.');
        }

        $person = repository(morph_model($type))->create($intent->body);
        $intent->user->person()->associate($person)->saveOrFail();
        repository($intent)->delete($intent);
    }

    protected function validateAccountIntent(Request $request, Intent $intent) {
        $type = $request->input('type', $intent->body['type'] ?? null);

        if (!in_array($type, ['student', 'teacher', 'employee'])) {
            abort(400, 'Cannot handle unknown account type.');
        }

        $rules = array_except(
            repository(morph_model($type))->getRules([]),
            ['father_id', 'mother_id', 'school_id', 'address_id']
        );

        $validator = Validator::make($request->all() + $intent->body, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
