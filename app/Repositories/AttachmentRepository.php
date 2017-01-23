<?php namespace Scalex\Zero\Repositories;

use Scalex\Zero\Models\Attachment;
use Znck\Repositories\Repository;

/**
 * @method Attachment find(string|int $id)
 * @method Attachment findBy(string $key, $value)
 * @method Attachment create(array $attr)
 * @method Attachment update(string|int|Attachment $id, array $attr, array $o = [])
 * @method Attachment delete(string|int|Attachment $id)
 * @method AttachmentRepository validate(array $attr, Attachment|null $model)
 */
class AttachmentRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Attachment::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [];
}
