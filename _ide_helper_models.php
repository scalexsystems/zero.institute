<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace Scalex\Zero\Models{
/**
 * Scalex\Zero\Models\Attachment
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $disk
 * @property string $path
 * @property string $mime
 * @property string $filename
 * @property string $extension
 * @property integer $size
 * @property string $visibility
 * @property mixed $variations
 * @property mixed $additional
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $user_id
 * @property integer $school_id
 * @property integer $related_id
 * @property string $related_type
 * @property-read \Scalex\Zero\User $owner
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $related
 * @property mixed $extended
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereDisk($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment wherePath($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereMime($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereExtension($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereSize($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereVisibility($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereVariations($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereAdditional($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereSchoolId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereRelatedId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Attachment whereRelatedType($value)
 */
	class Attachment extends \Eloquent {}
}

namespace Scalex\Zero\Models{
/**
 * Scalex\Zero\Models\Department
 *
 * @property integer $id
 * @property string $name
 * @property string $short_name
 * @property boolean $academic
 * @property integer $head_id
 * @property integer $school_id
 * @property mixed $additional
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Scalex\Zero\Models\School $school
 * @property-read \Scalex\Zero\Models\Teacher $head
 * @property mixed $extended
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Department whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Department whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Department whereShortName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Department whereAcademic($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Department whereHeadId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Department whereSchoolId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Department whereAdditional($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Department whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Department whereUpdatedAt($value)
 */
	class Department extends \Eloquent {}
}

namespace Scalex\Zero\Models{
/**
 * Scalex\Zero\Models\Discipline
 *
 * @property integer $id
 * @property string $name
 * @property string $short_name
 * @property integer $school_id
 * @property mixed $additional
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Scalex\Zero\Models\School $school
 * @property mixed $extended
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Discipline whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Discipline whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Discipline whereShortName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Discipline whereSchoolId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Discipline whereAdditional($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Discipline whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Discipline whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Discipline whereUpdatedAt($value)
 */
	class Discipline extends \Eloquent {}
}

namespace Scalex\Zero\Models{
/**
 * Scalex\Zero\Models\Employee
 *
 * @property integer $id
 * @property integer $photo_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property \Carbon\Carbon $date_of_birth
 * @property string $gender
 * @property string $blood_group
 * @property string $category
 * @property string $religion
 * @property string $language
 * @property string $nationality
 * @property string $passport
 * @property string $govt_id
 * @property string $uid
 * @property \Carbon\Carbon $date_of_joining
 * @property string $job_title
 * @property integer $department_id
 * @property string $biometric_id
 * @property mixed $education
 * @property mixed $experience
 * @property integer $address_id
 * @property string $bank
 * @property string $beneficiary_name
 * @property string $bank_account_number
 * @property string $ifsc_code
 * @property string $income_tax_id
 * @property boolean $is_disabled
 * @property string $disability
 * @property string $disease
 * @property string $allergy
 * @property string $visible_marks
 * @property string $food_habit
 * @property string $medical_remarks
 * @property boolean $archived
 * @property string $remarks
 * @property integer $school_id
 * @property mixed $additional
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $name
 * @property-read \Scalex\Zero\Models\School $school
 * @property-read \Scalex\Zero\Models\Department $department
 * @property-read \Scalex\Zero\Models\Geo\Address $address
 * @property-read \Scalex\Zero\Models\Attachment $profilePhoto
 * @property-read \Scalex\Zero\User $user
 * @property mixed $extended
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee wherePhotoId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereMiddleName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereDateOfBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereBloodGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereReligion($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereLanguage($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereNationality($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee wherePassport($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereGovtId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereDateOfJoining($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereJobTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereDepartmentId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereBiometricId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereEducation($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereExperience($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereBank($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereBeneficiaryName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereBankAccountNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereIfscCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereIncomeTaxId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereIsDisabled($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereDisability($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereDisease($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereAllergy($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereVisibleMarks($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereFoodHabit($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereMedicalRemarks($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereArchived($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereRemarks($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereSchoolId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereAdditional($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Employee whereUpdatedAt($value)
 */
	class Employee extends \Eloquent {}
}

namespace Scalex\Zero\Models\Geo{
/**
 * Scalex\Zero\Models\Geo\Address
 *
 * @property integer $id
 * @property string $address_line1
 * @property string $address_line2
 * @property string $landmark
 * @property integer $city_id
 * @property string $pin_code
 * @property string $phone
 * @property string $email
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $addressee_type
 * @property integer $addressee_id
 * @property mixed $additional
 * @property-read \Scalex\Zero\Models\Geo\City $city
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $addressee
 * @property mixed $extended
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Address whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Address whereAddressLine1($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Address whereAddressLine2($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Address whereLandmark($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Address whereCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Address wherePinCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Address wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Address whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Address whereAddresseeType($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Address whereAddresseeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Address whereAdditional($value)
 */
	class Address extends \Eloquent {}
}

namespace Scalex\Zero\Models\Geo{
/**
 * Scalex\Zero\Models\Geo\City
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $state_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Scalex\Zero\Models\Geo\State $state
 * @property mixed $extended
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\City whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\City whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\City whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\City whereStateId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\City whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\City whereUpdatedAt($value)
 */
	class City extends \Eloquent {}
}

namespace Scalex\Zero\Models\Geo{
/**
 * Scalex\Zero\Models\Geo\Country
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Scalex\Zero\Models\Geo\State[] $states
 * @property mixed $extended
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Country whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Country whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Country whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\Country whereUpdatedAt($value)
 */
	class Country extends \Eloquent {}
}

namespace Scalex\Zero\Models\Geo{
/**
 * Scalex\Zero\Models\Geo\State
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $country_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Scalex\Zero\Models\Geo\Country $country
 * @property mixed $extended
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\State whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\State whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\State whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\State whereCountryId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\State whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Geo\State whereUpdatedAt($value)
 */
	class State extends \Eloquent {}
}

namespace Scalex\Zero\Models{
/**
 * Scalex\Zero\Models\Guardian
 *
 * @property integer $id
 * @property integer $photo_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property \Carbon\Carbon $date_of_birth
 * @property string $gender
 * @property string $blood_group
 * @property string $category
 * @property string $religion
 * @property string $language
 * @property string $passport
 * @property string $govt_id
 * @property string $phone
 * @property float $income
 * @property integer $address_id
 * @property boolean $is_disabled
 * @property string $disability
 * @property string $disease
 * @property string $allergy
 * @property string $visible_marks
 * @property string $food_habit
 * @property string $medical_remarks
 * @property boolean $archived
 * @property string $remarks
 * @property integer $school_id
 * @property mixed $additional
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $name
 * @property-read \Scalex\Zero\Models\School $school
 * @property-read \Scalex\Zero\Models\Geo\Address $address
 * @property-read \Scalex\Zero\Models\Attachment $profilePhoto
 * @property mixed $extended
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian wherePhotoId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereMiddleName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereDateOfBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereBloodGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereReligion($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereLanguage($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian wherePassport($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereGovtId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereIncome($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereIsDisabled($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereDisability($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereDisease($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereAllergy($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereVisibleMarks($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereFoodHabit($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereMedicalRemarks($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereArchived($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereRemarks($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereSchoolId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereAdditional($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Guardian whereUpdatedAt($value)
 */
	class Guardian extends \Eloquent {}
}

namespace Scalex\Zero\Models{
/**
 * Scalex\Zero\Models\Intent
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $tag
 * @property mixed $body
 * @property boolean $locked
 * @property boolean $retry
 * @property string $remarks
 * @property integer $school_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Scalex\Zero\Models\School $school
 * @property-read \Scalex\Zero\User $user
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Intent whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Intent whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Intent whereTag($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Intent whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Intent whereLocked($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Intent whereRetry($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Intent whereRemarks($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Intent whereSchoolId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Intent whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Intent whereUpdatedAt($value)
 */
	class Intent extends \Eloquent {}
}

namespace Scalex\Zero\Models{
/**
 * Scalex\Zero\Models\School
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $address_id
 * @property string $website
 * @property string $email
 * @property string $phone
 * @property string $fax
 * @property string $medium
 * @property string $university
 * @property string $institute_type
 * @property string $timezone
 * @property integer $logo_id
 * @property boolean $verified
 * @property mixed $additional
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Scalex\Zero\Models\Geo\Address $address
 * @property-read \Scalex\Zero\Models\Attachment $logo
 * @property mixed $extended
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereWebsite($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereMedium($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereUniversity($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereInstituteType($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereTimezone($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereLogoId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereVerified($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereAdditional($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereUpdatedAt($value)
 */
	class School extends \Eloquent {}
}

namespace Scalex\Zero\Models{
/**
 * Scalex\Zero\Models\Student
 *
 * @property integer $id
 * @property integer $photo_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property \Carbon\Carbon $date_of_birth
 * @property string $gender
 * @property string $blood_group
 * @property string $category
 * @property string $religion
 * @property string $language
 * @property string $passport
 * @property string $govt_id
 * @property string $uid
 * @property \Carbon\Carbon $date_of_admission
 * @property string $boarding_type
 * @property integer $department_id
 * @property integer $discipline_id
 * @property string $biometric_id
 * @property integer $address_id
 * @property integer $father_id
 * @property integer $mother_id
 * @property boolean $is_disabled
 * @property string $disability
 * @property string $disease
 * @property string $allergy
 * @property string $visible_marks
 * @property string $food_habit
 * @property string $medical_remarks
 * @property boolean $archived
 * @property string $remarks
 * @property integer $school_id
 * @property mixed $additional
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $name
 * @property-read \Scalex\Zero\Models\School $school
 * @property-read \Scalex\Zero\Models\Department $department
 * @property-read \Scalex\Zero\Models\Discipline $discipline
 * @property-read \Scalex\Zero\Models\Geo\Address $address
 * @property-read \Scalex\Zero\Models\Guardian $father
 * @property-read \Scalex\Zero\Models\Guardian $mother
 * @property-read \Scalex\Zero\Models\Attachment $profilePhoto
 * @property-read \Scalex\Zero\User $user
 * @property mixed $extended
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student wherePhotoId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereMiddleName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereDateOfBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereBloodGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereReligion($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereLanguage($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student wherePassport($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereGovtId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereDateOfAdmission($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereBoardingType($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereDepartmentId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereDisciplineId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereBiometricId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereFatherId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereMotherId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereIsDisabled($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereDisability($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereDisease($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereAllergy($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereVisibleMarks($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereFoodHabit($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereMedicalRemarks($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereArchived($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereRemarks($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereSchoolId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereAdditional($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Student whereUpdatedAt($value)
 */
	class Student extends \Eloquent {}
}

namespace Scalex\Zero\Models{
/**
 * Scalex\Zero\Models\Teacher
 *
 * @property integer $id
 * @property integer $photo_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property \Carbon\Carbon $date_of_birth
 * @property string $gender
 * @property string $blood_group
 * @property string $category
 * @property string $religion
 * @property string $language
 * @property string $nationality
 * @property string $passport
 * @property string $govt_id
 * @property string $uid
 * @property \Carbon\Carbon $date_of_joining
 * @property string $job_title
 * @property integer $department_id
 * @property string $specialization
 * @property string $biometric_id
 * @property mixed $education
 * @property mixed $experience
 * @property integer $address_id
 * @property string $bank
 * @property string $beneficiary_name
 * @property string $bank_account_number
 * @property string $ifsc_code
 * @property string $income_tax_id
 * @property boolean $is_disabled
 * @property string $disability
 * @property string $disease
 * @property string $allergy
 * @property string $visible_marks
 * @property string $food_habit
 * @property string $medical_remarks
 * @property boolean $archived
 * @property string $remarks
 * @property integer $school_id
 * @property mixed $additional
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $name
 * @property-read \Scalex\Zero\Models\School $school
 * @property-read \Scalex\Zero\Models\Department $department
 * @property-read \Scalex\Zero\Models\Geo\Address $address
 * @property-read \Scalex\Zero\Models\Attachment $profilePhoto
 * @property-read \Scalex\Zero\User $user
 * @property mixed $extended
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher wherePhotoId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereMiddleName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereDateOfBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereBloodGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereReligion($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereLanguage($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereNationality($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher wherePassport($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereGovtId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereDateOfJoining($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereJobTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereDepartmentId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereSpecialization($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereBiometricId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereEducation($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereExperience($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereAddressId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereBank($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereBeneficiaryName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereBankAccountNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereIfscCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereIncomeTaxId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereIsDisabled($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereDisability($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereDisease($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereAllergy($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereVisibleMarks($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereFoodHabit($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereMedicalRemarks($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereArchived($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereRemarks($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereSchoolId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereAdditional($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\Teacher whereUpdatedAt($value)
 */
	class Teacher extends \Eloquent {}
}

namespace Scalex\Zero{
/**
 * Scalex\Zero\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $photo_id
 * @property integer $person_id
 * @property string $person_type
 * @property integer $school_id
 * @property mixed $additional
 * @property string $verification_token
 * @property string $remember_token
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Scalex\Zero\Models\School $school
 * @property-read \Scalex\Zero\Models\Attachment $profilePhoto
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $person
 * @property mixed $extended
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Znck\Trust\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Znck\Trust\Models\Permission[] $permissions
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\User wherePhotoId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\User wherePersonId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\User wherePersonType($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\User whereSchoolId($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\User whereAdditional($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\User whereVerificationToken($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

