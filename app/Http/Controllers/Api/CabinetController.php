<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cabinet\StoreCabinetRequest;
use App\Http\Requests\Cabinet\UpdateCabinetRequest;
use App\Http\Resources\Cabinet\CabinetIndexResource;
use App\Http\Resources\Cabinet\CabinetShowResource;
use App\Models\Cabinet;
use Illuminate\Http\Request;

class CabinetController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $query = Cabinet::with('doctor:id,name');

        // Search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by doctor
        if ($request->has('doctor_id')) {
            $query->where('doctor_id', $request->get('doctor_id'));
        }

        // Sorting
        $allowedSortFields = ['id', 'name', 'location', 'doctor_id', 'created_at', 'updated_at'];
        $sortBy = $request->get('sort', 'created_at');
        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'created_at';
        
        $direction = $request->get('direction', 'desc');
        $direction = in_array(strtolower($direction), ['asc', 'desc']) ? $direction : 'desc';
        
        $query->orderBy($sortBy, $direction);

        $cabinets = $query->paginate($perPage);

        return CabinetIndexResource::collection($cabinets);
    }

    public function show(string $id)
    {
        $cabinet = Cabinet::with('doctor:id,name,email')
            ->findOrFail($id);

        return new CabinetShowResource($cabinet);
    }

    public function store(StoreCabinetRequest $request)
    {
        $validated = $request->validated();
        $cabinet = Cabinet::create($validated);
        $cabinet->load('doctor');

        return new CabinetShowResource($cabinet);
    }

    public function update(UpdateCabinetRequest $request, string $id)
    {
        $cabinet = Cabinet::findOrFail($id);
        $validated = $request->validated();

        $cabinet->update($validated);
        $cabinet->load('doctor');

        return new CabinetShowResource($cabinet);
    }

    public function destroy(string $id)
    {
        $cabinet = Cabinet::findOrFail($id);
        $cabinet->delete();

        return response()->json(null, 204);
    }
}
