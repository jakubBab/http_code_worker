<?php

declare(strict_types=1);

namespace App\Util\Validation;

use App\Command\UrlStatusCommand;
use Symfony\Component\Validator\Constraints as Assert;

class UrlCommandValidation
{
    public function getConstraints()
    {
        return [
            new Assert\Collection([
                UrlStatusCommand::URL_TO_CHECK => [
                    new Assert\Url([
                        'protocols' => ['http', 'https'],
                    ]),
                    new Assert\NotNull(['message' => sprintf('%s value missing', UrlStatusCommand::URL_TO_CHECK)]),
                ],
            ]),
        ];
    }
}
