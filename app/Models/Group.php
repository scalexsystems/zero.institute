<?php namespace Scalex\Zero\Models;

use DB;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Database\Eloquent\Collection;
use Scalex\Zero\Contracts\Communication\ReceivesMessage;
use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\Others\LastMessageAt;
use Scalex\Zero\User;

class Group extends BaseModel implements ReceivesMessage
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = ['name', 'description', 'private'];

    protected $casts = ['private' => 'bool'];

    protected $extends = ['count_members'];

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

    public function lastMessageAt() {
        return new LastMessageAt((new Message())->newQuery(), $this);
    }

    /*
    |
    | Group Actions.
    |
    */

    public function isAdmin(User $member) {
        return false;
    }

    public function isMember(User $member) {
        $id = $member->getKey();

        if (array_key_exists($id, $this->isMemberCache)) {
            return $this->isMemberCache[$id];
        }

        return $this->isMemberCache[$id] = !is_null(
            DB::table('group_user')
              ->where('group_id', $this->getKey())
              ->where('user_id', $id)
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

        return DB::table('group_user')
                 ->where('group_id', $this->getKey())
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

    public function addMembers(array $ids) {
        $prepared = $this->prepareMemberIds($ids);
        $ids = $prepared['ids'];

        if (count($ids)) {
            $this->members()->attach($ids);
            $this->count_members = $this->members()->count();
            $this->save();
        }

        return $prepared;
    }

    public function removeMembers(array $ids) {
        $prepared = $this->prepareMemberIds($ids, false);
        $ids = $prepared['ids'];

        if (count($ids)) {
            $this->members()->detach($ids);
            $this->count_members = $this->members()->count();
            $this->save();
        }

        return $prepared;
    }

    public function getChannelName() : string {
        return $this->getMorphClass().'-'.$this->getKey();
    }

    public function getChannel() {
        return new PresenceChannel($this->getChannelName());
    }

    /**
     * @param array $ids
     *
     * @return array
     */
    protected function prepareMemberIds(array $ids, bool $add = true):array {
        $method = $add ? 'filterNonMemberIds' : 'filterMemberIds';
        $ids = $original = array_map(function ($v) {
            return (int)$v;
        }, array_unique($ids));

        if (!is_null($this->school_id)) {
            $ids = $school = DB::table('users')->select('id')->whereIn('id', $ids)->pluck('id')->toArray();
        }

        $ids = $filtered = $this->$method($ids);

        return compact('ids', 'original', 'filtered', 'school');
    }
}
