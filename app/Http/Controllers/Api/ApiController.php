<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\DeviceModel;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiController
 */
class ApiController extends Controller
{

    public function brand(Request $request)
    {
        $data = DeviceModel::select('brands.id', 'brands.name')
            ->where('network_id', $request->get('network_id'))
            ->join('brands', 'brands.id', '=', 'device_models.brand_id')
            ->groupBy('brands.id')->get();

        if (!$data->count()) {
            $data = DeviceModel::select('brands.id', 'brands.name')
                ->where('network_id', null)
                ->join('brands', 'brands.id', '=', 'device_models.brand_id')
                ->groupBy('brands.id')->get();
        }

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function model(Request $request)
    {
        if ($request->get('brand_id')) {
            $brand = Brand::find($request->get('brand_id'));
            if ($brand) {
                $data = DeviceModel::where(['brand_id' => $brand->id, 'network_id' => $request->get('network_id')])
                    ->select(['id', 'brand_id', 'name', 'price', 'price_1', 'price_2', 'price_3', 'price_4', 'price_5'])
                    ->get();

                if (!$data->count()) {
                    $data = DeviceModel::where(['brand_id' => $brand->id, 'network_id' => null])
                        ->select(['id', 'brand_id', 'name', 'price', 'price_1', 'price_2', 'price_3', 'price_4', 'price_5'])
                        ->get();
                }

                return response()->json([
                    'status' => 200,
                    'data' => $data
                ]);
            }
        }

        return response()->json(['status' => 404, 'message' => 'Brand not specified']);
    }

    public function allModels(Request $request)
    {
        return response()->json([
            'status' => 200,
            'data' => DeviceModel::with('brand')->where('network_id', $request->get('network_id'))->get()
        ]);
    }
}
