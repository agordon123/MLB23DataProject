<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Response::json(['data' => Role::with('permissions')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->user()->hasPermissionTo('add roles', 'web')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'errors' => $validator->errors()
                ], 400);
            }

            $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

            return Response::json(['data' => $role]);
        } else {
            return Response::json([
                'errors' => 'You do not have proper permissions'
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Role $role)
    {
        if ($request->user()->hasPermissionTo('view roles', 'web')) {
            return Response::json(['data' => $role]);
        } else {
            return Response::json([
                'errors' => 'You do not have proper permissions'
            ], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if ($request->user()->hasPermissionTo('edit roles', 'web')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'errors' => $validator->errors()
                ], 400);
            }


            if ($request->name) {
                $role->name = $request->name;
            }
            if ($role->isDirty()) {
                $role->save();
            }

            return Response::json(['data' => $role]);
        } else {
            return Response::json([
                'errors' => 'You do not have proper permissions'
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Role $role)
    {
        if ($request->user()->hasPermissionTo('delete roles', 'web')) {
            $role->delete();
            return Response::json([], 200);
        } else {
            return Response::json([
                'errors' => 'You do not have proper permissions'
            ], 401);
        }
    }
    public function syncPermissions(Request $request, Role $role)
    {
        // if ($request->user()->hasPermissionTo('sync permission', 'web')) {
        $validator = Validator::make($request->all(), [
            'permissions' => 'sometimes|array',
        ]);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->errors()
            ], 400);
        }

        $role->syncPermissions($request->permissions);

        $role->load('permissions');
        return Response::json(['data' => $role]);
        // } else {
        //     return Response::json([
        //         'errors' => 'You do not have proper permissions'
        //     ], 401);
        // }
    }
}
