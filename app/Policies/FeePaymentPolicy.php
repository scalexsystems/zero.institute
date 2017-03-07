<?php

namespace Scalex\Zero\Policies;

use Scalex\Zero\Models\FeePayment;
use Scalex\Zero\User;

class FeePaymentPolicy extends AbstractPolicy
{

    /**
     * Determine whether the user can view the feePayment.
     *
     * @param  \Scalex\Zero\User $user
     * @param  \Scalex\Zero\Models\FeePayment $feePayment
     *
     * @return mixed
     */
    public function read(User $user, FeePayment $feePayment)
    {
        //
    }

    /**
     * Determine whether the user can create feePayments.
     *
     * @param  \Scalex\Zero\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the feePayment.
     *
     * @param  \Scalex\Zero\User $user
     * @param  \Scalex\Zero\Models\FeePayment $feePayment
     *
     * @return mixed
     */
    public function update(User $user, FeePayment $feePayment)
    {
        //
    }

    /**
     * Determine whether the user can delete the feePayment.
     *
     * @param  \Scalex\Zero\User $user
     * @param  \Scalex\Zero\Models\FeePayment $feePayment
     *
     * @return mixed
     */
    public function delete(User $user, FeePayment $feePayment)
    {
        //
    }
}
