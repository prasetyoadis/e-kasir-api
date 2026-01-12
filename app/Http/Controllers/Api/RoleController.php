<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        # Get data role dengan limit paginate 10.
        $roles = Role::paginate(10);
        
        return $this->successPaginated(
            message: 'Roles retrieved successfully',
            data: RoleResource::collection($roles),
            paginator: $roles
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        # Validate formrequest with StoreRoleRequest.
        $dataValid = $request->validated();
        
        # Create data table Roles.
        $role = Role::create($dataValid);

        # Return json request data $role.
        return $this->successCreateData(
            message: "Role Created Successfully",
            data: ['id' => $role->id]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return $this->successGetData(
            message: 'Request processed successfully',
            data: $role
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        # Validate formrequest with UpdateRoleRequest.
        $dataValid = $request->validated();

        $role = Role::where('id', $role->id)->update($dataValid);
        
        return $this->successUpdateData(
            message: 'Role updated successfully',
            id: $role->id
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
