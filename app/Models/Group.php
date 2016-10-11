<?php namespace Scalex\Zero\Models;

use DB;
use Illuminate\Database\Eloquent\Collection;
use Scalex\Zero\Contracts\Communication\ReceivesMessage;
use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\User;

class Group extends BaseModel implements ReceivesMessage
{
    protected $fillable = ['name', 'description', 'private'];

    protected $casts = ['private' => 'bool'];

    protected $isMemberCache = [];

    public function members() {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function owner() {
        return $this->belongsTo(User::class);
    }

    public function school() {
        return $this->belongsTo(School::class);
    }

    public function profilePhoto() {
        return $this->belongsTo(Attachment::class, 'photo_id');
    }

    /*
    |
    | Group Actions.
    |
    */

    public function isMember(User $member) {
        $id = $member->getKey();

        if (array_key_exists($id, $this->isMemberCache)) {
            return $this->isMemberCache[$id];
        }

        return $this->isMemberCache[$id] = !is_null(
            DB::table($this->getTable())
              ->where($this->getForeignKey(), $this->getKey())
              ->where($member->getForeignKey(), $id)
              ->first()
        );
    }

    /**
     * Get ids of members
     *
     * @param array|Collection $members
     *
     * @return array
     */
    public function filterMemberIds($members) {
        if ($members instanceof Collection) {
            $members = $members->modelKeys();
        }

        return DB::table($this->getTable())
                 ->where($this->getForeignKey(), $this->getKey())
                 ->whereIn('user_id', $members)
                 ->get()->pluck('user_id')->toArray();
    }

    /**
     * Get ids of members
     *
     * @param array|Collection $members
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filterMembers($members) {
        return User::findMany($this->filterMemberIds($members));
    }

    /**
     * Get ids of members
     *
     * @param array|Collection $members
     *
     * @return array
     */
    public function filterNonMemberIds($members) {
        if ($members instanceof Collection) {
            $members = $members->modelKeys();
        }

        return array_diff($members, $this->filterMemberIds($members));
    }

    /**
     * @param array|Collection $members
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filterNonMembers($members) {
        return User::findMany($this->filterNonMemberIds($members));
    }

    public function getChannelName() {
        return 'group-'.$this->getKey();
    }
}
