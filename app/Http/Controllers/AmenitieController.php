<?php

namespace App\Http\Controllers;

use App\Models\Amenitie;
use Illuminate\Http\Request;

class AmenitieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Amenitie::get();
        return view('backend.amenitie.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.amenitie.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validated = $request->validate([
            'title' => 'required|string|max:100',
            'status' => 'required|in:Enabled,Disabled',
            'icon' => 'nullable|string|max:100',
        ]);

        Amenitie::create($validated);
        return redirect()->route('amenitie.index')->with('success','New Amenitie Added');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $amenitie = Amenitie::findOrFail($id);
        return view('backend.amenitie.edit', compact('amenitie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $amenitie = Amenitie::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'status' => 'required|in:Enabled,Disabled',
            'icon' => 'nullable|string|max:100',
        ]);

        $amenitie->update($validated);
        return redirect()->route('amenitie.index')->with('success','Amenitie Updated');
    }

    public function destroy($id)
    {
        $amenitie = Amenitie::findOrFail($id);
        $amenitie->delete();
        
        return redirect()->route('amenitie.index')->with('success', 'Amenitie deleted');
    }
}