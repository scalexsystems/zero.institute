<?php namespace Scalex\Zero\Repositories;

use Scalex\Zero\Models\Session;
use Znck\Repositories\Repository;

/**
 * @method Session find(string|int $id)
 * @method Session findBy(string $key, $value)
 * @method Session create(array $attr)
 * @method Session update(string|int|Session $id, array $attr, array $o = [])
 * @method Session delete(string|int|Session $id)
 * @method SessionRepository validate(array $attr, Session|null $model)
 */
class SessionRepository extends Repository
{

    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Session::class; 

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [];
}
