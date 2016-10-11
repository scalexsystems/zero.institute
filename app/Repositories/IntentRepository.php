<?php namespace Scalex\Zero\Repositories;

use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Intent;
use Znck\Repositories\Repository;

/**
 * @method Intent find(string|int $id)
 * @method Intent findBy(string $key, $value)
 * @method Intent create(array $attr)
 * @method Intent update(string|int|Intent $id, array $attr, array $o = [])
 * @method Intent delete(string|int|Intent $id)
 * @method IntentRepository validate(array $attr, Intent|null $model)
 */
class IntentRepository extends Repository
{
    use \Znck\Repositories\Traits\RepositoryHelper;

    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Intent::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'tag' => 'required|max:255',
        'body' => 'required|json',
        'remarks' => 'nullable|max:65536',
        'locked' => 'nullable|boolean',
        'retry' => 'nullable|boolean',
        'user_id' => 'required|exists:users,id',
        'school_id' => 'required|exists:schools,id',
    ];

    public function boot() {
        if (current_user()) {
            $this->pushCriteria(new OfSchool(current_user()->school));
        }
    }

    public function creating(Intent $intent, array $attributes) {
        $intent->fill($attributes);
        $intent->user()->associate(find($attributes, 'user_id'));
        $intent->school()->associate(find($attributes, 'school_id'));

        return $intent->save();
    }

    public function updating(Intent $intent, array $attributes) {
        return $intent->update($attributes);
    }

    public function deleting(Intent $intent) {
        return $intent->delete();
    }
}
