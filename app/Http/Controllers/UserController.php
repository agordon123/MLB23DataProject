<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'email' => 'required|email|unique:App\Models\User',
            'username' => 'required|unique:App\Models\User',
            'password' => 'required',
            'roles' => 'sometimes|array|exists:Spatie\Permission\Models\Role,name',
            'brands' => 'sometimes|array|exists:App\Models\Brand,name'
        ]);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->errors()
            ], 400);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ]);

        if (!empty($request->roles)) {
            $user->syncRoles($request->roles);

            $user->save();
        }


        return (new UserResource($user))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes',
            'username' => "sometimes|unique:App\Models\User,id,{$user->id}",
            'password' => 'sometimes',
            'roles' => 'sometimes|array|exists:Spatie\Permission\Models\Role,name'
        ]);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->errors()
            ], 400);
        }

        if ($request->name) {
            $user->name = $request->name;
        }
        if ($request->username) {
            $user->username = $request->username;
        }
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        if ($request->roles) {
            $user->syncRoles($request->roles);
        }
        if ($user->isDirty()) {
            $user->save();
        }

        return (new UserResource($user))->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return Response::json([], 200);
    }
}
