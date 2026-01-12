<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'subscription_id' => $this->id,
            'subscription_type'=> $this->subscription_type,
            'subscription_outlets' => OutletResource::collection(
                $this->whenLoaded('outlets')
            ),
            'subscription_status' => $this->subscription_status,
            'valid_from' => $this->valid_from?->toISOString(),
            'valid_to' => $this->valid_to?->toISOString(),
        ];
    }
}
