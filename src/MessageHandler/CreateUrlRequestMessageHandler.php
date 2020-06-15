<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\CreateUrlRequestMessage;
use App\Repository\UrlRepository;
use App\Util\Manager\RequestUrlManager;
use App\Util\Manager\UrlManager;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateUrlRequestMessageHandler implements MessageHandlerInterface
{
    /** @var RequestUrlManager */
    private $requestUrlManager;

    /** @var UrlManager */
    private $urlManager;

    /** @var UrlRepository */
    private $urlRepository;

    public function __construct(RequestUrlManager $requestUrlManager, UrlManager $urlManager, UrlRepository $urlRepository)
    {
        $this->requestUrlManager = $requestUrlManager;
        $this->urlManager = $urlManager;
        $this->urlRepository = $urlRepository;
    }

    public function __invoke(CreateUrlRequestMessage $bookingMessage)
    {
        $urlEntity = $bookingMessage->getUrlEntity();
        $urlEntity = $this->urlRepository->find($urlEntity->getId());
        $this->urlManager->markUrlAsProcessed($urlEntity);

        $this->requestUrlManager->makeRequest($urlEntity->getUrl());
        $httpCode = $this->requestUrlManager->getHttpCode();

        if (null === $httpCode) {
            $this->urlManager->markUrlAsError($urlEntity);
        } else {
            $urlEntity->setHttpCode($httpCode);
            $this->urlManager->markUrlAsDone($urlEntity);
        }

        $this->urlRepository->save($urlEntity);
    }
}
