<?php

declare(strict_types=1);

namespace App\Service;

use App\Command\UrlStatusCommand;
use App\Util\Console\ConsoleOutputTable;
use App\Util\Console\ErrorConsoleOutputTable;
use App\Util\Manager\UrlManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UrlStatusCommandFacade
{
    private const ACCEPTED = 'yes';

    /** @var UrlValidationService */
    private $urlValidationService;

    /** @var InputInterface */
    private $input;

    /** @var OutputInterface */
    private $output;

    /** @var UrlManager */
    private $urlManager;

    public function __construct(UrlValidationService $urlValidationService, UrlManager $urlManager)
    {
        $this->urlValidationService = $urlValidationService;
        $this->urlManager = $urlManager;
    }

    public function process(): bool
    {
        $values = $this->getArguments();
        $isCreated = $this->urlManager->create($values[UrlStatusCommand::URL_TO_CHECK]);

        if (!$isCreated) {
            $this->renderFailedTable($this->urlManager->getErrors());

            return false;
        }

        return true;
    }

    public function validate(): bool
    {
        $this->urlValidationService->validate($this->getArguments());

        return !empty($this->urlValidationService->getErrorMessages());
    }

    public function setInput(InputInterface $input): void
    {
        $this->input = $input;
    }

    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    private function getArguments(): array
    {
        $arguments = $this->input->getArguments([UrlStatusCommand::URL_TO_CHECK]);
        unset($arguments['command']);

        return $arguments;
    }

    public function renderOutputTable(): void
    {
        $values = $this->getArguments();

        $consoleOutputTable = new ConsoleOutputTable($this->output);
        $consoleOutputTable->setHeaders([]);
        $consoleOutputTable->setTableData(
            $values[UrlStatusCommand::URL_TO_CHECK],
            self::ACCEPTED
        );

        $consoleOutputTable->render();
    }

    public function renderFailedTable($errors = []): void
    {
        $this->addLineBreak();
        $errorMessages = empty($errors) ? $this->urlValidationService->getErrorMessages() : $errors;
        $consoleOutputTable = new ErrorConsoleOutputTable($this->output);
        $consoleOutputTable->setHeaders([]);
        $consoleOutputTable->setTableData(
            $errorMessages
        );

        $consoleOutputTable->render();
    }

    public function addLineBreak(): void
    {
        $this->output->writeln([
            '',
            '',
            '',
        ]);
    }
}
