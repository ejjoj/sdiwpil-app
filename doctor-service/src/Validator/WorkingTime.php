<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class WorkingTime extends Constraint
{
    public string $message = 'Godzina zakończenia "{{ end_time }}" jest wcześniejsza niż godzina rozpoczęcia "{{ start_time }}" następnego okresu.';
}
