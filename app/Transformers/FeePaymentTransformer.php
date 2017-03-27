<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\FeePayment;
use Znck\Transformers\Transformer;

class FeePaymentTransformer extends Transformer
{
    protected $availableIncludes = ['student', 'transactions'];

    public function show(FeePayment $payment)
    {
        return $this->index($payment);
    }

    public function index(FeePayment $payment)
    {
        return [
            'amount' => $payment->amount / 100.0,
            'deadline' => iso_date($payment->deadline),
            'fee_session_id' => (int)$payment->fee_session_id,
            'paid' => (bool)$payment->paid,
            'student_id' => (bool)$payment->student_id,
        ];
    }

    public function includeStudent(FeePayment $payment)
    {
        return $this->item($payment->student);
    }

    public function includeTransactions(FeePayment $payment) {
        return $this->collection($payment->transactions);
    }
}
