<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Sample data for demonstration
        $products = collect([
            (object) [
                'id' => 1,
                'name' => 'Laptop Pro',
                'description' => 'High-performance laptop for professionals',
                'price' => 1299.99,
                'category' => 'Electronics',
                'stock' => 25,
                'status' => 'active',
                'created_at' => now()->subDays(5)
            ],
            (object) [
                'id' => 2,
                'name' => 'Wireless Headphones',
                'description' => 'Premium noise-canceling headphones',
                'price' => 299.99,
                'category' => 'Electronics',
                'stock' => 50,
                'status' => 'active',
                'created_at' => now()->subDays(3)
            ],
            (object) [
                'id' => 3,
                'name' => 'Smart Watch',
                'description' => 'Fitness and health tracking smartwatch',
                'price' => 199.99,
                'category' => 'Wearables',
                'stock' => 15,
                'status' => 'active',
                'created_at' => now()->subDays(1)
            ],
            (object) [
                'id' => 4,
                'name' => 'Coffee Maker',
                'description' => 'Automatic coffee machine with timer',
                'price' => 89.99,
                'category' => 'Home & Kitchen',
                'stock' => 0,
                'status' => 'inactive',
                'created_at' => now()->subDays(10)
            ]
        ]);

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ['Electronics', 'Wearables', 'Home & Kitchen', 'Books', 'Sports'];
        return view('dashboard.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'stock' => 'required|integer|min:0',
        ]);

        // In a real application, you would save to database here
        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Sample product data
        $product = (object) [
            'id' => $id,
            'name' => 'Sample Product',
            'description' => 'This is a sample product description.',
            'price' => 99.99,
            'category' => 'Electronics',
            'stock' => 25,
            'status' => 'active',
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(2)
        ];

        return view('dashboard.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Sample product data
        $product = (object) [
            'id' => $id,
            'name' => 'Sample Product',
            'description' => 'This is a sample product description.',
            'price' => 99.99,
            'category' => 'Electronics',
            'stock' => 25,
            'status' => 'active'
        ];

        $categories = ['Electronics', 'Wearables', 'Home & Kitchen', 'Books', 'Sports'];
        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'stock' => 'required|integer|min:0',
        ]);

        // In a real application, you would update the database here
        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // In a real application, you would delete from database here
        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
