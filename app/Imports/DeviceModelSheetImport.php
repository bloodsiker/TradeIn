<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\DeviceModel;
use App\Models\Technic;
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
        $typeArray = [];
        $insert = [];

        foreach ($rows as $key => $row) {
            if ($row[1]) {

                $type = array_key_exists($row[0], $typeArray);
                if ($type) {
                    $typeSearch = $typeArray[$row[0]];
                } else {
                    $typeSearch = Technic::firstOrCreate(['name' => $row[0]]);
                    $typeArray[$row[0]] = $typeSearch;
                }

                $brand = array_key_exists($row[1], $brandArray);
                if ($brand) {
                    $brandSearch = $brandArray[$row[1]];
                } else {
                    $brandSearch = Brand::firstOrCreate(['name' => $row[1]]);
                    $brandArray[$row[1]] = $brandSearch;
                }

                $model = DeviceModel::where([
                    'brand_id' => $brandSearch->id,
                    'name' => $row[2],
                    'network_id' => $this->request->get('network_id')
                ])->first();

                if ($model) {
                    $model->price = (int) ($row[3] ?? 0);
                    $model->price_1 = (int) ($row[4] ?? 0);
                    $model->price_2 = (int) ($row[5] ?? 0);
                    $model->price_3 = (int) ($row[6] ?? 0);
                    $model->price_4 = (int) ($row[7] ?? 0);
                    $model->price_5 = (int) ($row[8] ?? 0);
                    $model->save();
                } else {
                    $insert[] = [
                        'technic_id' => $typeSearch->id,
                        'brand_id' => $brandSearch->id,
                        'network_id' => $this->request->get('network_id'),
                        'name' => $row[2],
                        'price' => (int) ($row[3] ?? 0),
                        'price_1' => (int) ($row[4] ?? 0),
                        'price_2' => (int) ($row[5] ?? 0),
                        'price_3' => (int) ($row[6] ?? 0),
                        'price_4' => (int) ($row[7] ?? 0) ,
                        'price_5' => (int) ($row[8] ?? 0),
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
        $typeArray = [];
        $insert = [];

        foreach ($rows as $key => $row) {
            if ($row[1]) {

                $type = array_key_exists($row[0], $typeArray);
                if ($type) {
                    $typeSearch = $typeArray[$row[0]];
                } else {
                    $typeSearch = Technic::firstOrCreate(['name' => $row[0]]);
                    $typeArray[$row[0]] = $typeSearch;
                }

                $brand = array_key_exists($row[1], $brandArray);
                if ($brand) {
                    $brandSearch = $brandArray[$row[1]];
                } else {
                    $brandSearch = Brand::firstOrCreate(['name' => $row[1]]);
                    $brandArray[$row[1]] = $brandSearch;
                }

                $insert[] = [
                    'technic_id' => $typeSearch->id,
                    'brand_id' => $brandSearch->id,
                    'network_id' => $this->request->get('network_id'),
                    'name' => $row[2],
                    'price' => (int) ($row[3] ?? 0),
                    'price_1' => (int) ($row[4] ?? 0),
                    'price_2' => (int) ($row[5] ?? 0),
                    'price_3' => (int) ($row[6] ?? 0),
                    'price_4' => (int) ($row[7] ?? 0) ,
                    'price_5' => (int) ($row[8] ?? 0),
                ];
            }
        }

        DeviceModel::insert($insert);
    }
}
