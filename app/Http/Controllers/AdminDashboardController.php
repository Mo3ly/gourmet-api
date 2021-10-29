<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Booking;
use App\Models\User;
use App\Models\MenuProduct;
use App\Http\Resources\BookingResourceCollection;
use App\Http\Resources\OrderResourceCollection;

class AdminDashboardController extends Controller
{
    public function index(){
        return [
            'TotalOrders'=> Order::count(),
            'TotalBookings'=> Booking::count(),
            'TotalUsers'=> User::count(),
            'TotalProducts'=> MenuProduct::count(),
            'LatestOrders'=> new OrderResourceCollection(Order::orderBy('id', 'DESC')->take(5)->get()),
            'LatestBookings'=> new BookingResourceCollection(Booking::orderBy('id', 'DESC')->take(5)->get()),
        ];
    }
}
