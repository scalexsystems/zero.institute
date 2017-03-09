<?php

namespace Scalex\Zero\Policies;

use Scalex\Zero\Models\FeeSession;
use Scalex\Zero\User;

class FeeSessionPolicy extends AbstractPolicy
{
    public function browse(User $user)
    {
        return trust($user)->to('fee_session.read');
    }

    public function view(User $user, FeeSession $session)
    {
        return (int)$user->school_id === (int)$session->school_id and
               $this->browse($user);
    }

    public function create(User $user)
    {
        return trust($user)->to('fee_session.create');
    }

    public function update(User $user, FeeSession $session)
    {
        return (int)$user->school_id === (int)$session->school_id and
               trust($user)->to('fee_session.update');
    }

    public function delete(User $user, FeeSession $session)
    {
        return (int)$user->school_id === (int)$session->school_id and
               trust($user)->to('fee_session.delete');
    }

    public function addOfflinePayment(User $user, FeeSession $session)
    {
        return (int)$user->school_id === (int)$session->school_id and
               trust($user)->to('fee_session.add_offline');
    }
}
