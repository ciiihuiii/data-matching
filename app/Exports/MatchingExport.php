<?php

namespace App\Exports;

use App\Exports\Sheets\SummarySheet;
use App\Exports\Sheets\SameSheet;
use App\Exports\Sheets\DifferentSheet;
use App\Exports\Sheets\NotFoundSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MatchingExport implements WithMultipleSheets
{
    protected array $result;

    public function __construct(array $result)
    {
        $this->result = $result;
    }

    public function sheets(): array
    {
        return [
            new SummarySheet($this->result),
            new SameSheet($this->result),
            new DifferentSheet($this->result),
            new NotFoundSheet($this->result),
        ];
    }
}