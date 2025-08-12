<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = collect([
            (object) [
                'id' => 1,
                'order_number' => 'ORD-001',
                'customer_name' => 'John Doe',
                'customer_email' => 'john@example.com',
                'total_amount' => 299.99,
                'status' => 'completed',
                'created_at' => now()->subDays(2)
            ],
            (object) [
                'id' => 2,
                'order_number' => 'ORD-002',
                'customer_name' => 'Jane Smith',
                'customer_email' => 'jane@example.com',
                'total_amount' => 1299.99,
                'status' => 'pending',
                'created_at' => now()->subDays(1)
            ],
            (object) [
                'id' => 3,
                'order_number' => 'ORD-003',
                'customer_name' => 'Bob Johnson',
                'customer_email' => 'bob@example.com',
                'total_amount' => 199.99,
                'status' => 'processing',
                'created_at' => now()->subHours(6)
            ]
        ]);

        return view('dashboard.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('dashboard.orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'total_amount' => 'required|numeric|min:0',
        ]);

        return redirect()->route('dashboard.orders.index')
            ->with('success', 'Order created successfully!');
    }

    public function show(string $id)
    {
        $order = (object) [
            'id' => $id,
            'order_number' => 'ORD-' . str_pad($id, 3, '0', STR_PAD_LEFT),
            'customer_name' => 'Sample Customer',
            'customer_email' => 'customer@example.com',
            'total_amount' => 299.99,
            'status' => 'completed',
            'created_at' => now()->subDays(1)
        ];

        return view('dashboard.orders.show', compact('order'));
    }

    public function edit(string $id)
    {
        $order = (object) [
            'id' => $id,
            'order_number' => 'ORD-' . str_pad($id, 3, '0', STR_PAD_LEFT),
            'customer_name' => 'Sample Customer',
            'customer_email' => 'customer@example.com',
            'total_amount' => 299.99,
            'status' => 'pending'
        ];

        return view('dashboard.orders.edit', compact('order'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'total_amount' => 'required|numeric|min:0',
        ]);

        return redirect()->route('dashboard.orders.index')
            ->with('success', 'Order updated successfully!');
    }

    public function destroy(string $id)
    {
        return redirect()->route('dashboard.orders.index')
            ->with('success', 'Order deleted successfully!');
    }
}
