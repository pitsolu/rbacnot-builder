<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    /**
     * @Get("/")
     * @Permission("permission:add_user")
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $data = $roles->toArray();

        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Roles retrieved successfully.'
        ];

        return response()->json($response, 200);
    }
}
