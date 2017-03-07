<?php namespace Scalex\Zero\Repositories;

use Scalex\Zero\Models\FeePayment;
use Scalex\Zero\Models\Student;
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
}
