<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DeviceModelImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new DeviceModelSheetImport(),
        ];
    }
}
