<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\DeviceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DeviceModelSheetImport implements ToCollection
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

        if ((int) $this->request->get('action') === 0) {
            $this->updateModels($rows);
        } elseif ((int) $this->request->get('action') === 1) {
            $this->createModels($rows);
        }
    }

    private function updateModels(Collection $rows)
    {
        $brandArray = [];
        $insert = [];

        foreach ($rows as $key => $row) {
            if ($row[1]) {

                $brand = array_key_exists($row[0], $brandArray);
                if ($brand) {
                    $brandSearch = $brandArray[$row[0]];
                } else {
                    $brandSearch = Brand::firstOrCreate(['name' => $row[0]]);
                    $brandArray[$row[0]] = $brandSearch;
                }

                $model = DeviceModel::where([
                    'brand_id' => $brandSearch->id,
                    'name' => $row[1],
                    'network_id' => $this->request->get('network_id')
                ])->first();

                if ($model) {
                    $model->price = (int) ($row[2] ?? 0);
                    $model->price_1 = (int) ($row[3] ?? 0);
                    $model->price_2 = (int) ($row[4] ?? 0);
                    $model->price_3 = (int) ($row[5] ?? 0);
                    $model->price_4 = (int) ($row[6] ?? 0);
                    $model->price_5 = (int) ($row[7] ?? 0);
                    $model->save();
                } else {
                    $insert[] = [
                        'brand_id' => $brandSearch->id,
                        'network_id' => $this->request->get('network_id'),
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
        }

        if (count($insert)) {
            DeviceModel::insert($insert);
        }
    }

    /**
     * @param Collection $rows
     */
    private function createModels(Collection $rows)
    {
        $brandArray = [];
        $insert = [];

        foreach ($rows as $key => $row) {
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
                    'network_id' => $this->request->get('network_id'),
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
}
