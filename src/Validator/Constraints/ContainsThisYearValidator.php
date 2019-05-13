<?php

// src/Validator/Constraints/ContainsAlphanumericValidator.php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ContainsThisYearValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $thisYear = date("Y");
		
		if (!$constraint instanceof ContainsThisYear) {
            throw new UnexpectedTypeException($constraint, ContainsThisYear::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) take care of that
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_numeric($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, 'Int');

            // separate multiple types using pipes
            // throw new UnexpectedValueException($value, 'string|int');
        }
		
		if ($thisYear >= $value)
			return;
		else {
			$this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
		}

    }
}
