<?php

namespace Scalex\Zero\Repositories;

use Illuminate\Database\Eloquent\Model;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Transaction;
use Scalex\Zero\User;
use Znck\Repositories\Repository;

class TransactionRepository extends Repository
{
    protected $model = Transaction::class;

    protected $rules = [
        'amount' => 'required|integer',

        'refundable' => 'nullable|boolean',

        'status' => [
            'required',
            'in' => [Transaction::PENDING, Transaction::SUCCESSFUL, Transaction::FAILED],
        ],

        'payment_method' => 'required|in:online|cash|dd|cheque',

        // Online
        'gateway' => 'required_if:payment_method,online',
        'gateway_reference_id' => 'required_if:payment_method,online',


    ];

    public function createForManual(Model $payable, School $school, User $user, array $attributes)
    {
        $transaction = new Transaction($attributes);

        $transaction->payable()->associate($payable);
        $transaction->school()->associate($school);
        $transaction->user()->associate($user);

        $this->onCreate($transaction->save());

        return $transaction;
    }
}
