<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\DeviceModel;
use App\Models\Network;
use Illuminate\Http\Request;

/**
 * Class ModelController
 */
class ModelController extends Controller
{

    public function list(Request $request)
    {
        $brands = Brand::all()->sortByDesc('id');
        $networks = Network::all();

        $network = null;
        if ($request->has('network_id')) {
            $network = Network::find($request->get('network_id'));
            $models = DeviceModel::where('network_id', $network->id)->get()->sortByDesc('id');
        } else {
            $models = DeviceModel::all()->sortByDesc('id');
        }

        return view('cabinet.models.list', compact('models', 'brands', 'networks', 'network'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'name' => ['required', 'min:2', 'max:255']
            ]);

            $model = new DeviceModel();
            $model->name = $request->get('name');
            $model->network_id = $request->get('network_id');
            $model->brand_id = $request->get('brand_id');
            $model->price = $request->get('price') ?: 0;
            $model->price_1 = $request->get('price_1') ?: 0;
            $model->price_2 = $request->get('price_2') ?: 0;
            $model->price_3 = $request->get('price_3') ?: 0;
            $model->price_4 = $request->get('price_4') ?: 0;
            $model->price_5 = $request->get('price_5') ?: 0;
            $model->save();

            return redirect()->back()->with('success', "Модель {$model->name} добавлен!");
        }

        return redirect()->back()->with('danger', 'Ошибка, модель не удалось добавить!');
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post') && $request->filled('id')) {

            $model = DeviceModel::find($request->get('id'));
            $model->name = $request->get('name');
            $model->brand_id = $request->get('brand_id');
            $model->price = $request->get('price') ?: 0;
            $model->price_1 = $request->get('price_1') ?: 0;
            $model->price_2 = $request->get('price_2') ?: 0;
            $model->price_3 = $request->get('price_3') ?: 0;
            $model->price_4 = $request->get('price_4') ?: 0;
            $model->price_5 = $request->get('price_5') ?: 0;

            $model->save();
            $model->load('brand');

            return response(['status' => 1, 'type' => 'success', 'message' => 'Информация обновлена!', 'data' => $model]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при обновлении!']);
    }

    public function delete(Request $request)
    {
        $model = DeviceModel::findOrFail($request->get('id'));

        if ($model) {
            $model->delete();

            return response(['status' => 1, 'type' => 'success', 'message' => "Модель {$model->name} удалена!"]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при удалении!']);
    }
}
