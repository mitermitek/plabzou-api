<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Plabzou API</title>
</head>
<body>
<form action="{{ route('authenticate') }}" method="post">
    @csrf
    <input type="email" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <button type="submit">Connexion</button>
</form>
</body>
</html>
