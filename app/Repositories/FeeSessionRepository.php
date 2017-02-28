<?php namespace Scalex\Zero\Repositories;

use Scalex\Zero\Models\FeeSession;
use Znck\Repositories\Repository;

/**
 * @method FeeSession find(int $id)
 * @method FeeSession findBy(string $key, $value)
 * @method FeeSession create(array $attr)
 * @method FeeSession update(int | FeeSession $id, array $attr, array $o = [])
 * @method FeeSession delete(int | FeeSession $id)
 */
class FeeSessionRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = FeeSession::class;
}
