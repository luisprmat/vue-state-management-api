<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $orders = Auth::user()
            ->orders()
            ->with('orderLines')
            ->get();

        return OrderResource::collection($orders);
    }

    public function store(Request $request): JsonResource
    {
        // Get the cart items from the request and validate with the database
        $cartItems = collect($request->input('cart'));
        $dbProducts = Product::whereIn('id', $cartItems->pluck('id'))->get();

        $taxRate = 0.10;
        $cartItems = $cartItems
            // Filter out items that are not in the database
            ->filter(fn ($item) => $dbProducts->firstWhere('id', $item['id']))
            // Map the items to include the product, quantity, price per unit, and total price
            ->map(function ($item) use ($dbProducts, $taxRate) {
                $dbProduct = $dbProducts->firstWhere('id', $item['id']);

                return [
                    'product' => $dbProduct,
                    'quantity' => $item['quantity'],
                    'price_per_unit' => $ppu = $dbProduct->price * (1 + $taxRate),
                    'total_price' => $item['quantity'] * $ppu,
                ];
            });

        // Create an order
        $order = Auth::user()->orders()->create([
            'tax_rate' => $taxRate,
            'total_price' => round($cartItems->sum('total_price') * 100) / 100,
        ]);

        // ... and associate orderLines with it
        $cartItems->each(function ($item) use ($order) {
            $order->orderLines()->create([
                'title' => $item['product']->title,
                'quantity' => $item['quantity'],
                'price_per_unit' => round($item['price_per_unit'] * 100) / 100,
                'total_price' => round($item['total_price'] * 100) / 100,
            ]);
        });

        // Load relationship and return the order
        $order->load('orderLines');

        return OrderResource::make($order);
    }
}
