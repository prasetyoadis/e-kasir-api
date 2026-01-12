<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Outlet\StoreOutletRequest;
use App\Http\Requests\Outlet\UpdateOutletRequest;
use App\Http\Resources\OutletResource;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutletController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outlets = Outlet::where('owner_id', auth('api')->id())->paginate(5);
        return $this->successPaginated(
            message: 'Request processed successfully',
            data: OutletResource::collection($outlets),
            paginator: $outlets
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOutletRequest $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();

        # Validate formrequest with StoreOutletRequest.
        $dataValid = $request->validated();
        $dataValid['owner_id'] = $currentUser->id;

        $sub = $currentUser->subscriptions()->active()->latest('valid_from')->first();
        # Create data table Outlet.
        $outlet = Outlet::create($dataValid);

        $outlet->subscriptions()->sync($sub->id);

        return $this->successCreateData(
            message: 'Outlet created successfully',
            data: ['id' => $outlet->id]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Outlet $outlet)
    {
        return $this->successGetData(
            message: 'Request processed successfully',
            data: new OutletResource($outlet)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOutletRequest $request, Outlet $outlet)
    {
        # Validate formrequest with UpdateOutletRequest.
        $dataValid = $request->validated();

        # Update data outlet.
        $outlet->update($dataValid);

        return $this->successUpdateData(
            message: 'Outlet update successfully',
            id: $outlet->id
        );
    }

    /**
     * Update status outlet false
     * 
     * @param Outlet $outlet
     * @return JsonResponse call fun successUpdateData param $message, $id
     */
    public function deactivate(Outlet $outlet)
    {
        # Update data status is_active outlet.
        $outlet->update([
            'is_active' => false
        ]);

        return $this->successUpdateData(
            message: 'Outlet has been deactivated',
            id: $outlet->id
        );
    }

    /**
     * Update status user true
     * 
     * @param User $user
     * @return JsonResponse call fun successUpdateData param $message, $id
     */
    public function activate(Outlet $outlet)
    {
        # Update data status is_active outlet.
        $outlet->update([
            'is_active' => true
        ]);

        return $this->successUpdateData(
            message: 'Outlet has been activated',
            id: $outlet->id
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Outlet $outlet)
    {
        //
        DB::transaction(function () use ($outlet) {
            $outlet->update(['is_active' => false]); // change is_active
            $outlet->delete(); // soft delete
        });

        return $this->successSoftDeleteData(
            message: 'Outlet has been removed',
            id: $outlet->id
        );
    }
}
