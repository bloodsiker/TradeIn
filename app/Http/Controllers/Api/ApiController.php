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

    public function brand()
    {
        return response()->json(['status' => 200, 'data' => Brand::select('id', 'name')->get()]);
    }

    public function model(Request $request, $id)
    {
        $brand = Brand::find($id);
        if ($brand) {
            return response()->json(['status' => 200, 'data' => DeviceModel::where('brand_id', $brand->id)->get()]);
        }

        return response()->json(['status' => 404, 'message' => 'Brand not found']);
    }

    public function allModels()
    {
        return response()->json(['status' => 200, 'data' => DeviceModel::with('brand')->get()]);
    }
}
