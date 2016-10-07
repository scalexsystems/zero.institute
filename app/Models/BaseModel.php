<?php namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Znck\Plug\Eloquent\Traits\FixBelongsTo;
use Znck\Plug\Eloquent\Traits\FixForeignKey;
use Znck\Plug\Eloquent\Traits\FixMorphTo;
use Znck\Plug\Eloquent\Traits\UuidKey;

abstract class BaseModel extends Model
{
    use Searchable;

    protected $searchable = ['*'];

    public function toSearchableArray() {
        $fields = $this->getSearchableFields();

        if ($fields === ['*']) {
            return $this->toArray();
        }

        $fields = array_merge($fields, [$this->getKeyName()]);

        $data = [];

        foreach ($fields as $key) {
            $data[$key] = $this->{$key};
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getSearchableFields(): array {
        return $this->searchable;
    }
}
