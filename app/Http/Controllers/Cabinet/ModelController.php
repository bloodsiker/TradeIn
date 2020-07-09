<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Imports\DeviceModelImport;
use App\Models\Brand;
use App\Models\DeviceModel;
use App\Models\Network;
use App\Models\Technic;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class ModelController
 */
class ModelController extends Controller
{
    public function list(Request $request)
    {
        $brands = Brand::orderBy('name')->get();
        $networks = Network::all();

        $technics = Technic::all();

        $network = $brand = null;
        $query = DeviceModel::select('device_models.*')
            ->where('device_models.is_deleted', false)->with('brand');

        if ($request->get('network_id')) {
            $network = Network::find($request->get('network_id'));
            $query->where('network_id', $request->get('network_id'));
        } else {
            $query->where('network_id', null);
        }

        if ($request->get('brand_id')) {
            $brand = Brand::find($request->get('brand_id'));
            $query->where('brand_id', $request->get('brand_id'));
        }

        if ($request->get('model')) {
            $query->where('name', 'LIKE', "%{$request->get('model')}%");
        }

        $models = $query->get();

        return view('cabinet.models.list', compact('models', 'brands', 'networks', 'network', 'brand', 'technics'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {

            $model = new DeviceModel();
            $model->name = $request->get('name');
            $model->technic_id = $request->get('technic_id');
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
            $model->technic_id = $request->get('technic_id');
            $model->brand_id = $request->get('brand_id');
            $model->price = $request->get('price') ?: 0;
            $model->price_1 = $request->get('price_1') ?: 0;
            $model->price_2 = $request->get('price_2') ?: 0;
            $model->price_3 = $request->get('price_3') ?: 0;
            $model->price_4 = $request->get('price_4') ?: 0;
            $model->price_5 = $request->get('price_5') ?: 0;

            $model->save();
            $model->load('brand', 'technic');

            return response(['status' => 1, 'type' => 'success', 'message' => 'Информация обновлена!', 'data' => $model]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при обновлении!']);
    }

    public function delete(Request $request)
    {
        $model = DeviceModel::findOrFail($request->get('id'));

        if ($model) {
            $model->is_deleted = true;
            $model->save();

            return response(['status' => 1, 'type' => 'success', 'message' => "Модель {$model->name} удалена!"]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при удалении!']);
    }

    public function import(Request $request)
    {
        if ($request->hasFile('file')) {

            $action = (int) $request->get('action');
            Excel::import(new DeviceModelImport($request), $request->file('file'));

            if ($request->has('action') && $action === 0) {

                return redirect()->back()->with('success', "Импорт прошел успешно, данные обновлены!");
            } elseif ($request->has('action') && $action === 1) {

                return redirect()->back()->with('success', "Импорт прошел успешно, новые данные внесены в базу");
            }

            return redirect()->back()->with('danger', "Не выбрано действия для импорта");
        }

        return redirect()->back()->with('danger', 'Ошибка при импорте!');
    }
}
