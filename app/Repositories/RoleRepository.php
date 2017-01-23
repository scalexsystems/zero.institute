<?php namespace Scalex\Zero\Repositories;

use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Teacher;
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

    public function assign(Role $role, School $school, array $people)
    {
        $validUserIds = [];

        $people = collect($people)->groupBy('type');

        foreach ($people as $type => $items) {
            $class = morph_model($type);

            $valid = (new $class)
                ->whereSchoolId($school->getKey())
                ->whereIn('id', $items->pluck('id')->toArray())
                ->get();
            $users = User::wherePersonType($type)
                ->whereIn('person_id', $valid->pluck('id')->toArray())
                ->get();

            $ids = $users->pluck('id')->toArray();

            $duplicates = $role->users()->findMany($ids);

            $ids = array_flip($ids);

            $duplicates->each(function ($duplicate) use (&$ids) {
                if (isset($ids[$duplicate->getKey()])) {
                    unset($ids[$duplicate->getKey()]);
                }
            });

            $validUserIds = array_merge($validUserIds, array_keys($ids));
        }

        if (count($validUserIds)) {
            $role->users()->attach($validUserIds, ['school_id' => $school->getKey()]);

            trust()->clearRoleCache($role);
        }
    }
}
