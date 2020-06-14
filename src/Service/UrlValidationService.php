<?php

declare(strict_types=1);

namespace App\Service;

use App\Util\Validation\UrlCommandValidation;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UrlValidationService
{
    /** @var UrlCommandValidation */
    private $constraints;

    /** @var ValidatorInterface */
    private $validator;

    /** @var ConstraintViolationListInterface */
    private $errors;

    public function __construct(UrlCommandValidation $urlCommandValidation)
    {
        $this->constraints = $urlCommandValidation->getConstraints();
        $this->validator = Validation::createValidator();
    }

    public function validate(array $dataToValidate): void
    {
        $this->errors = $this->validator->validate($dataToValidate, $this->constraints);
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getErrors(): Object
    {
        return $this->errors;
    }

    public function getErrorMessages(): array
    {
        $errorMessages = [];
        if (!$this->hasErrors()) {
            return $errorMessages;
        }
        /** @var ConstraintViolation $error */
        foreach ($this->getErrors() as $error) {
            $errorMessages[] = $error->getMessage();
        }

        return $errorMessages;
    }
}
