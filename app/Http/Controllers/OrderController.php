<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\ProductDeliveredMail;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class OrderController extends Controller
{
     // Client: Place Order
     public function placeOrder(Request $request)
     {
         $product = Product::findOrFail($request->id);
         
         // Check if the product is approved
         if ($product->status != 'approved') {
             return response()->json(['error' => 'Product is not approved yet'], 400);
         }
 
         $order = Order::create([
             'product_id' => $product->id,
             'client_id' => auth()->user()->id,
         ]);
 
         return response()->json(['message' => 'Order placed successfully', 'order' => $order]);
     }
 
     // Seller: Deliver Order
     public function deliverOrder(Request $request)
    {
            $order = Order::findOrFail($request);
            
            // Ensure the authenticated user is the seller and the order status is valid
            if (auth()->user()->hasRole('seller') && $order->status === 'pending') {
                $order->status = 'delivered';
                $order->save();
    
                // Get the product and client details
                $product = $order->product;
                $client = $order->client; // Assuming the order has a client relation
    
                // Send email to the client
                Mail::to($client->email)->send(new ProductDeliveredMail($product, $client));
    
                return response()->json([
                    'message' => 'Order delivered and email sent to client.',
                    'order' => $order,
                ], 200);
            }
    
            return response()->json(['message' => 'Unauthorized or invalid order status.'], 403);
        }
    }
   
