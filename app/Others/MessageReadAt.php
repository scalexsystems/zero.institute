<?php namespace Scalex\Zero\Others;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Scalex\Zero\User;

class MessageReadAt extends Relation
{
    public function __construct(Builder $query, User $parent) {
        parent::__construct($query, $parent);
    }

    public function addConstraints() {
        $this->getBaseQuery()
             ->from('message_reads')
             ->select()
             ->where('user_id', $this->getParent()->getKey());

        if (static::$constraints) {
            $this->getBaseQuery()->where('message_id', $this->getRelated()->getKey());
        }
    }

    public function addEagerConstraints(array $models) {
        $this->getBaseQuery()->whereIn('message_id', (new Collection($models))->modelKeys());
    }

    public function initRelation(array $models, $relation) {
        foreach ($models as $model) {
            $model->setRelation($relation, null);
        }

        return $models;
    }

    public function match(array $models, Collection $results, $relation) {
        $dictionary = [];

        foreach ($results as $result) {
            $dictionary[$result['message_id']] = $result['read_at'];
        }

        foreach ($models as $model) {
            if (isset($dictionary[$model->getKey()])) {
                $model->setRelation($relation, new Carbon($dictionary[$model->getKey()]));
            }
        }

        return $models;
    }

    public function getResults() {
        return $this->getBaseQuery()->first();
    }

    public function create(User $user) {
        return $this->getBaseQuery()->from('message_reads')
                    ->insert([
                                 'message_id' => $this->getRelated()->getKey(),
                                 'user_id' => $user->getKey(),
                                 'read_at' => Carbon::now(),
                             ]);
    }
}
