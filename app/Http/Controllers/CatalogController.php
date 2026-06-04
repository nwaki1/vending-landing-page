<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category');

        $products = Product::when($category, fn ($q) => $q->where('category', $category))
            ->orderByDesc('is_featured')
            ->orderBy('name')
            ->get();

        $categories = Product::select('category')
            ->distinct()
            ->pluck('category')
            ->map(fn ($c) => [
                'value' => $c,
                'label' => (new Product(['category' => $c]))->category_label,
            ]);

        return view('catalog.index', compact('products', 'categories', 'category'));
    }

    public function show(Product $product)
    {
        $related = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(3)
            ->get();

        return view('catalog.show', compact('product', 'related'));
    }
}
