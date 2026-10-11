<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class NotFoundSheet implements FromView, WithTitle
{
    protected array $result;

    public function __construct(array $result)
    {
        $this->result = $result;
    }

    public function view(): View
    {
        return view('exports.not-found', [
            'result' => $this->result,
        ]);
    }

    public function title(): string
    {
        return 'Tidak Ditemukan';
    }
}