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

        $order = Order::findOrFail($request->id);
        $orderDetails = [
            'id' => $order->id,
            'created_at' => $order->created_at->format('F j, Y'),
            'name' => $order->name,
            'description' => $order->description,
            'price' => number_format($order->price, ), // Format the total price
        ];
        $order->status = 'delivered';
        $order->save();

    // Send email
        Mail::to($order->client->email)->send(new ProductDeliveredMail($order,$orderDetails));

    return response()->json(['message' => 'Order delivered successfully, email sent to client.',]);
}
}

   
