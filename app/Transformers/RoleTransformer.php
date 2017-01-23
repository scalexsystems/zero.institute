<?php namespace Scalex\Zero\Transformers;

use Znck\Transformers\Transformer;
use Znck\Trust\Models\Role;

class RoleTransformer extends Transformer
{
    public function show(Role $model)
    {
        return $model->toArray();
    }
    
    public function index(Role $model)
    {
        return $model->toArray();
    }
}
