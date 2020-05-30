<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\DeviceModelRequest;
use Illuminate\Http\Request;

/**
 * Class ModelRequestController
 */
class ModelRequestController extends Controller
{
    public function list()
    {
        if (\Auth::user()->isAdmin()) {
            $requests = DeviceModelRequest::all()->sortByDesc('id');
        } elseif (\Auth::user()->isShop()) {
            $requests = DeviceModelRequest::where('user_id', \Auth::user()->id)->get()->sortByDesc('id');
        }

        return view('cabinet.model_requests.list', compact('requests'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'model' => ['required', 'max:255'],
                'brand' => ['required', 'max:255'],
            ]);

            $modelRequest = new DeviceModelRequest();
            $modelRequest->user_id = \Auth::user()->id;
            $modelRequest->brand = $request->get('brand');
            $modelRequest->model = $request->get('model');
            $modelRequest->save();

            return redirect()->route('cabinet.model_request.list')->with('success', "Заявка добавлена!");
        }

        return redirect()->route('cabinet.model_request.list');
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post') && $request->filled('id')) {

            $modelRequest = DeviceModelRequest::find($request->get('id'));
            $modelRequest->brand = $request->get('brand');
            $modelRequest->model = $request->get('model');
            $modelRequest->is_done = $request->get('is_done');

            $modelRequest->save();
            $modelRequest->status_color = $modelRequest->attributeStatus('color');
            $modelRequest->status_text = $modelRequest->attributeStatus('text');

            return response(['status' => 1, 'type' => 'success', 'message' => 'Информация обновлена!', 'data' => $modelRequest]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при обновлении!']);
    }

    public function delete(Request $request)
    {
        $modelRequest = DeviceModelRequest::findOrFail($request->get('id'));

        if ($modelRequest) {
            $modelRequest->delete();

            return response(['status' => 1, 'type' => 'success', 'message' => "Заявка удалена!"]);
        }

        return response(['status' => 0, 'type' => 'error', 'message' => 'Ошибка при удалении!']);
    }
}
