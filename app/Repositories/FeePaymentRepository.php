<?php namespace Scalex\Zero\Repositories;

use Auth;
use Illuminate\Validation\Rule;
use Scalex\Zero\Models\FeePayment;
use Scalex\Zero\Models\FeeSession;
use Scalex\Zero\Models\Transaction;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Znck\Repositories\Repository;

/**
 * @method FeePayment find(string | int $id)
 * @method FeePayment findBy(string $key, $value)
 * @method FeePayment create(array $attr)
 * @method FeePayment update(string | int | FeePayment $id, array $attr, array $o = [])
 * @method FeePayment delete(string | int | FeePayment $id)
 * @method FeePayment validate(array $attr, FeePayment | null $model)
 */
class FeePaymentRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = FeePayment::class;

    public function onlyPending()
    {
        $this->getQuery()->where('paid', false);

        return $this;
    }

    public function onlyPaid()
    {
        $this->getQuery()->where('paid', true);

        return $this;
    }

    public function createForSession(FeeSession $session, array $attributes)
    {
        $this->validateWith($attributes, $this->getRulesForSession($session));

        $payment = FeePayment::where('student_id', $attributes['student_id'])
                             ->where('fee_session_id', $session->id)
                             ->first();

        if (!$payment) {
            throw new HttpException(400, 'The student has no pending fee payments.');
        }

        if ($payment->paid) {
            throw new HttpException(400, 'The student has already paid for the session.');
        }

        app(TransactionRepository::class)->createForManual($session, $session->school, Auth::user(), $attributes);

        $payment->paid = true;

        $this->onUpdate($payment->update());

        return $payment;
    }

    protected function getRulesForSession(FeeSession $session)
    {
        return [
            'student_id' => [
                'bail',
                'required',
                Rule::exists('students', 'id')->where('school_id', $session->school_id),
            ],

            'payment_mode' => 'required|in:cash,dd,cheque',

            'dd_number' => 'required_if:payment_mode,dd',

            'cheque_number' => 'required_if:payment_mode,cheque',

            'amount' => 'required|numeric',

            'accountant_id' => [
                'bail',
                Rule::exists('employees', 'id')->where('school_id', $session->school_id),
            ],
        ];
    }
}
