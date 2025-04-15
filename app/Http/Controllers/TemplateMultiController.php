<?php

namespace App\Http\Controllers;

use KDatabase;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TemplateMultiController implements WithMultipleSheets
{

    private $sheets;

    use Exportable;

    public function __construct(array $sheets)
    {
        $this->sheets = $sheets;
    }

    public function sheets(): array
    {
        return $this->sheets;
    }
}
