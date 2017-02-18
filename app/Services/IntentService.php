<?php namespace Scalex\Zero\Services;

use Illuminate\Http\Request;
use Scalex\Zero\Models\Intent;
use Validator;

/**
 * Class IntentService
 *
 * @deprecated
 */
class IntentService
{
    protected function transformAccountIntent(Intent $intent)
    {
        return [
            'type' => $intent->body['type'] ?? '',
            'uid' => $intent->body['uid'] ?? '',
            'department_id' => $intent->body['department_id'] ?? '',
            'discipline_id' => $intent->body['discipline_id'] ?? '',
            'date_of_admission' => $intent->body['date_of_admission'] ?? '',
            'email' => $intent->user->email,
            'name' => $intent->body['first_name'].' '.$intent->body['last_name'],
        ];
    }

    protected function handleAccountIntent(Request $request, Intent $intent, bool $accept)
    {
        if ($accept === false) {
            repository($intent)->update($intent, [
                'closed' => true,
                'locked' => true,
                'remarks' => $request->input('reason'),
                'status' => 'rejected',
            ]);

            return;
        }

        $type = $intent->body['type'] ?? null;
        if (!in_array($type, ['student', 'teacher', 'employee'])) {
            abort(400, 'Cannot handle unknown account type.');
        }

        $person = repository(morph_model($type))->create($intent->body);
        $intent->user->person()->associate($person)->saveOrFail();

        repository(Intent::class)->update($intent, ['closed' => true, 'locked' => true, 'status' => 'accepted']);
    }

    protected function validateAccountIntent(Request $request, Intent $intent)
    {
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
