<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Seller: Add Product
    public function addProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $imagePath = null;
         // Handle file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            // $imagePath = $image->storeAs('public', $imageName, 'public');
            $image->move(public_path('images/'), $imageName);
 // Store the image in public/products
        } else {
            $imagePath = null; // No image provided
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'seller_id' => auth()->user()->id,
        ]);

        return response()->json([
            'message' => 'Product added successfully', 
            // 'image_url'=> $product->image ? asset('storage/' . $product->image) : null,
            'image' => $imagePath ? str_replace('public/', '', $imagePath):null,
            'product' => $product,
            
        ]);
    }

    // Admin: Approve Product
    public function approveProduct(Request $request)
    {
        $product = Product::findOrFail($request->id);
        
        // Check if the user is an admin
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $product->update(['status' => 'approved']);

        return response()->json(['message' => 'Product approved successfully', 'product' => $product]);
    }


    
}
