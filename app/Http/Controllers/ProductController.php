<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends Controller
{
    public function index(): JsonResource
    {
        sleep(1); // Simulates delay

        return ProductResource::collection(Product::all());
    }
}
