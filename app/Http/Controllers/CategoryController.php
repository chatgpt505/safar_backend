<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = collect([
            (object) [
                'id' => 1,
                'name' => 'Electronics',
                'description' => 'Electronic devices and gadgets',
                'product_count' => 15,
                'status' => 'active',
                'created_at' => now()->subDays(30)
            ],
            (object) [
                'id' => 2,
                'name' => 'Wearables',
                'description' => 'Smart watches and fitness trackers',
                'product_count' => 8,
                'status' => 'active',
                'created_at' => now()->subDays(25)
            ],
            (object) [
                'id' => 3,
                'name' => 'Home & Kitchen',
                'description' => 'Home appliances and kitchen tools',
                'product_count' => 12,
                'status' => 'active',
                'created_at' => now()->subDays(20)
            ]
        ]);

        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function show(string $id)
    {
        $category = (object) [
            'id' => $id,
            'name' => 'Sample Category',
            'description' => 'This is a sample category description.',
            'product_count' => 5,
            'status' => 'active',
            'created_at' => now()->subDays(10)
        ];

        return view('dashboard.categories.show', compact('category'));
    }

    public function edit(string $id)
    {
        $category = (object) [
            'id' => $id,
            'name' => 'Sample Category',
            'description' => 'This is a sample category description.',
            'status' => 'active'
        ];

        return view('dashboard.categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(string $id)
    {
        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
