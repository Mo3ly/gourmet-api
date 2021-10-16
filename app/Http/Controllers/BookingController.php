<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BookingResource;
use App\Http\Resources\BookingResourceCollection;
use App\Models\Booking;
use App\Events\BookingReceived;

class BookingController extends Controller
{
    public function index(){
        return new BookingResourceCollection(Booking::orderBy('id', 'DESC')->get());
    }    

    public function paginate(){
        $bookings = Booking::orderBy('id', 'DESC')->paginate(10);

        $response = [
            'pagination' => [
                'total' => $bookings->total(),
                'has_more_pages' => $bookings->hasMorePages(),
                'per_page' => $bookings->perPage(),
                'current_page' => $bookings->currentPage(),
                'last_page' => $bookings->lastPage(),
                'from' => $bookings->firstItem(),
                'to' => $bookings->lastItem(),
            ],
            'bookings' => new BookingResourceCollection($bookings)
        ];

        return $response;
    }

    public function store (Request $request){
        // Notes: 

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' =>  ['required', 'regex:/^((33)|(44)|(55)|(66)|(77)|(31))[0-9]{6}/', 'digits:8'],
            'dateTime' => 'required|date|after:today',
        ]);

        $booking = Booking::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' =>  $request->phone,
            'date' =>  $request->dateTime,
            'notes' =>  $request->notes,
        ]);

        if($booking){
            $bookingResource = new BookingResource($booking);

            event(new BookingReceived($booking));

            return response()->json(['success'=>'Your booking request has been recieved we will contact you as soon as possible to confirm.']);
        }
    }
}
