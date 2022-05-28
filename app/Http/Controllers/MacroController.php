<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMacroRequest;
use App\Http\Resources\MacroCollection;
use App\Http\Resources\MacroResource;
use App\Models\Action;
use App\Models\Device;
use App\Models\Macro;
use App\Models\User;
use App\Providers\MacroActivated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
    public function store(/*StoreMacroRequest*/ Request $request)
    {


//        $validated = $request->validated();

        $macro = Macro::create([
            'name' => $request->post('name') ?? 'macro #' . rand(0, 99999),
            'user_id' => Auth::id()
        ]);

        foreach ($request->post('devices') ?? [] as $action) {
            Action::create([
                'macro_id' => $macro['id'],
                'device_id' => $action['id'],
                'value' => $action['value']
            ]);
        }

        return response($macro, 201);

    }

    public function activate(Macro $macro)
    {

        $this->authorize('view', $macro);

        $success = false;

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

        $this->authorize('delete', $macro);

        $deleted = $macro->delete();

        return response([
            'success' => $deleted
        ], 200);

    }
}
