<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use function Laravel\Prompts\error;

class AuthorController extends Controller
{
    public function store(Request $request)
    {
        $validator = validator($request->all(),[
            'author' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->errors(errors: $validator->errors());
        }

        Author::create($validator->validated());

        return back();
    }
}
