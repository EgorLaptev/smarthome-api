<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDeviceRequest;
use App\Http\Resources\DeviceCollection;
use App\Http\Resources\DeviceResource;
use App\Models\Device;
use App\Models\Room;
use Illuminate\Http\Request;

class DeviceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Room $room)
    {

        $this->authorize('view', $room);

        return new DeviceCollection($room->devices);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  Device $device
     * @return \Illuminate\Http\Response
     */
    public function show(Device $device)
    {

        $this->authorize('view', $device);

        return new DeviceResource($device);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Device $device
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeviceRequest $request, Device $device)
    {

        $this->authorize('update', $device);

        $validated = $request->validated();

        $device->value = $validated['value'];
        $success = $device->save();

        return $success
            ? response([
                'id' => $device['id'],
                'value' => $device['value']
            ], 200)
            : response([
                'error' => 'something went wrong'
            ], 422);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
