<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UrlRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UrlRepository::class)
 * @UniqueEntity(fields={"urlName"})
 */
class Url
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @ORM\Column(type="string", length=255, unique=true) */
    private $urlName;

    /** @ORM\Column(type="integer", nullable=true) */
    private $httpCode;

    /** @ORM\ManyToOne(targetEntity=UrlStatus::class) */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->urlName;
    }

    public function setUrl(string $url): self
    {
        $this->urlName = $url;

        return $this;
    }

    public function getHttpCode(): ?int
    {
        return $this->httpCode;
    }

    public function setHttpCode(?int $httpCode): self
    {
        $this->httpCode = $httpCode;

        return $this;
    }

    public function getStatus(): ?UrlStatus
    {
        return $this->status;
    }

    public function setStatus(?UrlStatus $status): self
    {
        $this->status = $status;

        return $this;
    }
}
