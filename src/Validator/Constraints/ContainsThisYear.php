<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsThisYear extends Constraint
{
    public $message = 'The value {{ value }} is invalid: it cannot be fixed after this year.';
}