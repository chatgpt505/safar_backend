@extends('layouts.app')

@section('title', 'Product Details - Safar Backend')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Product Details</h1>
        <div class="space-x-2">
            <a href="{{ route('dashboard.products.edit', $product->id) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="{{ route('dashboard.products.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                <i class="fas fa-arrow-left mr-2"></i> Back to Products
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-dark-800 rounded-lg shadow overflow-hidden">
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</h2>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $product->name }}</p>
            </div>

            <div>
                <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</h2>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $product->category }}</p>
            </div>

            <div>
                <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</h2>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</p>
            </div>

            <div>
                <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock</h2>
                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $product->stock }}</p>
            </div>

            <div>
                <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</h2>
                <p class="mt-1">
                    @if($product->status === 'active')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">Active</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">Inactive</span>
                    @endif
                </p>
            </div>

            <div class="md:col-span-2">
                <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</h2>
                <p class="mt-1 text-gray-900 dark:text-gray-300">{{ $product->description }}</p>
            </div>
        </div>
        <div class="bg-gray-50 dark:bg-dark-700 px-6 py-4">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Created: {{ $product->created_at ? $product->created_at->format('M d, Y') : '-' }}
                <span class="mx-2">•</span>
                Updated: {{ $product->updated_at ? $product->updated_at->format('M d, Y') : '-' }}
            </div>
        </div>
    </div>
</div>
@endsection


