<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Role;
use Znck\Transformers\Transformer;

class RoleTransformer extends Transformer
{
    public function show(Role $role)
    {
        return $this->index($role);
    }

    public function index(Role $role)
    {
        return [
            'name' => (string)$role->name,
            'description' => (string)$role->description,
        ];
    }
}
