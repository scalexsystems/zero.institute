<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Znck\Repositories\Exceptions\NotFoundResourceException;

if (!function_exists('find')) {
    function find(array $attributes, string $key, string $class = null) {
        if ($useId = Str::endsWith($key, '_id')) {
            $key = str_replace_last('_id', '', $key);
        }

        $model = array_get($attributes, $key);

        if (verify_school($model)) {
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
    function verify_school(Model $model) {
        if ($model instanceof BelongsToSchool) {
            return Auth::check() and hash_equals(Auth::user()->school_id, $model->school_id);
        }

        return true;
    }
}

if (!function_exists('morph_model')) {
    function morph_model(string $model) {
        $map = \Illuminate\Database\Eloquent\Relations\Relation::morphMap();
        if (class_exists($model)) {
            return $map[$model] ?? $model;
        } else {
            $inverted = array_flip($map);

            return $inverted[$model];
        }
    }
}
