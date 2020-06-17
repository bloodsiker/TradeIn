<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

/**
 * Class BrandController
 */
class BrandController extends Controller
{

    public function list()
    {
        $brands = Brand::all()->sortByDesc('id');

        return view('cabinet.brands.list', compact('brands'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => ['required', 'min:3', 'max:255']
            ]);

            $brand = new Brand();
            $brand->name = $request->get('name');
            $brand->save();

            return redirect()->route('cabinet.brand.list')->with('success', 'Бренд добавлен!');
        }

        return redirect()->route('cabinet.brand.list');
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post') && $request->filled('id')) {

            $brand = Brand::find($request->get('id'));
            $brand->name = $request->get('name');

            $brand->save();

            return redirect()->route('cabinet.brand.list')->with('success', 'Информация обновлена');
        }

        return redirect()->route('cabinet.brand.list')->with('danger', 'Ошибка при обновлении!');
    }

    public function delete(Request $request)
    {
        $brand = Brand::findOrFail($request->get('id'));

        if ($brand) {
            $brand->delete();

            return response(['status' => 1, 'type' => 'success', 'message' => "Производитель {$brand->name} удален!"]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при удалении!']);
    }
}
