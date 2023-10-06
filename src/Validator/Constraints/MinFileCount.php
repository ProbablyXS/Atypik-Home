<?php
// src/Validator/Constraints/MinFileCount.php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class MinFileCount extends Constraint
{
    public $message = 'Vous devez envoyer au minimum {{ limit }} image(s).';
    public $limit;

    public function __construct($options = null)
    {
        parent::__construct($options);

        if ($this->limit === null) {
            throw new \InvalidArgumentException('The "limit" option must be set for the MinFileCount constraint.');
        }
    }

    public function validatedBy()
    {
        return static::class . 'Validator';
    }
}