<?php namespace Scalex\Zero\Others;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;

class LastMessageAt extends Relation
{
    public function addConstraints()
    {
        $this->getBaseQuery()->where('receiver_type', $this->getParent()->getMorphClass())
             ->orderBy('id', 'desc');

        if (self::$constraints) {
            $this->getBaseQuery()->where('receiver_id', $this->getParent()->getKey());
        }
    }

    public function addEagerConstraints(array $models)
    {
        $this->getBaseQuery()->whereIn('receiver_id', (new Collection($models))->modelKeys());
    }

    public function initRelation(array $models, $relation)
    {
        foreach ($models as $model) {
            $model->setRelation($relation, null);
        }

        return $models;
    }

    public function match(array $models, Collection $results, $relation)
    {
        $dictionary = [];

        foreach ($results as $result) {
            $dictionary[$result['receiver_id']] = $result;
        }

        foreach ($models as $model) {
            if (isset($dictionary[$model->getKey()])) {
                $model->setRelation($relation, $dictionary[$model->getKey()]);
            }
        }

        return $models;
    }

    public function getResults()
    {
        return $this->getBaseQuery()->first();
    }
}
