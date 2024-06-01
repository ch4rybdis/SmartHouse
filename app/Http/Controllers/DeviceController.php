<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        return response()->json($devices);
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_name' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $device = new Device();
        $device->device_name = $request->device_name;
        $device->status = $request->status;
        $device->save();

        return response()->json(['message' => 'Device created successfully'], 201);
    }

    public function show($id)
    {
        $device = Device::find($id);
        return response()->json($device);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // 'device_name' => 'string',
            'status' => 'boolean',
        ]);

        $device = Device::find($id);

        if($request->has('status')) $device->status = $request->status;
        $device->save();

        return response()->json(['message' => 'Device updated successfully']);
    }

    public function destroy($id)
    {
        $device = Device::find($id);
        $device->delete();

        return response()->json(['message' => 'Device deleted successfully']);
    }
}
