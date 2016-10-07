<?php namespace Scalex\Zero\Repositories\Geo;

use Scalex\Zero\Models\Geo\City;
use Znck\Repositories\Repository;

/**
 * @method City find(string|int $id)
 * @method City findBy(string $key, $value)
 * @method City create(array $attr)
 * @method City update(string|int|City $id, array $attr, array $o = [])
 * @method City delete(string|int|City $id)
 * @method CityRepository validate(array $attr, City|null $model)
 */
class CityRepository extends Repository
{
    use \Znck\Repositories\Traits\RepositoryHelper;

    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = City::class; 

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [];
}
