<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateUserService
{
    public function execute(array $data, string $ownerId): User
    {
        return DB::transaction(function () use ($data, $ownerId) {
            # Create data table Users.
            $user = User::create($data);
            
            # Assign role
            if (!empty($data['roles'])) $user->roles()->sync($data['roles']);

            # Assign subscriptions
            if (!empty($data['outlets'])) $user->assignSubscriptionByOutlet(ownerId: (string) $ownerId, outletIds: $data['outlets']);

            return $user->loadMissing(['roles', 'subscriptions', 'subscriptions.outlets']);
        });
    }
}