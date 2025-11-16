<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user && $user->role == "admin") {

            $authors = Author::all();
            $genres = Genre::all();
            $books = Book::all();

            return view('admin', compact('authors', 'genres', 'books'));
        }
        return view('login');

    }

    public function login(Request $request)
    {
        $validator = validator(request()->all(), [
            "email" => "required",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        if (!auth()->attempt($request->only('email', 'password'))) {
            return back()->withErrors([
                "error" => "Incorrect email or password"
            ])->withInput();
        }
        if (auth()->user()->role != "admin") {
            auth()->logout();
            return back()->withErrors(["error" => "Not an admin"])->withInput();
        }
        return back();

    }

    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }
}
