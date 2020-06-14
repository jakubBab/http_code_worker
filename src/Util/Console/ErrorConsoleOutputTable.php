<?php

declare(strict_types=1);

namespace App\Util\Console;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class ErrorConsoleOutputTable extends Table
{
    private $header = [
        'Error',
    ];

    public function __construct(OutputInterface $output)
    {
        parent::__construct($output);
    }

    public function setTableData(array $errors): void
    {
        $this->setRows([
            $errors,
        ]);
    }

    public function setHeaders(array $headers): object
    {
        $headers = !empty($headers) ? $headers : $this->header;

        return parent::setHeaders($this->header);
    }
}
