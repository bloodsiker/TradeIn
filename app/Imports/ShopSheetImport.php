<?php

namespace App\Imports;

use App\Models\Network;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ShopSheetImport implements ToCollection
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
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        set_time_limit(0);

        $this->createShops($rows);

    }

    /**
     * @param Collection $rows
     */
    private function createShops(Collection $rows)
    {
        $networkArray = [];
        $insert = [];

        foreach ($rows as $key => $row) {
            if ($row[1]) {

                $brand = array_key_exists($row[0], $networkArray);
                if ($brand) {
                    $networkSearch = $networkArray[$row[0]];
                } else {
                    $networkSearch = Network::where('name', [$row[0]])->first();
                    $networkArray[$row[0]] = $networkSearch;
                }

                $insert[] = [
                    'network_id' => $networkSearch->id,
                    'name' => $row[1],
                    'city' => $row[2],
                    'address' => $row[3],
                ];
            }
        }

        Shop::insert($insert);
    }
}
