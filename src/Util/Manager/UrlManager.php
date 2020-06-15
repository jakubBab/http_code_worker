<?php

declare(strict_types=1);

namespace App\Util\Manager;

use App\Entity\Url;
use App\Entity\UrlStatus;
use App\Repository\UrlRepository;
use App\Repository\UrlStatusRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UrlManager
{
    /** @var UrlRepository */
    private $urlRepository;

    /** @var UrlStatusRepository */
    private $urlStatusRepository;

    /** @var ValidatorInterface */
    private $validator;

    private $errors = [];

    /** @var Url */
    private $urlEntity;

    public function __construct(
        UrlRepository $urlRepository,
        UrlStatusRepository $urlStatusRepository)
    {
        $this->urlRepository = $urlRepository;
        $this->urlStatusRepository = $urlStatusRepository;
        $this->validator = Validation::createValidator();
    }

    public function create(string $url): bool
    {
        /** @var UrlStatus $statusNew */
        $statusNew = $this->urlStatusRepository->findOneBy(['name' => UrlStatus::NEW]);

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

        $this->urlEntity = $urlEntity;

        return true;
    }

    public function markUrlAsProcessed(Url $url)
    {
        $statusProcessed = $this->urlStatusRepository->findOneBy(['name' => UrlStatus::PROCESSING]);
        $this->changeUrlStatus($url, $statusProcessed);
    }

    public function markUrlAsError(Url $url)
    {
        $statusError = $this->urlStatusRepository->findOneBy(['name' => UrlStatus::ERROR]);
        $this->changeUrlStatus($url, $statusError);
    }

    public function markUrlAsDone(Url $url)
    {
        $statusDone = $this->urlStatusRepository->findOneBy(['name' => UrlStatus::DONE]);
        $this->changeUrlStatus($url, $statusDone);
    }

    private function changeUrlStatus(Url $url, UrlStatus $status)
    {
        $url->setStatus($status);
        $this->urlRepository->save($url);
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

    public function getUrlEntity()
    {
        return $this->urlEntity;
    }
}
