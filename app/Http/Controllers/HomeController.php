<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all categories
        $categories = Category::all();

        // Fetch products with filters
        $query = Product::query();

        if ($request->filled('categories')) {
            $categoryIds = explode(',', $request->categories);
            $query->whereHas('categories', function($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds);
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->paginate(12);

        return view('main', compact('categories', 'products'));
    }

    public function searchCategories(Request $request)
    {
        $searchTerm = $request->input('query');
        if ($searchTerm != null) {
            $searchTerm = '%' . $searchTerm . '%';
        }
        $categories = Category::whereRaw("name LIKE ?", array($searchTerm))->orderBy('products_count', 'desc')->get();

        return response()->json($categories);
    }
}
