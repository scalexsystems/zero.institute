<?php namespace Scalex\Zero\Repositories;

use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\User;
use Znck\Repositories\Repository;
use Znck\Trust\Models\Role;

/**
 * @method Role find(string|int $id)
 * @method Role findBy(string $key, $value)
 * @method Role create(array $attr)
 * @method Role update(string|int|Role $id, array $attr, array $o = [])
 * @method Role delete(string|int|Role $id)
 * @method RoleRepository validate(array $attr, Role|null $model)
 */
class RoleRepository extends Repository
{
    use \Znck\Repositories\Traits\RepositoryHelper;

    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Role::class; 

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [];

    public function assign($attributes, Role $role){
        return collect($attributes)->map(function ($member) use ($role) {
            $user = repository(User::class)->find(data_get($member, 'id'));
            if ($user) {
                $user->assignRole($role);
            }
        });
    }
}
