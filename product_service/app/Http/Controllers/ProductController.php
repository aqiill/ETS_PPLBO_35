<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public    function index()
    {
        $products = Product::all();
        return response()->json(['data' => $products]);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['data' => $product]);
    }

    public function add_product(Request $request)
    {
        $this->validate($request, [
            'name_product' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'required'
        ]);

        $product = new Product;
        $product->name_product = $request->name_product;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->image = $request->image;
        $product->save();

        return response()->json(['message' => 'Product created', 'data' => $product], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $this->validate($request, [
            'name_product' => 'nullable',
            'price' => 'nullable',
            'stock' => 'nullable',
            'image' => 'nullable'
        ]);

        if ($request->has('name_product')) {
            $product->name_product = $request->name_product;
        }
        if ($request->has('price')) {
            $product->price = $request->price;
        }
        if ($request->has('stock')) {
            $product->stock = $request->stock;
        }
        if ($request->has('image')) {
            $product->image = $request->image;
        }
        $product->save();

        return response()->json(['message' => 'Product updated', 'data' => $product], 200);
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted'], 200);
    }
}
