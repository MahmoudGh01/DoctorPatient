<?php

namespace App\Http\Controllers;

use App\Models\Cabinet;
use Illuminate\Http\Request;

class CabinetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cabinets = Cabinet::with(['doctor:id,name,email','doctor.media'])->paginate(10);

        return view('cabinets.index', compact('cabinets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cabinets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:40'],
            'location' => ['nullable', 'string', 'min:10', 'max:500'],
        ]);

       // Cabinet::create($validated + ['author_id' => 1]);
        Cabinet::create($validated );


        return redirect('/cabinets');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cabinet = Cabinet::find($id);

        return view('cabinets.show', compact('cabinet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cabinet = Cabinet::find($id);

        return view('cabinets.edit', compact('cabinet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cabinet = Cabinet::find($id);


        $validated = $request->validate([
            'name' => ['required', 'string', 'min:10', 'max:40'],
            'location' => ['nullable', 'string', 'min:10', 'max:500'],

        ]);




        $cabinet->update($validated);

        // add reference to your cabinet
        return redirect('/cabinets');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cabinet = Cabinet::find($id);


        $cabinet->delete();

        return redirect('cabinets');
    }
}
