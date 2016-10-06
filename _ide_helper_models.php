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
 */
	class Attachment extends \Eloquent {}
}

namespace Scalex\Zero\Models\Geo{
/**
 * Scalex\Zero\Models\Geo\Address
 *
 * @property string $id
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
 * @property string $addressee_id
 * @property string $additional
 * @property-read \Scalex\Zero\Models\Geo\City $city
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $addressee
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
 * Scalex\Zero\Models\School
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string $address_id
 * @property string $website
 * @property string $email
 * @property string $phone
 * @property string $fax
 * @property string $medium
 * @property string $university
 * @property string $institute_type
 * @property string $timezone
 * @property string $logo_id
 * @property boolean $verified
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $additional
 * @property-read \Scalex\Zero\Models\Geo\Address $address
 * @property-read \Scalex\Zero\Models\Attachment $logo
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
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Scalex\Zero\Models\School whereAdditional($value)
 */
	class School extends \Eloquent {}
}

namespace Scalex\Zero{
/**
 * Scalex\Zero\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $photo_id
 * @property string $person_id
 * @property string $person_type
 * @property string $school_id
 * @property string $additional
 * @property string $verification_token
 * @property string $remember_token
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Scalex\Zero\Models\School $school
 * @property-read \Scalex\Zero\Models\Attachment $profilePhoto
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $person
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
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

