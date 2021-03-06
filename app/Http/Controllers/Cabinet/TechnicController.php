<?php

namespace App\Http\Controllers\Cabinet;

use App\Facades\UserLog;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Technic;
use Illuminate\Http\Request;

/**
 * Class TechnicController
 */
class TechnicController extends Controller
{

    public function list()
    {
        $technics = Technic::all()->sortByDesc('id');

        return view('cabinet.technic.list', compact('technics'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => ['required', 'min:2', 'max:255']
            ]);

            $technic = new Technic();
            $technic->name = $request->get('name');
            $technic->save();

            UserLog::log("Добавил новый тип техники '{$technic->name}'");

            return redirect()->route('cabinet.technic.list')->with('success', 'Новый тип техники добавлено!');
        }

        return redirect()->route('cabinet.technic.list');
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post') && $request->filled('id')) {

            $technic = Technic::find($request->get('id'));
            $technic->name = $request->get('name');

            $technic->save();

            UserLog::log("Изменил название Типа техники с '{$technic->getOriginal('name')}' на '{$technic->name}'");

            return redirect()->route('cabinet.technic.list')->with('success', 'Информация обновлена');
        }

        return redirect()->route('cabinet.technic.list')->with('danger', 'Ошибка при обновлении!');
    }

    public function delete(Request $request)
    {
        $technic = Technic::findOrFail($request->get('id'));

        if ($technic) {
            $technic->delete();
            UserLog::log("Удалил тип техники '{$technic->name}'");

            return response(['status' => 1, 'type' => 'success', 'message' => "Тип техники '{$technic->name}' удален!"]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при удалении!']);
    }
}
