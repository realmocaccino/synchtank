<?php

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class TrackValidationException extends \RuntimeException
{
    public function __construct(
        private ConstraintViolationListInterface $violations
    ) {
        parent::__construct('Track validation failed.');
    }

    public function getErrors(): array
    {
        $errors = [];

        foreach ($this->violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors;
    }
}