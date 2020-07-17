<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\DeviceModel;
use App\Models\Technic;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiController
 */
class ApiController extends Controller
{
    public function typeDevice(Request $request)
    {
        $data = Technic::orderBy('name')->get();

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function brand(Request $request)
    {

        $technicId = $request->get('type_id');

        $data = DeviceModel::select('brands.id', 'brands.name')
            ->where('network_id', $request->get('network_id'))
            ->where('device_models.is_deleted', false)
            ->where('device_models.technic_id', $technicId)
            ->join('brands', 'brands.id', '=', 'device_models.brand_id')
            ->orderBy('brands.name')
            ->groupBy('brands.id')->get();

        if (!$data->count()) {
            $data = DeviceModel::select('brands.id', 'brands.name')
                ->where('network_id', null)
                ->where('device_models.is_deleted', false)
                ->where('device_models.technic_id', $technicId)
                ->join('brands', 'brands.id', '=', 'device_models.brand_id')
                ->orderBy('brands.name')
                ->groupBy('brands.id')->get();
        }

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function model(Request $request)
    {
        $technicId = $request->get('type_id');

        if ($request->get('brand_id') && $technicId) {
            $brand = Brand::find($request->get('brand_id'));
            if ($brand) {
                $data = DeviceModel::where(['brand_id' => $brand->id, 'network_id' => $request->get('network_id')])
                    ->where('device_models.is_deleted', false)
                    ->where('device_models.technic_id', $technicId)
                    ->select(['id', 'brand_id', 'name', 'price', 'price_1', 'price_2', 'price_3', 'price_4', 'price_5'])
                    ->orderBy('device_models.name')->get();;

                if (!$data->count()) {
                    $data = DeviceModel::where(['brand_id' => $brand->id, 'network_id' => null])
                        ->where('device_models.is_deleted', false)
                        ->where('device_models.technic_id', $technicId)
                        ->select(['id', 'brand_id', 'name', 'price', 'price_1', 'price_2', 'price_3', 'price_4', 'price_5'])
                        ->orderBy('device_models.name')->get();
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
            'data' => DeviceModel::with('brand', 'technic')
                ->where('network_id', $request->get('network_id'))
                ->where('device_models.is_deleted', false)
                ->orderBy('device_models.name')->get()
        ]);
    }
}
