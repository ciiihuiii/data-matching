<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class DifferentSheet implements FromView, WithTitle
{
    protected array $result;

    public function __construct(array $result)
    {
        $this->result = $result;
    }

    public function view(): View
    {
        return view('exports.different', [
            'result' => $this->result,
        ]);
    }

    public function title(): string
    {
        return 'Data Berbeda';
    }
}