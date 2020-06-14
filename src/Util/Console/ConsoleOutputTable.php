<?php

declare(strict_types=1);

namespace App\Util\Console;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleOutputTable extends Table
{
    public function __construct(OutputInterface $output)
    {
        parent::__construct($output);
    }

    private $header = [
        'url_name', 'saved',
    ];

    public function setTableData(string $urlName, string $accepted = 'yes'): void
    {
        $this->setRows([
            [$urlName, $accepted],
        ]);
    }

    public function setHeaders(array $headers): object
    {
        $headers = !empty($headers) ? $headers : $this->header;

        return parent::setHeaders($this->header);
    }
}
