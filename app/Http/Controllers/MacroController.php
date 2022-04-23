<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMacroRequest;
use App\Http\Resources\MacroCollection;
use App\Http\Resources\MacroResource;
use App\Models\Action;
use App\Models\Device;
use App\Models\Macro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MacroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new MacroCollection(
            Auth::user()->macros
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMacroRequest $request)
    {

        $validated = $request->validated();

        $macro = Macro::create([
            'name' => $validated['name'],
            'user_id' => Auth::id()
        ]);

        foreach ($validated['devices'] as $action) {
            Action::create([
                'macro_id' => $macro['id'],
                'device_id' => $action['id'],
                'value' => $action['value']
            ]);
        }

        return response([
            'id' => $macro['id']
        ], 201);

    }

    public function activate(Macro $macro)
    {

        $success =  false;

        $actions = $macro->actions;

        foreach ($actions as $action) {
            $device = Device::find($action['device_id']);
            $device->value = $action['value'];
            $success = $device->save();
        }

        return response([
            'success' => $success
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Macro $macro)
    {

        $deleted = $macro->delete();

        return response([
            'success' => $deleted
        ], 200);

    }
}
