<?php

namespace App\Imports;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DeviceModelImport implements WithMultipleSheets, WithChunkReading
{
    private $request;

    /**
     * DeviceModelImport constructor.
     *
     * @param $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return DeviceModelSheetImport[]|array
     */
    public function sheets(): array
    {
        return [
            new DeviceModelSheetImport($this->request),
        ];
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
