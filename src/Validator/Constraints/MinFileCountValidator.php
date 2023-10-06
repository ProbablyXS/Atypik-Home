<?php
// src/Validator/Constraints/MinFileCountValidator.php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MinFileCountValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // Ensure that the value (uploaded files array) is an array and contains at least the specified minimum number of files.
        if (!is_array($value) || count($value) < $constraint->limit) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ limit }}', $constraint->limit)
                ->addViolation();
        }
    }
}