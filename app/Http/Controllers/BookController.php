<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Room;
use App\Models\RoomNo;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $roomTypes = Room::all();
        return view('backend.book.index', compact('roomTypes'));
    }

    public function search(Request $request) 
    {
        $roomId = $request->rooms_id; 
        $dates = explode(' - ', $request->dates);
        
        if(count($dates) < 2) {
            return redirect()->back()->with('error', 'Select date range!');
        }

        $checkIn = date('Y-m-d', strtotime($dates[0]));
        $checkOut = date('Y-m-d', strtotime($dates[1]));

        $roomTypes = Room::all();
        $selectedRoomType = Room::find($roomId);

        // আপনার মাইগ্রেশন অনুযায়ী specific rooms বের করা
        $allRoomNumbers = RoomNo::where('rooms_id', $roomId)->get();

        // তারিখ অনুযায়ী booked রুমের আইডি বের করা
        $bookedRoomIds = Book::where(function($query) use ($checkIn, $checkOut) {
            $query->whereBetween('check_in', [$checkIn, $checkOut])
                  ->orWhereBetween('check_out', [$checkIn, $checkOut]);
        })->pluck('room_nos_id')->toArray();

        return view('backend.book.index', compact('allRoomNumbers', 'bookedRoomIds', 'checkIn', 'checkOut', 'roomTypes', 'selectedRoomType'));
    }

    public function store(Request $request)
    {
        // আপনার মাইগ্রেশনের সব কলাম এখানে সেভ হবে
        Book::create([
            'rooms_id' => $request->rooms_id,
            'room_nos_id' => $request->room_nos_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'guest_name' => $request->guest_name,
            'guest_email' => $request->guest_email,
            'status' => 'booked',
        ]);

        return redirect()->route('book.index')->with('success', 'Room booked successfully!');
    }


    public function getRoomCount($id)
{
    // ওই ক্যাটাগরির মোট কতটি রুম আছে (আপনি এখানে খালি রুমের লজিকও বসাতে পারেন)
    $count = \App\Models\RoomNo::where('rooms_id', $id)->count();
    return response()->json(['count' => $count]);
}
}
