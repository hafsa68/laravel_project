<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Room::get();
        return view('backend.room.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('backend.room.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            'name' => 'required|string|max:100|min:3',
        'fare' => 'required|numeric|min:0', 
        'adults' => 'required|integer|min:1|max:10', 
        'children' => 'required|integer|min:0|max:10', 
        'is_featured' => 'required|in:Featured,Unfeatured',
        'room_type' => 'required|in:Room,Suite',
        'status' => 'required|in:Enabled,Disabled',
            
        ]);

        Room::create($validated);
        return redirect()->route('room.index')->with('success','New Room Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('backend.room.edit',compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
         $validated = $request->validate([
            'name' => 'required|string|max:100|min:3',
            'fare' => 'required|numeric|min:0',
            'adults' => 'required|integer|min:1|max:10',
            'children' => 'required|integer|min:0|max:10',
            'is_featured' => 'required|in:Featured,Unfeatured',
            'room_type' => 'required|in:Room,Suite',
            'status' => 'required|in:Enabled,Disabled',
        ]);

        $room->update($validated);
        return redirect()->route('room.index')->with('success', 'Room Updated Successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        
         $room->delete();
        return redirect()->route('room.index')->with('success', 'Room Deleted Successfully');
    }

     public function statusToggle(Request $request)
    {
        $amenity = Room::findOrFail($request->id);

        $amenity->status = $amenity->status == 'Enabled' ? 'Disabled' : 'Enabled';
        $amenity->save();

        return response()->json([
            'status' => $amenity->status
        ]);
    }
}
