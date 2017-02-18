<?php namespace Scalex\Zero\ModelTraits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Scalex\Zero\User;

trait GroupTrait
{
    protected $isMemberCache = [];

    public function isOfType(string $type)
    {
        if (is_null($this->type)) {
            return false;
        }

        return hash_equals($this->type, $type);
    }

    /**
     * Is user an admin?
     *
     * @param \Scalex\Zero\Others\User $member
     *
     * @return bool
     */
    public function isAdmin(User $member)
    {
        return false;
    }

    /**
     * Is user a member?
     *
     * @param \Scalex\Zero\User $member
     *
     * @return bool
     */
    public function isMember(User $member)
    {
        if (!isset($this->isMemberCache[$member->getKey()])) {
            $this->checkMembers($member);
        }

        return $this->isMemberCache[$member->getKey()];
    }

    /**
     * Add members to group.
     *
     * @param Collection|array|Model|int $users
     *
     * @return Collection
     */
    public function addMembers($users)
    {
        $users = $this->filterNonMembers($users);

        $this->members()->attach($users->toArray());
        $this->fireModelEvent('membersAdded');

        return $users;
    }

    /**
     * Add members to group.
     *
     * @param Collection|array|Model|int $users
     *
     * @return Collection
     */
    public function removeMembers($users)
    {
        $users = $this->filterMembers($users);

        if (!count($users)) {
            return $users;
        }

        $this->members()->detach($users->toArray());
        $this->fireModelEvent('membersRemoved');

        return $users;
    }

    /**
     * Normalize to collection of ids.
     *
     * @param mixed $any
     *
     * @return \Illuminate\Support\Collection
     */
    protected function normalizeMembers($any)
    {
        if ($any instanceof User) {
            return collect($any->getKey());
        }
        if ($any instanceof \Illuminate\Database\Eloquent\Collection) {
            return collect($any->modelKeys());
        }
        if (is_int($any)) {
            return collect($any);
        }
        if (is_array($any) or $any instanceof Collection) {
            if (count($any) === 0) {
                return collect();
            }

            $first = array_first($any);

            if (is_int($first)) {
                return collect($any);
            }

            if ($first instanceof User) {
                return collect($any->getKey());
            }
        }

        throw new InvalidArgumentException('Unexpected member type ('.get_class($any).') for group.');
    }

    /**
     * Get ids of members
     *
     * @param mixed $members
     *
     * @return \Illuminate\Support\Collection
     */
    public function filter($users)
    {
        $users = $this->normalizeMembers($users);

        $new = $users->filter(function ($id) {
            return !isset($this->isMemberCache[$id]);
        });

        $this->checkMembers($new);

        return $users->groupBy(function ($id) {
            return $this->isMemberCache[$id] ? 'member' : 'nonmember';
        });
    }

    /**
     * Get ids of members
     *
     * @param mixed $members
     *
     * @return \Illuminate\Support\Collection
     */
    public function filterMembers($users)
    {
        return collect($this->filter($users)->get('member'));
    }

    /**
     * Get ids of members
     *
     * @param mixed $members
     *
     * @return \Illuminate\Support\Collection
     */
    public function filterNonMembers($users)
    {
        return collect($this->filter($users)->get('nonmember'));
    }

    /**
     * Check member in database.
     *
     * @param mixed $users
     *
     * @return \Illuminate\Support\Collection
     */
    protected function checkMembers($users)
    {
        $users = $this->normalizeMembers($users);

        $result = $this->newBaseQueryBuilder()
                       ->select('user_id')
                       ->from('group_user')
                       ->where('group_id', $this->getKey())
                       ->whereIn('user_id', $users->toArray())
                       ->get()->keyBy('user_id');

        return $users->combine($users->map(function ($id) use ($result) {
            return $this->isMemberCache[$id] = $result->has($id);
        }));
    }
}
