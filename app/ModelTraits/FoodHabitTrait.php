<?php namespace Scalex\Zero\ModelTraits;

trait FoodHabitTrait
{
    public function getFoodHabitAttribute()
    {
        return (isset($this->attributes['food_habit']) and is_string($this->attributes['food_habit']))
            ? explode('|', $this->attributes['food_habit'])
            : [];
    }

    public function setFoodHabitAttribute($value)
    {
        $this->attributes['food_habit'] = implode('|', (array)$value);
    }
}
