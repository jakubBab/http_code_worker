<?php

declare(strict_types=1);

namespace App\Util\Manager;

use App\Entity\UrlStatus;
use App\Repository\UrlRepository;
use App\Repository\UrlStatusRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;

class UrlManager
{
    /** @var UrlRepository */
    private $urlRepository;

    /** @var UrlStatusRepository */
    private $urlStatusReposistory;

    /** @var \Symfony\Component\Validator\Validator\ValidatorInterface */
    private $validator;

    private $errors = [];

    public function __construct(
        UrlRepository $urlRepository,
        UrlStatusRepository $urlStatusRepository)
    {
        $this->urlRepository = $urlRepository;
        $this->urlStatusReposistory = $urlStatusRepository;
        $this->validator = Validation::createValidator();
    }

    public function create(string $url): bool
    {
        /** @var UrlStatus $statusNew */
        $statusNew = $this->urlStatusReposistory->findOneBy(['name' => 'new']);

        $urlEntity = $this->urlRepository->getEntity();
        $urlEntity->setUrl($url);
        $urlEntity->setStatus($statusNew);

        $this->validate($urlEntity);

        if (!empty($this->errors)) {
            return false;
        }
        try {
            $this->urlRepository->save($urlEntity);
        } catch (UniqueConstraintViolationException $exception) {
            $this->errors[] = sprintf('Url %s already exists', $urlEntity->getUrl());
            return false;
        }
        
        return true;
    }

    private function validate($entity): void
    {
        $errors = $this->validator->validate($entity);
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $this->errors[] = $error->getMessage();
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
