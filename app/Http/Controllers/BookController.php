<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookGenre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $books = Book::query();


        $search = $request->query("query");
        $books = $books->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', "%" . $search . "%")
                ->orWhere('author', 'LIKE', "%" . $search . "%");
        });


        if ($request->min_price) {
            $books = $books->where('price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $books = $books->where('price', '<=', $request->max_price);
        }
        if ($request->has("min_rating") && !empty($request->min_rating)) {
            $books = $books->where('rating', '>=', $request->min_rating);
        }
        if ($request->has("max_rating") && !empty($request->max_rating)) {
            $books = $books->where('rating', '<=', $request->max_rating);
        }
        if ($request->has("sort") && !empty($request->sort)) {
            if ($request->sort == "desc") {
                $books = $books->orderBy('rating', 'desc');
            }
        }
        $books_list = $books->paginate(12);

        return response()->json(BookResource::collection($books_list));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            "title" => "required|string|min:4",
            "author" => "required|string|exists:authors,author",
            "genre_ids" => "required|array|min:1",
            "genre_ids.*" => "integer|exists:genres,id",
            "price" => "required|integer|min:0",
            "preview" => "required|image|mimes:jpeg,jpg,png",
        ]);

        if ($validator->fails()) {
            return $this->errors($validator->errors());
        }

        $data = $validator->validated();

        $author = Author::query()->where('author', $data['author'])->first();
        $data['author_id'] = $author->id;

        $preview = $request->preview;

        $type = $preview->getClientOriginalExtension();

        if ($type == 'png') $preview = imagecreatefrompng($preview);
        if ($type == 'jpg' || $type == 'jpeg') $preview = imagecreatefromjpeg($preview);

        $color = imagecolorallocate($preview, 0, 0, 0);

        imagettftext($preview, 29, 0, 30, 30, $color, public_path("ARIAL.TTF"), $data['title']);
        imagettftext($preview, 29, 0, 30, 50, $color, public_path("ARIAL.TTF"), $data['author']);

        $url = Str::uuid() . "." . $type;

        if ($type == "png") imagepng($preview, public_path("images/books" . $url));
        if ($type == "jpg" || $type == "jpeg") imagejpeg($preview, public_path("images/books" . $url));


        $data['preview'] = url("images/books" . $url);

        imagedestroy($preview);


        $book = Book::create([
            "title"=>$data['title'],
            "author_id"=>$data['author_id'],
            "price"=>$data['price'],
            "preview"=>$data['preview'],
        ]);

        foreach ($data["genre_ids"] as $genre_id) {
            BookGenre::query()->create(['book_id' => $book->id, 'genre_id' => $genre_id]);
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return back();
    }
}
