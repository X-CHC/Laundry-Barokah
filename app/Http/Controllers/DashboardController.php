<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Count today's orders
        $todayOrders = Pesanan::whereDate('created_at', Carbon::today())->count();
        
        // Count completed orders
        $completedOrders = Pesanan::where('status', 'selesai')->count();
        
        // Count in-progress orders
        $inProgressOrders = Pesanan::where('status', 'proses')->count();
        
        // Get latest 3 orders with customer relationship
        $latestOrders = Pesanan::with('customer', 'layanan')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('Admin.dashboard', compact(
            'todayOrders',
            'completedOrders',
            'inProgressOrders',
            'latestOrders'
        ));
    }
}