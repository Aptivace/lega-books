<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
<form action="/logout">
    @csrf
    <button>Выйти</button>
</form>
<form action="/books" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="title">
        Добавление книги
    </div>
    <label>
        Название
        <input type="text" name="title" >
    </label>
    <label>
        Автор
        <select name="author">
            @foreach($authors as $author)
                <option value={{$author["author_id"]}}>{{$author["author"]}}</option>
            @endforeach
        </select>
    </label>
    <label>
        Жанры
        <select name="genre_ids[]" multiple>
            @foreach($genres as $genre)
                <option value={{$genre["id"]}}>{{$genre["genre"]}}</option>
            @endforeach
        </select>
    </label>
    <label>
        Цена
        <input type="number" name="price">
    </label>
    <label>
        Превью
        <input type="file" name="preview">
    </label>
    @error("error")
    <div class="error">{{$message}}</div>
    @enderror
    <button>Добавить книгу</button>
</form>

<form action="/authors" method="POST">
    @csrf
    <h2>Добавить автора</h2>
    <label>
        Автор
        <input type="text" name="author">
    </label>
    <button>Добавить автора</button>
</form>

<form action="/genres" method="POST">
    @csrf
    <h2>Добавить жанр</h2>
    <label>
        Жанр
        <input type="text" name="genre">
    </label>
    <button>Добавить жанр</button>
</form>

<div class="books">
    @foreach($books as $book)
        <div class="book">
            <h4>{{$book->title}}</h4>
            <p>{{$book->author->author}}</p>
            <span>{{$book->price}}</span>
            <form action="/books/{{$book->id}}" method="POST">
                @csrf
                @method("DELETE")
                <button>Удалить книгу</button>
            </form>
        </div>
    @endforeach
</div>
</body>
</html>
