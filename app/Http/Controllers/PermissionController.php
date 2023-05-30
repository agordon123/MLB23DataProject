<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PermissionResource;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PermissionResource::collection(Permission::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->hasPermissionTo('add permission', 'web')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'errors' => $validator->errors()
                ], 400);
            }

            $permission = Permission::create(['name' => $request->name, 'guard_name' => 'web']);

            return (new PermissionResource($permission))->response()->setStatusCode(201);
        } else {
            return Response::json([
                'errors' => 'You do not have proper permissions'
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Permission $permission)
    {
        if ($request->user()->hasPermissionTo('view permission', 'web')) {
            return (new PermissionResource($permission))->response()->setStatusCode(200);
        } else {
            return Response::json([
                'errors' => 'You do not have proper permissions'
            ], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        if ($request->user()->hasPermissionTo('edit permission', 'web')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'errors' => $validator->errors()
                ], 400);
            }


            if ($request->name) {
                $permission->name = $request->name;
            }
            if ($permission->isDirty()) {
                $permission->save();
            }

            return (new PermissionResource($permission))->response()->setStatusCode(200);
        } else {
            return Response::json([
                'errors' => 'You do not have proper permissions'
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Permission $permission)
    {
        if ($request->user()->hasPermissionTo('delete permission', 'web')) {
            $permission->delete();
            return Response::json([], 200);
        } else {
            return Response::json([
                'errors' => 'You do not have proper permissions'
            ], 401);
        }
    }
}
