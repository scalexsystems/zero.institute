<?php namespace Scalex\Zero\Database;

use Illuminate\Database\Eloquent\Model;
use Znck\Extend\Extendible;

abstract class ExtendibleModel extends Model
{
    use Extendible;
}
