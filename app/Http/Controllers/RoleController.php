<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use Validator;

class RoleController extends Controller
{
    /**
     * @Get("/roles")
    */
    public function all(Request $request){

        $perpage = $request->input("perpage");
        $page = $request->input("page");

        $roles = Role::paginate($perpage, '*', 'page', $page);

        $response = [

            'success' => true,
            'data' => $roles->toArray(),
            "message"=>"Roles successfully retrived."
        ];

        return response()->json($response, 200);
    }

    /**
     * @Get("/role/{id:[0-9]+}")
    */
    public function get($id){

        $role = Role::find($id);

        if(is_null($role)){

            $response = [

                "success"=>false,
                "data"=>"",
                "message"=>"Role not found!"
            ];

            return response()->json($response, 404);
        }
        else{

            $response = [

                "success"=>true,
                "data"=>$role->toArray(),
                "message"=>"Role retrived successfully"
            ];

            return response()->json($response, 200);
        }
    }

    /**
     * @Get("/role/add")
     * @Only("permission:add_user")
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {

        $input = $request->all();

        $validator = Validator::make($input, [

            'name'=>"required",
            "display_name"=>"required"
        ]);

        if($validator->fails()){

            $response = [

                "success"=>false,
                "data"=>"Validation Error",
                "message"=>$validator->errors()
            ];

            return response()->json($response, 404);
        }
        else{

            $role = Role::create($input);

            $response = [

                "success"=>true,
                "data"=>$role->toArray(),
                "message"=>"Role successfuly saved"
            ];

            return response()->json($response, 200);
        }
    }

    /**
     * @Get("/role/{id}/update")
    */
    public function update(Request $request, $id){

        $role = Role::findOrFail($id);

        $input = $request->all();

        $validator = Validator::make($input, [

            "name" => "required",
            "display_name" => "required"
        ]);

        if($validator->fails()){

            $response = array(

                "success"=>false,
                "message"=>$validator->errors(),
                "data"=>""
            );

            return response()->json($response, 404);
        }
        else{

            $role->name = $input["name"];
            $role->display_name = $input["display_name"];
            $role->description = $input["description"];
            $role->save();

            $response = array(

                "success"=>true,
                "message"=>"Role successfully saved",
                "data"=>$role->toArray()
            );

            return response()->json($response, 404);
        }
    }
}
