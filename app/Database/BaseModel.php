<?php namespace Scalex\Zero\Database;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Scalex\Zero\Database\ExtendibleModel;
use Znck\Extend\Extendible;
use Znck\Plug\Eloquent\Traits\FixBelongsTo;
use Znck\Plug\Eloquent\Traits\FixForeignKey;
use Znck\Plug\Eloquent\Traits\FixMorphTo;
use Znck\Plug\Eloquent\Traits\UuidKey;

abstract class BaseModel extends ExtendibleModel
{
    use Searchable;

    protected $searchable = ['*'];

    public function toSearchableArray()
    {
        $fields = $this->getSearchableFields();

        if ($fields === ['*']) {
            return $this->attributesToArray();
        }

        $fields = array_merge($fields, [$this->getKeyName()]);

        $data = [];

        foreach ($fields as $key) {
            $data[$key] = $this->{$key};
        }

        return $data;
    }

    public function getSearchableFields(): array
    {
        return $this->searchable;
    }
}
