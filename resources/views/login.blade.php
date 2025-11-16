<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
<form action="/login" method="POST">
    @csrf
    <div class="title">
        Вход в админ панель
    </div>
    <label>
        Почта
        <input type="email" name="email" >
    </label>

    <label>
        Пароль
        <input type="password" name="password" >
    </label>
    @error("error")
    <div class="error">{{$message}}</div>
    @enderror
    <button>Войти</button>
</form>
</body>
</html>
