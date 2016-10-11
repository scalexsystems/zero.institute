<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Models\School;
use Znck\Repositories\Exceptions\NotFoundResourceException;

if (!function_exists('find')) {
    /**
     * @param array $attributes
     * @param string $key
     * @param string|null $class
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    function find(array $attributes, string $key, string $class = null) {
        if ($useId = Str::endsWith($key, '_id')) {
            $key = preg_replace('/_id$/', '', $key);
        }

        $model = array_get($attributes, $key);

        if ($model instanceof Model and verify_school($model)) {
            return $model;
        }

        if ($useId !== true) {
            return null;
        }

        if (is_null($class)) {
            $class = morph_model($key);
        }

        $id = array_get($attributes, $key.'_id');

        try {
            return repository($class)->find($id);
        } catch (NotFoundResourceException $e) {
            return null;
        }
    }
}

if (!function_exists('verify_school')) {
    /**
     * @param \Illuminate\Database\Eloquent\Model|BelongsToSchool $model
     * @param \Scalex\Zero\Models\School|null $school
     *
     * @return bool
     */
    function verify_school($model, School $school = null) {
        if ($model instanceof BelongsToSchool) {
            if (!is_null($school)) {
                return $school->getKey() === $model->school_id;
            }

            return current_user()->school_id === $model->school_id;
        }

        return true;
    }
}

if (!function_exists('morph_model')) {
    /**
     * @param string|\Illuminate\Database\Eloquent\Model $model
     *
     * @return string
     */
    function morph_model($model) {
        $model = $model instanceof Model ? get_class($model) : (string)$model;

        $map = Relation::morphMap();
        if (class_exists($model)) {
            $inverted = array_flip($map);

            return $inverted[$model] ?? $model;
        } else {
            return $map[$model] ?? $model;
        }
    }
}

if (!function_exists('current_user')) {
    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|\Scalex\Zero\User
     */
    function current_user() {
        return auth()->user();
    }
}

if (!function_exists('allow')) {
    function allow(string $what, $who, $resource, $default = null) {

        return Gate::allows($what, $who) ? $resource : $default;
    }
}

if (!function_exists('once')) {
    function once(\Closure $fn) {
        $once = false;

        return function () use ($fn, $once) {
            if ($once) {
                return true;
            }

            /** @noinspection PhpUnusedLocalVariableInspection */
            $once = true;

            return call_user_func_array($fn, func_get_args());
        };
    }
}

if (!function_exists('attach_attachment')) {
    function attach_attachment(Model $related, string $relation, Attachment $attachment) {
        $related->$relation()->associate($attachment);
        $related->saved(
            once(
                function ($related) use ($attachment) {
                    $attachment->related()->associate($related)->save();
                }
            )
        );
    }
}

if (!function_exists('school_cache')) {
    function schoolify(string $key) {
        return current_user()->school_id.'.'.$key;
    }
}

if (!function_exists('iso_date')) {
    function iso_date($date) {
        if ($date instanceof \Carbon\Carbon) {
            return $date->toIso8601String();
        }

        return '';
    }
}
