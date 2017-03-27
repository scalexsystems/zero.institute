<?php

namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Transaction;
use Znck\Transformers\Transformer;

class TransactionTransformer extends Transformer
{
    public function show(Transaction $transaction)
    {
        return $this->index($transaction);
    }

    public function index(Transaction $transaction)
    {
        return [
          'mode' => $transaction->payment_method,
        ];
    }
}
