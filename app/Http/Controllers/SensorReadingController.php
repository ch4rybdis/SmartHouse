<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorReading;

class SensorReadingController extends Controller
{
    // Retrieve all sensor readings
    public function index()
    {
        $readings = SensorReading::all()->map(function ($reading) {
            return [
                'id' => $reading->id,
                'sensor_type' => $reading->sensor_type,
                'value' => $reading->value,
                'created_at' => $reading->created_at->toIso8601String(),
                'updated_at' => $reading->updated_at->toIso8601String(),
            ];
        });

        return response()->json($readings);
    }

    // Store a new sensor reading
    public function store(Request $request)
    {
        $request->validate([
            'sensor_type' => 'required|string',
            'value' => 'required|numeric',
        ]);

        $reading = new SensorReading();
        $reading->sensor_type = $request->sensor_type;
        $reading->value = $request->value;



        $reading->save();

        return response()->json(['message' => 'Sensor reading created successfully'], 201);
    }

    // Retrieve a specific sensor reading by id
    public function show($id)
{
    $reading = SensorReading::find($id);
    if (!$reading) {
        return response()->json(['message' => 'Sensor reading not found'], 404);
    }

    $formattedReading = [
        'id' => $reading->id,
        'sensor_type' => $reading->sensor_type,
        'value' => $reading->value,
        'created_at' => $reading->created_at->toIso8601String(),
        'updated_at' => $reading->updated_at->toIso8601String(),
    ];

    return response()->json($formattedReading);
}


    // Update a specific sensor reading by id
    public function update(Request $request, $id)
    {
        $request->validate([
            //'sensor_type' => 'string',
            'value' => 'numeric',
        ]);

        $reading = SensorReading::find($id);
        if (!$reading) {
            return response()->json(['message' => 'Sensor reading not found'], 404);
        }

        // if ($request->has('sensor_type')) {
        //     $reading->sensor_type = $request->sensor_type;
        // }
        if ($request->has('value')) {
            $reading->value = $request->value;
        }
        $reading->save();

        // belki burada device kontrolü eklenebilir mobil için

        // sıcaklık düstü device acılıyor
        // hava karardı isik aciliyor
        // hareket edildi alarm
        // elektrik fazla geliyor opt yapılmalı

        return response()->json(['message' => 'Sensor reading updated successfully_ch4rybdis']);
    }

    // Delete a specific sensor reading by id
    public function destroy($id)
    {
        $reading = SensorReading::find($id);
        if (!$reading) {
            return response()->json(['message' => 'Sensor reading not found'], 404);
        }

        $reading->delete();

        return response()->json(['message' => 'Sensor reading deleted successfully']);
    }
}
