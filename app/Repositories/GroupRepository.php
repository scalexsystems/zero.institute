<?php namespace Scalex\Zero\Repositories;

use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Models\Group;
use Scalex\Zero\User;
use Znck\Repositories\Repository;

/**
 * @method Group find(string|int $id)
 * @method Group findBy(string $key, $value)
 * @method Group create(array $attr)
 * @method Group update(string|int|Group $id, array $attr, array $o = [])
 * @method Group delete(string|int|Group $id)
 * @method GroupRepository validate(array $attr, Group|null $model)
 */
class GroupRepository extends Repository
{
    use \Znck\Repositories\Traits\RepositoryHelper;

    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Group::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required|max:60',
        'private' => 'nullable|boolean',
        'school_id' => 'required|exists:schools,id',
        'owner_id' => 'required|exists:users,id',
    ];

    public function boot() {
        $this->pushCriteria(criteria(function ($query) {
            /** @var \Illuminate\Database\Query\Builder $query */
            $query->where('private', false);
        }));
        $this->pushCriteria(new OfSchool(current_user()->school));
    }

    public function creating(Group $group, array $attributes) {
        $group->fill($attributes);

        $group->owner()->associate(find($attributes, 'owner_id', User::class));
        $group->school()->associate(find($attributes, 'school_id'));
        $group->profilePhoto()->associate(find($attributes, 'photo_id', Attachment::class));

        return $group->save();
    }

    public function updating(Group $group, array $attributes) {
        $group->fill($attributes);

        if (array_has($attributes, 'photo_id')) {
            $group->profilePhoto()->associate(find($attributes, 'photo_id', Attachment::class));
        }

        return $group->update();
    }

    public function deleting(Group $group) {
        return $group->delete();
    }
}
