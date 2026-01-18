<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderLineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'title' => $this->title,
            'quantity' => (int) $this->quantity,
            'price_per_unit' => (float) $this->price_per_unit,
            'total_price' => (float) $this->total_price,
        ];
    }
}
