<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "first_name" => "required|string",
            "last_name" => "required|string",
            "patronymic" => "required|string",
            "email" => "required|email|unique:users",
            "password" => "required|min:3",
            "birth_date" => "required|string",
        ]);
        if ($validator->fails()) {
            return $this->errors(errors: $validator->errors());
        }

        $data = $validator->validated();

        $user = User::create($data);

        return response()->json([
            "data" => [
                "user"=> [
                    "id" => $user->id,
                    "name" => "$data[first_name] $data[last_name] $data[patronymic]",
                    "email" => $user->email,
                ],
                "code" => 201,
                "message"=>"Пользователь создан"
            ]
        ]);
    }

    public function login(Request $request)
    {
        $validator = validator($request->all(), [
            "email" => "required",
            "password" => "required"
        ]);
        if ($validator->fails()) {
            return $this->errors(errors: $validator->errors());
        }

        if (!auth()->attempt($request->only("email", "password"))) {
            return $this->errors(message: "Login failed", status: 403);
        }

        $user = auth()->user();
        $token = Str::uuid();
        $user->update(["token" => $token]);

        return response()->json([
            "data" => [
                "user" => [
                    "id"=>$user->id,
                    "name"=>$user->name,
                    "birth_date"=>$user->birth_date,
                    "email"=>$user->email,
                ],
                "token" => $token,
            ]
        ]);
    }
    public function logout() {
        auth()->logout();
        return response()->json(status: 204);
    }
}
