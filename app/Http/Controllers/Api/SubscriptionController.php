<?php

namespace App\Http\Controllers\Api;

use App\Enums\SubscriptionType;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Subscription\StoreSubscriptionRequest;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionRequest $request)
    {
        //
        $subType = SubscriptionType::from($request->validated('subscription_type'));
        $currentUser = JWTAuth::parseToken()->authenticate();
        
        $sub = Subscription::create([
            'user_id' => $currentUser->id,
            'subscription_type' => $subType,
            'subscription_status' => 'active',
            'valid_from' => now(),
            'valid_to' => now()->addDays($subType->durationDays())
        ]);

        $currentUser->subscriptions()->sync($sub->id);

        return $this->successCreateData(
            message: 'Subscription created successfully',
            data: ['id' => $sub->id]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
