<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        if ($product->view_template && view()->exists($product->view_template)) {
            return view($product->view_template, compact('product'));
        }

        return view('front.products.show', compact('product'));
    }
}
