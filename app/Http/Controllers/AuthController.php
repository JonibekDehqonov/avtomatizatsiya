<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login()
    {
        return view('auth.login');

    }

    public function registor()
    {
        return view('auth.registor');
    }
    public function postLogin(Request $request)
    {
         $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required'
        ]);

    if ($validator->fails()){
        return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
    } else {
        if (Auth::attempt($request->only(["email", "password"]))) {
            return response()->json([
                'status'=>true,
                'redirect'=>'/products',
            ]);

        } else {
            return response()->json([
                "status" => false,
                "errors" => ["Invalid credentials"]
            ]);
        }
    }    }

    public function postRegistor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4'

        ]);

        if ($validator->fails()){
            return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
        }

        $data = $request->all();
        $user = $this->create($data);

        Auth::login($user);

        return response()->json([
            'status'=>true,
            'redirect'=>'products',
        ]);

    }

    public function create(array $data){
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
          ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

}
