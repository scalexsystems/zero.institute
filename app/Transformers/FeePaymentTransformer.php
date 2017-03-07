<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\FeePayment;
use Znck\Transformers\Transformer;

class FeePaymentTransformer extends Transformer
{

    public function show(FeePayment $payment)
    {
        return $payment->toArray();
    }

    public function index(FeePayment $payment)
    {
        return $payment->toArray();
    }
}
