<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\DeviceModel;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DeviceModelSheetImport implements ToCollection, WithChunkReading, ShouldQueue
{

    public function collection(Collection $rows)
    {
        set_time_limit(0);

        $brandArray = [];
        $insert = [];

        foreach ($rows as $key => $row)
        {
            if ($row[1]) {

                $brand = array_key_exists($row[0], $brandArray);
                if ($brand) {
                    $brandSearch = $brandArray[$row[0]];
                } else {
                    $brandSearch = Brand::firstOrCreate(['name' => $row[0]]);
                    $brandArray[$row[0]] = $brandSearch;
                }

                $insert[] = [
                    'brand_id' => $brandSearch->id,
                    'name' => $row[1],
                    'price' => (int) ($row[2] ?? 0),
                    'price_1' => (int) ($row[3] ?? 0),
                    'price_2' => (int) ($row[4] ?? 0),
                    'price_3' => (int) ($row[5] ?? 0),
                    'price_4' => (int) ($row[6] ?? 0) ,
                    'price_5' => (int) ($row[7] ?? 0),
                ];
            }
        }

        DeviceModel::insert($insert);
    }

    public function chunkSize(): int
    {
        return 300;
    }
}
