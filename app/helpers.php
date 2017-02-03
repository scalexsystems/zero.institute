<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Models\School;
use Znck\Repositories\Exceptions\NotFoundResourceException;

// TODO: Remove this after 5.4 upgrade.
if (!function_exists('mix')) {
    $manifest = null;

    /**
     * Laravel Mix Polyfill.
     *
     * @param  string $path
     *
     * @return string
     */
    function mix($path, $manifest = false, $shouldHotReload = false) {
        if (!$manifest) {
            static $manifest;
        }
        if (!$shouldHotReload) {
            static $shouldHotReload;
        }
        if (!$manifest) {
            $manifestPath = public_path('mix-manifest.json');
            $shouldHotReload = file_exists(public_path('hot'));
            if (!file_exists($manifestPath)) {
                $manifest = [];
            } else {
                $manifest = json_decode(file_get_contents($manifestPath), true);
            }
        }
        if (!starts_with($path, '/')) {
            $path = "/${path}";
        }

        if (!array_key_exists($path, $manifest)) {
            return false;
        }

        return $shouldHotReload
            ? "http://localhost:8080{$manifest[$path]}"
            : url($manifest[$path]);
    }
}


if (!function_exists('find')) {
    /**
     * @param array $attributes
     * @param string $key
     * @param string|null $class
     *
     * @deprecated
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

        if (!is_numeric($id)) {
            return null;
        }

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
     * @deprecated
     * @return bool
     */
    function verify_school($model, School $school = null) {
        if ($model instanceof BelongsToSchool) {
            if (!is_null($school)) {
                return (int)$school->getKey() === (int)$model->school_id;
            }

            return (int)current_user()->school_id === (int)$model->school_id;
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
    function morph_model($model, $map = false, $invertedMap = false) {
        $model = $model instanceof Model ? get_class($model) : (string)$model;

        if (!$map) {
            static $map;
        }

        if (!$invertedMap) {
            static $invertedMap;
        }

        if (!$map) {
            $map = Relation::morphMap();
        }

        if (!$invertedMap) {
            $invertedMap = array_flip($map);
        }

        if (class_exists($model)) {
            return $invertedMap[$model] ?? $model;
        } else {
            return $map[$model] ?? $model;
        }
    }
}

if (!function_exists('current_user')) {
    /**
     * @deprecated
     * @return \Illuminate\Contracts\Auth\Authenticatable|\Scalex\Zero\User
     */
    function current_user() {
        return Request::user();
    }
}

if (!function_exists('allow')) {
    /**
     * @param string $what
     * @param $who
     * @param $resource
     * @param null $default
     *
     * @deprecated
     * @return null
     */
    function allow(string $what, $who, $resource, $default = null) {
        return Gate::allows($what, $who) ? $resource : $default;
    }
}

if (!function_exists('attach_attachment')) {
    /**
     * @param \Illuminate\Database\Eloquent\Model $related
     * @param string|null $relation
     * @param \Scalex\Zero\Models\Attachment $attachment
     *
     * @deprecated
     */
    function attach_attachment(Model $related, string $relation = null, Attachment $attachment) {
        if (is_string($relation)) {
            $related->$relation()->associate($attachment);
        }

        $related->saved(function ($related) use ($attachment) {
            $attachment->related()->associate($related)->save();
        });
    }
}

if (!function_exists('schoolScopeCacheKey')) {
    function schoolScopeCacheKey(string $key, $school = null) {
        $school = $school ?? Request::user()->school_id;

        return "school:{$school}.{$key}";
    }
}

if (!function_exists('iso_date')) {
    function iso_date($date) {
        if ($date instanceof \Carbon\Carbon) {
            return $date->toIso8601String();
        }

        return (string)$date;
    }
}
