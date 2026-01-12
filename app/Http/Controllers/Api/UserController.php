<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Services\User\CreateUserService;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\CurrentUserResource;

class UserController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     * 
     * @return JsonResponse call fun successGetData param $message, $data
    */
    public function current()
    {
        # get current user login
        $currentUser = JWTAuth::parseToken()->authenticate();
        $currentUser->loadMissing(['roles', 'roles.permissions', 'subscriptions', 'subscriptions.outlets']);

        # return json response data currentUser
        return $this->successGetData(
            message: 'Request processed successfully',
            data: new CurrentUserResource($currentUser)
        );
    }

    /**
     * Display a listing of the resource.
     * 
     * @return json successPaginated()
     */
    public function index()
    {
        # Get data user dengan limit paginate 10.
        $users = User::with(['roles'])->paginate(2);
        
        return $this->successPaginated(
            message: 'Request processed successfully',
            data: UserResource::collection($users),
            paginator: $users
        );
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param App\Http\Requests\User\StoreUserRequest $request
     * @param App\Services\User\CreateUserService $createUser
     * @return json successCreateData()
     */
    public function store(StoreUserRequest $request, CreateUserService $createUser)
    {
        # Owner data
        $ownerId = JWTAuth::parseToken()->getPayload()->get('sub');
        # Validate formrequest with StoreUserRequest.
        $dataValid = $request->validated();
        # Hash password user.
        $dataValid['password'] = Hash::make($request->password);
        
        # Execute CreateUserService (create new user, assign role, assign subscription by outlet)
        $user = $createUser->execute(
            data: $dataValid,
            ownerId: $ownerId
        );

        # Return json request data $user.
        return $this->successCreateData(
            message: 'User created successfully',
            data: new UserResource($user)
        );
    }

    /**
     * Display the specified resource.
     * 
     * @param User $owner
     * @return json successGetData()
     */
    public function show(User $user)
    {
        $user->loadMissing(['roles', 'subscriptions', 'subscriptions.outlets']);
        return $this->successGetData(
            message: 'Request processed successfully',
            data: new UserResource($user)
        );
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param App\Http\Requests\User\UpdateUserRequest $request
     * @param User $user
     * @return json successUpdateData()
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
        $dataValid = $request->validated();

        $user = User::where('id', $user->id)->update($dataValid);
        
        return $this->successUpdateData(
            message: 'User update successfully',
            id: $user->id
        );
    }

    /**
     * Update status user false
     * 
     * @param User $user
     * @return json successUpdateData()
     */
    public function deactivate(User $user)
    {
        $user->update([
            'is_active' => false
        ]);

        return $this->successUpdateData(
            message: 'User has been deactivated',
            id: $user->id
        );
    }

    /**
     * Update status user true
     * 
     * @param User $user
     * @return json successUpdateData()
     */
    public function activate(User $user)
    {
        $user->update([
            'is_active' => true
        ]);

        return $this->successUpdateData(
            message: 'User has been activated',
            id: $user->id
        );
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param User $user
     * @return json successSoftDeleteData()
     */
    public function destroy(User $user)
    {
        //
        DB::transaction(function () use ($user) {
            $user->update(['is_active' => false]); // change is_active
            $user->delete(); // soft delete
        });

        return $this->successSoftDeleteData(
            message: 'User has been removed',
            id: $user->id
        );
    }
}
