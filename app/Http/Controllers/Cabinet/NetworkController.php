<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class NetworkController
 */
class NetworkController extends Controller
{

    public function list()
    {
        $networks = Network::all()->sortByDesc('id');

        return view('cabinet.networks.list', compact('networks'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => ['required', 'min:3', 'max:255']
            ]);

            $network = new Network();
            $network->name = $request->get('name');

            $network->save();

            return redirect()->route('cabinet.network.list')->with('success', 'Торговая сеть добавлена!');
        }

        return redirect()->route('cabinet.network.list');
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post') && $request->filled('id')) {

            $network = Network::find($request->get('id'));
            $network->name = $request->get('name');

            $network->save();

            return response(['status' => 1, 'type' => 'success', 'message' => 'Информация обновлена!', 'data' => $network]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при обновлении!']);
    }

    public function delete(Request $request)
    {
        $network = Network::findOrFail($request->get('id'));

        if ($network) {
            $network->delete();

            return response(['status' => 1, 'type' => 'success', 'message' => "Торговая сеть {$network->name} удалена!"]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при удалении!']);
    }

    public function users(Request $request, $id)
    {
        $network = Network::findOrFail($id);
        $users = User::where('network_id', $network->id)->orderBy('id', 'desc')->get();

        return view('cabinet.networks.users', compact('network', 'users'));
    }

    public function getAjaxData(Request $request)
    {
        $data = Network::find($request->get('id'));

        return response(['status' => 1, 'data' => $data]);
    }
}
