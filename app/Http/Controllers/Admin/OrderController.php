<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'book'])
            ->latest()
            ->paginate(10);
            
        return view('admin.orders.index', compact('orders'));
    }

    public function approve(Order $order)
    {
        $order->update([
            'approval_status' => 'approved',
            'status' => 'completed'
        ]);

        return redirect()->back()->with('success', 'Order has been approved successfully.');
    }

    public function reject(Request $request, Order $order)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255'
        ]);

        $order->update([
            'approval_status' => 'rejected',
            'status' => 'cancelled',
            'rejection_reason' => $request->rejection_reason
        ]);

        return redirect()->back()->with('success', 'Order has been rejected successfully.');
    }
} 