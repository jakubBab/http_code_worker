<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\UrlStatusCommandFacade;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UrlStatusCommand extends Command
{
    protected static $defaultName = 'app:add-url';

    public const URL_TO_CHECK = 'url_check';

    /** @var UrlStatusCommandFacade */
    private $commandFacade;

    public function __construct(UrlStatusCommandFacade $commandFacade, string $name = null)
    {
        $this->commandFacade = $commandFacade;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addArgument(self::URL_TO_CHECK, InputArgument::OPTIONAL, 'Url to check response code', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->commandFacade->setInput($input);
        $this->commandFacade->setOutput($output);

        $validationFailed = $this->commandFacade->validate();

        if ($validationFailed) {
            $this->commandFacade->renderFailedTable();
            $this->commandFacade->addLineBreak();

            return 1;
        }

        if (!$this->commandFacade->process()) {
            return 0;
        }

        $this->commandFacade->addUrlToQueue();
        $this->commandFacade->renderOutputTable();

        return 1;
    }
}
