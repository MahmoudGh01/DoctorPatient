<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cabinet\CabinetIndexResource;
use App\Http\Resources\Cabinet\CabinetShowResource;
use App\Models\Cabinet;
use Illuminate\Http\Request;

class CabinetController extends Controller
{
    public function index()
    {
        $perPage = request()->get('per_page', 5);

        $doctors = Cabinet::query()
            ->select(['id', 'name', 'doctor_id', 'location'])
            ->with('doctor:id,name')
           // ->where('is_published', true)
            ->paginate($perPage);

        return CabinetIndexResource::collection($doctors);
    }

    public function show(string $id)
    {

        $doctor = Cabinet::query()
            ->select(['id', 'name', 'doctor_id', 'location'])
            ->with('doctor:id,name')
            //->where('is_published', true)
            ->find($id);

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        return new CabinetShowResource($doctor);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:40'],
            'location' => ['nullable', 'string', 'min:10', 'max:500'],
            'doctor_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        // Cabinet::create($validated + ['author_id' => 1]);
        $cabinet= Cabinet::create($validated);

        return response()->json(new CabinetShowResource($cabinet), 201);
    }


    public function update(Request $request, string $id)
    {
        $cabinet = Cabinet::find($id);

        $validated = $request->validate([
            'name' => ['required','string','min:10', 'max:40'],
            'location' => ['nullable', 'string', 'min:10', 'max:500'],

        ]);

        $cabinet->update($validated);

        // add reference to your cabinet
        return response()->json(new CabinetShowResource($cabinet), 200);
    }

    public function destroy(string $id)
    {
        $cabinet = Cabinet::find($id);

        if (!$cabinet) {
            return response()->json(['message' => 'Cabinet not found'], 404);
        }

        $cabinet->delete();

        return response()->json(['message' => 'Cabinet deleted successfully'], 200);
    }



}
