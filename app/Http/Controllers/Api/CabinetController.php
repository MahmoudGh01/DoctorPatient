<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cabinet\CabinetIndexResource;
use App\Http\Resources\Cabinet\CabinetShowResource;
use App\Models\Cabinet;

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

}
