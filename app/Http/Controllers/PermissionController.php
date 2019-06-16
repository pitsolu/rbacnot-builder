<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use Validator;

class PermissionController extends Controller
{
    /**
     * @Get("/permissions")
    */
    public function all(Request $request){

        $perpage = $request->input("perpage");
        $page = $request->input("page");

        $perm = Permission::paginate($perpage, '*', 'page', $page);

        $response = [

            'success' => true,
            'data' => $perm->toArray(),
            "message"=>"Permissions successfully retrived."
        ];

        return response()->json($response, 200);
    }

    /**
     * @Get("/permission/{id}", where={"id": "[0-9]+"})
    */
    public function get($id){

        $perm = Permission::find($id);

        if(is_null($perm)){

            $response = [

                "success"=>false,
                "data"=>"",
                "message"=>"Permission not found!"
            ];

            return response()->json($response, 404);
        }
        else{

            $response = [

                "success"=>true,
                "data"=>$perm->toArray(),
                "message"=>"Permission retrived successfully"
            ];

            return response()->json($response, 200);
       }
    }

    /**
     * @Get("/permission/add")
     * @Only("permission:add_permission")
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

            $perm = Permission::create($input);

            $response = [

                "success"=>true,
                "data"=>$perm->toArray(),
                "message"=>"Permission successfuly saved"
            ];

            return response()->json($response, 200);
        }
    }

    /**
     * @Get("/permission/{id}/update")
    */
    public function update(Request $request, $id){

        $perm = Permission::findOrFail($id);

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

            $perm->name = $input["name"];
            $perm->display_name = $input["display_name"];
            $perm->description = $input["description"];
            $perm->save();

            $response = array(

                "success"=>true,
                "message"=>"Role successfully saved",
                "data"=>$perm->toArray()
            );

            return response()->json($response, 404);
        }
    }
}
