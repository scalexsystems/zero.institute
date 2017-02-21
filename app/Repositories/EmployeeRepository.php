<?php namespace Scalex\Zero\Repositories;

use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;
use Request;
use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Models\Address;
use Scalex\Zero\Models\School;
use Scalex\Zero\User;
use UnexpectedValueException;
use Znck\Attach\Builder;
use Znck\Repositories\Repository;
use Illuminate\Http\UploadedFile;

/**
 * @method Employee find(string|int $id)
 * @method Employee findBy(string $key, $value)
 * @method Employee create(array $attr)
 * @method Employee update(string|int|Employee $id, array $attr, array $o = [])
 * @method Employee delete(string|int|Employee $id)
 * @method EmployeeRepository validate(array $attr, Employee|null $model)
 */
class EmployeeRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        // Basic Information
        'photo_id' => 'nullable|exists:documents,id',
        'first_name' => 'required|max:255',
        'middle_name' => 'nullable|max:255',
        'last_name' => 'required|max:255',
        'date_of_birth' => 'required|date',
        'gender' => 'nullable|in:female,male,other',
        'blood_group' => 'nullable|in:A+,A-,AB+,AB-,B+,B-,O+,O-',
        'category' => 'nullable|in:gen,obc,sc,st,ot',
        'religion' => 'nullable|max:255',
        'language' => 'nullable|max:255',
        'nationality' => 'nullable|max:255',
        'passport' => 'nullable|max:255',
        'govt_id' => 'nullable|max:255',

        // Related to School
        'uid' => 'required|unique:employees,uid,NULL,id,school_id,',
        'date_of_joining' => 'nullable|date',
        'job_title' => 'nullable|max:255',
        'department_id' => 'required|exists:departments,id',
        'biometric_id' => 'nullable|max:255',

        // Qualification.
        'education' => 'nullable',

        // Past Working Experience.
        'experience' => 'nullable',

        // Address
        'address_id' => 'required|exists:addresses,id',

        // Bank Account Details
        'bank' => 'nullable|max:255',
        'beneficiary_name' => 'nullable|max:255',
        'bank_account_number' => 'nullable|max:255',
        'ifsc_code' => 'nullable|max:255',
        'income_tax_id' => 'nullable|max:255',

        // Medical Details
        'is_disabled' => 'nullable|boolean',
        'disability' => 'required_if:is_disabled,1|max:255',
        'disease' => 'nullable|max:255',
        'allergy' => 'nullable|max:255',
        'visible_marks' => 'nullable|max:255',
        'food_habit' => 'nullable|array',
        'medical_remarks' => 'nullable|max:65536',

        // Maintenance Information
        'archived' => 'nullable|boolean',
        'school_id' => 'required|exists:schools,id',
        'remarks' => 'nullable|max:65536',
    ];

    public function boot()
    {
        if ($user = Request::user()) {
            $this->pushCriteria(new OfSchool($user->school));
        }
    }

    private function getCreateRulesForSchool($school)
    {
        $id = $school->getKey();

        return $this->rules + [
            'uid' => [
                'required',
                Rule::unique('employees')->where('school_id', $id),
            ],
            'department_id' => [
                'required',
                Rule::exists('departments', 'id')->where('school_id', $id),
            ],
            'photo_id' => [
                'nullable',
                Rule::exists('attachments', 'id')->where('school_id', $id),
            ],
        ];
    }

    /**
     * @param array $rules
     * @param array $attributes
     * @param Employee $employee
     *
     * @return array
     */
    public function getUpdateRules(array $rules, array $attributes, $employee)
    {
        $rules = $this->getCreateRulesForSchool($employee->school);

        $rules['uid'] = [
            'required',
            Rule::unique('employees')
                ->where('school_id', $employee->school->getKey())
                ->ignore($employee->getKey()),
        ];
        return array_only($rules, array_keys($attributes));
    }

    public function creating(Employee $employee, array $attributes)
    {
        throw new UnexpectedValueException('Use `createForSchool` method instead of `create`.');
    }

    public function updating(Employee $employee, array $attributes)
    {
        $employee->department()->associate($attributes['department_id'] ?? $employee->department_id);

        return $employee->update($attributes);
    }
    public function uploadPhoto(Employee $employee, UploadedFile $photo, User $user)
    {
        if (!$photo->isValid()) {
            throw new UploadException('Invalid photo.');
        }

        // Set path & slug.
        $attributes['path'] = $this->getPhotoUploadPath($employee);
        $attributes['slug'] = $attributes['slug'] ?? Uuid::uuid4();

        // Prepare uploader.
        $uploader = Builder::makeFromFile($photo)->resize(360, 'preview', 360);
        ;

        // Upload & get attachment.
        $attachment = $uploader->upload($attributes)->getAttachment();

        $attachment->owner()->associate($user);
        $attachment->related()->associate($employee);

        $this->onCreate($attachment->save());

        // Associate photo to the employee.
        $employee->photo()->associate($attachment);

        $this->onUpdate($employee->save());

        return $attachment;
    }

    protected function getPhotoUploadPath(Employee $employee)
    {
        return "schools/{$employee->school_id}/employees/photo/{$employee->id}";
    }

    public function createForSchool(School $school, array $attributes)
    {
        $this->validateWith($attributes, $this->getCreateRulesForSchool($school));

        $employee = new Employee($attributes);

        $employee->department()->associate($attributes['department_id'] ?? null);
        $employee->photo()->associate($attributes['photo_id'] ?? null);
        $employee->school()->associate($school);

        $this->onCreate($employee->save());

        return $employee;
    }

    public function updateAddress(Employee $employee, array $attributes)
    {
        $repository = repository(Address::class);

        if ($employee->address) {
            $repository->update($employee->address, $attributes);
        } else {
            $address = $repository->create($attributes);

            $employee->address()->associate($address);

            $this->onUpdate($employee->save());
        }

        return $employee;
    }
}
