<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function store(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'genre' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errors(errors: $validator->errors());
        }

        Genre::create($validator->validated());

        return back();
    }
}
