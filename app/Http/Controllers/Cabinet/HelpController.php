<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Help;
use App\Models\Network;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class HelpController
 */
class HelpController extends Controller
{

    public function list()
    {
        if (\Auth::user()->isAdmin()) {
            $helps = Help::orderBy('id', 'DESC')->get();
        } else {
            $helps = Help::where('is_active', true)->orderBy('id', 'DESC')->get();
        }

        return view('cabinet.help.list', compact('helps'));
    }

    public function view(Request $request, $id)
    {
        $help = Help::find($id);

        return view('cabinet.help.view', compact('help'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'title'       => ['required', 'min:3', 'max:255'],
            ]);

            $help = new Help();
            $help->title = $request->get('title');
            $help->short_description = $request->get('short_description');
//            $help->description = $request->get('description');
            $help->is_active = $request->get('is_active');

            if ($request->hasFile('image')) {
                $path = '/image/help/';
                $image = $request->file('image');
                $name = sha1(time().random_bytes(5)) . '.' . trim($image->getClientOriginalExtension());
                $fullPatch = $path . $name;

                $image->storeAs($path, $name, 'publicImage');

                $help->image = $fullPatch;
            }

            $help->save();

            return redirect()->route('cabinet.help.list')->with('success', 'Cтатья добавлена!');
        }

        return view('cabinet.help.add');
    }

    public function edit(Request $request, $id)
    {
        $help = Help::find($id);

        if ($request->isMethod('post')) {

            $request->validate([
                'title'       => ['required', 'min:3', 'max:255'],
            ]);

            $help->title = $request->get('title');
            $help->short_description = $request->get('short_description');
//            $help->description = $request->get('description');
            $help->is_active = $request->get('is_active');

            if ($request->hasFile('image')) {
                $path = '/image/help/';
                $image = $request->file('image');
                $name = sha1(time().random_bytes(5)) . '.' . trim($image->getClientOriginalExtension());
                $fullPatch = $path . $name;

                $image->storeAs($path, $name, 'publicImage');

                $help->image = $fullPatch;
            }

            $help->save();

            return redirect()->route('cabinet.help.list')->with('success', 'Информация обновлена');
        }

        return view('cabinet.help.edit', compact('help'));
    }

    public function delete(Request $request, $id)
    {
        $help = Help::find($id);

        if ($help) {
            $help->delete();

            return redirect()->route('cabinet.help.list')->with('success', 'Статья удалена');
        }

        return redirect()->route('cabinet.help.list')->with('danger', 'Ошибка при удалении!');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $filenamewithextension = $request->file('upload')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();

            $filenametostore = $filename.'_'.time().'.'.$extension;

            $path = '/image/help/';

            $request->file('upload')->storeAs($path, $filenametostore, 'publicImage');

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset($path.$filenametostore);
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }

        return true;
    }
}
