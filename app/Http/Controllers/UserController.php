<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;

class UserController extends Controller
{
    /**
     * @Get("/users")
    */
    public function all(Request $request){

        $perpage = $request->input("perpage");
        $page = $request->input("page");

        $users = User::paginate($perpage, ['name','email'], 'page', $page);

        $response = [

            'success' => true,
            'data' => $users->toArray(),
            "message"=>"Roles successfully retrived."
        ];

        return response()->json($response, 200);
    }

    /**
     * @Get("/user/{id}", where={"id": "[0-9]+"})
    */
    public function get($id){

        $user = User::find($id);

        if(is_null($user)){

            $response = [

                "success"=>false,
                "data"=>"",
                "message"=>"User not found!"
            ];

            return response()->json($response, 404);
        }
        else{

            $response = [

                "success"=>true,
                "data"=>$user->toArray(),
                "message"=>"User retrived successfully"
            ];

            return response()->json($response, 200);
        }
    }
}
