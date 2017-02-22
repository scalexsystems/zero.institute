<?php namespace Scalex\Zero\Repositories;

use Carbon\Carbon;
use DB;
use Illuminate\Http\UploadedFile;
use Ramsey\Uuid\Uuid;
use Request;
use Scalex\Zero\Criteria\Group\MessagesCount;
use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\Group;
use Scalex\Zero\User;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Znck\Attach\Builder;
use Znck\Repositories\Repository;

/**
 * @method Group find(string | int $id)
 * @method Group findBy(string $key, $value)
 * @method Group create(array $attr)
 * @method Group update(string | int | Group $id, array $attr, array $o = [])
 * @method Group delete(string | int | Group $id)
 * @method GroupRepository validate(array $attr, Group | null $model)
 */
class GroupRepository extends Repository
{
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
        'private' => 'nullable|bool',
        'description' => 'nullable',
    ];

    /**
     * Add default criteria.
     */
    public function boot()
    {
        if ($user = Request::user()) {
            $this->pushCriteria(new OfSchool($user->school));
        }
    }

    /**
     * Update group photo.
     *
     * @param \Scalex\Zero\Models\Group $group
     * @param Attachment $photo
     *
     * @return \Scalex\Zero\Models\Group
     */
    public function updatePhoto(Group $group, UploadedFile $file, User $user)
    {
        $photo = $this->uploadProfilePhoto($group, $file, $user);

        $group->photo()->associate($photo);

        $this->onUpdate($group->update());

        return $group;
    }

    /**
     * Create a group and add members.
     *
     * @param \Scalex\Zero\User $user
     * @param array $attributes
     * @param array $members
     *
     * @return \Scalex\Zero\Models\Group
     */
    public function createWithMembers(User $user, array $attributes, array $members = [])
    {
        $this->validateWith($attributes);

        $group = new Group($attributes);

        if (array_has($attributes, 'type')) {
            $group->type = $attributes['type'];
        }

        $group->school()->associate($user->school);
        $group->owner()->associate($user);

        $this->onCreate($group->save());

        $group->addMembers($members);

        return $group;
    }

    /**
     * Get members of a group.
     *
     * @param \Scalex\Zero\Models\Group $group
     * @param string|null $query
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function members(Group $group, string $query = null)
    {
        $query = $group->members()->getQuery();

        $query->with('person', 'profilePhoto')->orderBy('name');

        return $query->paginate();
    }

    /**
     * Get groups of a user.
     *
     * @param \Scalex\Zero\User $user
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function groupsFor(User $user)
    {
        $query = $user->groups()->getQuery();

        $query->with('photo')->orderBy('name');

        $count = new MessagesCount($user);

        $count->apply($query, $this);

        return $query->paginate();
    }

    /**
     * Upload attachment to group.
     *
     * @param \Scalex\Zero\Models\Group $group
     * @param \Illuminate\Http\UploadedFile $file
     * @param \Scalex\Zero\User $user
     * @param array $attributes
     *
     * @return \Scalex\Zero\Models\Attachment
     */
    public function uploadAttachment(Group $group, UploadedFile $file, User $user, array $attributes = [])
    {
        return $this->upload($group, $file, $user, $attributes, false);
    }

    /**
     * Upload group photo.
     *
     * @param \Scalex\Zero\Models\Group $group
     * @param \Illuminate\Http\UploadedFile $file
     * @param \Scalex\Zero\User $user
     * @param array $attributes
     *
     * @return \Scalex\Zero\Models\Attachment
     */
    public function uploadProfilePhoto(Group $group, UploadedFile $file, User $user, array $attributes = [])
    {
        return $this->upload($group, $file, $user, $attributes, true, 450);
    }

    /**
     * Attachment upload path.
     *
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return string
     */
    protected function getAttachmentUploadPath(Group $group)
    {
        $date = Carbon::now()->format('Y-m-d');

        if ($group->school_id) {
            return "schools/{$group->school_id}/groups/attachments/${date}/{$group->id}";
        }

        return "groups/attachments/${date}/{$group->id}";
    }

    /**
     * Group photo upload path.
     *
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return string
     */
    protected function getPhotoUploadPath(Group $group)
    {
        if ($group->school_id) {
            return "schools/{$group->school_id}/groups/photo/{$group->id}";
        }

        return "groups/photo/{$group->id}";
    }

    /**
     * Upload file to group.
     *
     * @param \Scalex\Zero\Models\Group $group
     * @param \Illuminate\Http\UploadedFile $file
     * @param \Scalex\Zero\User $user
     * @param array $attributes
     * @param bool $isGroupPhoto
     * @param $width
     *
     * @return \Scalex\Zero\Models\Attachment
     */
    protected function upload(
        Group $group,
        UploadedFile $file,
        User $user,
        array $attributes,
        bool $isGroupPhoto,
        $width = 1200
    ): Attachment {
        if (!$file->isValid()) {
            throw new UploadException('Invalid file.');
        }

        $attributes['path'] = $isGroupPhoto ? $this->getPhotoUploadPath($group) : $this->getAttachmentUploadPath($group);
        $attributes['slug'] = $attributes['slug'] ?? Uuid::uuid4();

        $uploader = Builder::makeFromFile($file);

        if ($this->isImage($file)) {
            $uploader->resize(4096)->resize($width, 'preview');
        }

        $attachment = $uploader->upload($attributes)->getAttachment();

        $attachment->owner()->associate($user);
        $attachment->related()->associate($group);

        $this->onCreate($attachment->save());

        return $attachment;
    }

    public function removePhoto(Group $group)
    {
        $group->photo()->dissociate();

        $this->onUpdate($group->update());
    }

    protected function isImage(UploadedFile $file)
    {
        return in_array($file->guessExtension(), ['jpeg', 'png', 'gif', 'bmp', 'tiff']);
    }
}
