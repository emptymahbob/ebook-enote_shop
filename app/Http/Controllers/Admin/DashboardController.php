<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('approval_status', 'pending')->count(),
        ];

        $recent_orders = Order::with(['user', 'book'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders'));
    }
} 