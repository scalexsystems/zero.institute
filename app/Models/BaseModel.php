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
}
