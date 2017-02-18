<?php namespace Scalex\Zero\Repositories;

use Scalex\Zero\Models\Role;
use Scalex\Zero\Models\School;
use Scalex\Zero\User;
use Znck\Repositories\Repository;

/**
 * @method Role find(string | int $id)
 * @method Role findBy(string $key, $value)
 * @method Role create(array $attr)
 * @method Role update(string | int | Role $id, array $attr, array $o = [])
 * @method Role delete(string | int | Role $id)
 * @method RoleRepository validate(array $attr, Role | null $model)
 */
class RoleRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Role::class;

    public function users(Role $role, School $school)
    {
        return User::with('person', 'person.photo')
                   ->addSelect('users.*')
                   ->join('role_user', 'users.id', '=', 'role_user.user_id')
                   ->where('role_user.role_id', $role->getKey())
                   ->where('users.school_id', $school->getKey())
                   ->get();
    }
}
