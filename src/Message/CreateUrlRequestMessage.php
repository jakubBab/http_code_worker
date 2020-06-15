<?php

declare(strict_types=1);

namespace App\Message;

class CreateUrlRequestMessage
{
    private $entity;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function getUrlEntity()
    {
        return $this->entity;
    }
}
