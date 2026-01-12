<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrentUserResource extends JsonResource
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
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'msisdn' => $this->msisdn,
            'is_active'  => (bool) $this->is_active,
            'subscriptions' => SubscriptionResource::collection(
                $this->whenLoaded('subscriptions')
            ),
            'roles' => CurrentUserRoleResource::collection(
                $this->whenLoaded('roles')
            ),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString()
        ];
    }
}
