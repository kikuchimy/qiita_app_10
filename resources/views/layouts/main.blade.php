<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/github-markdown-css@3.0.1/github-markdown.min.css">
    <title>Qiita_app</title>
</head>

<body>
    <header class="page-header">
        <p class="app-name"><a href="{{ route('articles.index') }}"><b>Qiita_app</b></a></p>
        <p class="post-button"><a href="{{ route('articles.create') }}" class="button"><i class="far fa-edit"></i>投稿する</a></p>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="wrapper">
            <p><a href="{{ route('articles.index') }}">Qiita_app</a></p>
            <p><small>&copy; 2021 NEXT REVOLUTION</small></p>
        </div>
    </footer>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
