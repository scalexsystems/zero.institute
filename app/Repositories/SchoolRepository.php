<?php namespace Scalex\Zero\Repositories;

use Illuminate\Database\Eloquent\Model;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Models\Geo\Address;
use Scalex\Zero\Models\School;
use Znck\Repositories\Repository;

/**
 * @method School find(string $id, array $col = [])
 * @method School findBy(string $key, $value)
 * @method School create(array $attr)
 * @method School update(string|School $id, array $attr, array $o = [])
 * @method School delete(string|School $id)
 * @method SchoolRepository validate(array $attr, School $model = null)
 */
class SchoolRepository extends Repository
{
    use \Znck\Repositories\Traits\RepositoryHelper;

    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = School::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required|max:255',
        'slug' => 'required|min:4|max:255|alphadash|reserved|unique:schools',
        'address_id' => 'required|uuid|exists:addresses,id',
        'email' => 'required|email',
        'phone' => 'required|phone',
        'fax' => 'nullable|phone',
        'university' => 'required|max:255',
        'institute_type' => 'required|max:255',
        'logo_id' => 'nullable|uuid|exists:documents,id',
        'verified' => 'nullable|boolean',
    ];

    public function search(string $q) {
        $this->applyCriteria();

        // TODO: Remove this override after indexing is enabled.
        return $this->getQuery()->where('name', 'like', $q.'%');
    }

    /**
     * @param array $rules
     * @param array $attributes
     * @param School $school
     *
     * @return array
     */
    public function getUpdateRules(array $rules, array $attributes, $school) {
        $all = $rules + [
                'address' => repository(Address::class)->getRules($attributes, $school->address),
            ];

        return array_only($all, array_keys($attributes));
    }

    public function updating(School $school, array $attr) {
        $school->fill($attr);

        if (!$school->address) {
            repository(Address::class)->create(['school_id' => $school->getKey()] + array_get($attr, 'address'));
        } elseif (array_has($attr, 'address')) {
            repository(Address::class)->update($school->address, $attr['address']);
        }

        if (array_has($attr, 'logo_id')) {
            $school->logo()->associate(find($attr, 'logo_id', Attachment::class));
        }

        return $school->touch(); // Makes sure it is updated.
    }
}
