<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }
    public function show(Order $order)
    {
        $order->load('user', 'items.product');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Order $order)
    {
        $statusFlow = [
            'pending' => 'preparing',
            'preparing' => 'completed',
        ];

        $currentStatus = $order->status ?? 'pending';
        $nextStatus = $statusFlow[$currentStatus] ?? null;

        if ($nextStatus && $nextStatus !== $currentStatus) {
            $order->update(['status' => $nextStatus]);

            return redirect()->back()->with('success', 'Order status updated to ' . ucfirst($nextStatus));
        }

        return redirect()->back()->with('info', 'Order is already ' . ucfirst($currentStatus) . '.');
    }
}
