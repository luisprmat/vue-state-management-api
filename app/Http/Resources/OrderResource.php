<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'tax_rate' => $this->tax_rate,
            'total_price' => (float) $this->total_price,
            'user_id' => $this->user_id,
            'order_lines' => OrderLineResource::collection($this->whenLoaded('orderLines')),
        ];
    }
}
