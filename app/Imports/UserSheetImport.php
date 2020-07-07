<?php

namespace App\Imports;

use App\Models\Network;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserSheetImport implements ToCollection
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

        $this->createUsers($rows);

    }

    /**
     * @param Collection $rows
     */
    private function createUsers(Collection $rows)
    {
        $networkArray = [];
        $roleArray = [
            1 => 'Администратор сайта',
            2 => 'Руководитель торговой сети',
            3 => 'Сотрудник магазина',
        ];
        $insert = [];

        foreach ($rows as $key => $row) {
            if ($row[0]) {

                $network = array_key_exists($row[1], $networkArray);
                if ($network) {
                    $networkSearch = $networkArray[$row[1]];
                } else {
                    $networkSearch = Network::where('name', [$row[1]])->first();
                    $networkArray[$row[0]] = $networkSearch;
                }

                if ($networkSearch) {
                    $shop = Shop::where(['network_id' => $networkSearch->id, 'name' => $row[2]])->first();

                    $insert[] = [
                        'role_id' => array_search($row[0], $roleArray),
                        'network_id' => $networkSearch ? $networkSearch->id : null,
                        'shop_id' => $shop ? $shop->id : null,
                        'name' => $row[3],
                        'surname' => $row[4],
                        'email' => $row[5],
                        'password' => Hash::make($row[6]),
                        'phone' => $row[7],
                    ];
                }
            }
        }

        try {
            User::insert($insert);
            return back()->with('success', "Импорт прошел успешно, данные добавлены!")->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('danger', $e->getMessage())->withInput();
        }
    }
}
