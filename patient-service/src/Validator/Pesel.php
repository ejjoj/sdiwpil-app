<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Pesel extends Constraint
{
    public string $message = 'The value "{{ value }}" is not valid.';
    public string $existsMessage = 'The value "{{ value }}" already exists.';
}
