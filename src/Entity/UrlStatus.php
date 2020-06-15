<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UrlStatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UrlStatusRepository::class)
 */
class UrlStatus
{
    public const PROCESSING = 'processing';

    public const ERROR = 'error';

    public const DONE = 'done';

    public const NEW = 'new';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @ORM\Column(type="string", length=20) */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
