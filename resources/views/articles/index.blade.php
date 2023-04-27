{{-- {{ dd($articles) }} --}}
@extends('layouts.main')

@section('content')
    @if (session('flash_message'))
        <div class="flash_message">
            <strong>
                {{ session('flash_message') }}
            </strong>
        </div>
    @endif
    @if (!empty($errors))
        <div class="error">
            @foreach($errors->all() as $error)
            <strong>
                {{ $error }}
            </strong>
            @endforeach
        </div>
    @endif
    <div class="article-contents">
        <aside class="aside-left">
            <nav id="left-nav">
                <ul class="left-content">
                    <div class="home">
                        <li><i class="fas fa-home"></i>
                        <li><a href="{{ route('articles.index') }}" class="home-link">ホーム</a></li>
                    </div>
                    <li class="left-nav-li"><a href="#">タイムライン</a></li>
                    <li class="left-nav-li"><a href="#">トレンド</a></li>
                    <li class="left-nav-li"><a href="#">カレンダーフィード</a></li>
                </ul>
            </nav>
            <div id="left-hamburger">
                <span class="left-inner_line" id="left-line1"></span>
                <span class="left-inner_line" id="left-line2"></span>
                <span class="left-inner_line" id="left-line3"></span>
            </div>
        </aside>

        <article>
            @if (!empty($articles))
                <ul>
                    @foreach ($articles as $article)
                    <li class="articles">
                        <div class="user-wrapper">
                            <img src= {{ $article->user->profile_image_url }} class="user-img">
                            {{-- {{ $article->user->id }}さんが投稿 --}}
                            {{ $article->user->id }}さんが{{ \Carbon\Carbon::parse($article->created_at)->setTimezone('Asia/Tokyo')->format('Y年m月d日 H時i分s秒'); }}に投稿
                        </div>
                        <p>
                            {{-- {{ $article->title }} --}}
                            <a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a>
                        </p>
                        <p>
                            <i class="fas fa-tags"></i>
                            @foreach ($article->tags as $article_tag)
                                <span class="mgr">
                                    {{ $article_tag->name }}
                                    @if (next($article->tags))
                                        @php echo ',' @endphp
                                    @endif
                                </span>
                            @endforeach
                        </p>
                        <p>
                            <i class="fas fa-thumbs-up"></i>
                            <span class="mgr">LGTM {{ $article->likes_count }}</span>
                        </p>
                    </li>
                    @endforeach
                </ul>
            @endif
            @if (!empty($my_articles))
                <ul>
                    @foreach ($my_articles as $my_article)
                        <li class="articles">
                            <div class="user-wrapper">
                                <img src= {{ $my_article->user->profile_image_url }} class="user-img">
                                {{-- {{ $my_article->user->id }}さんが{{ \Carbon\Carbon::parse($my_article->created_at)->setTimezone('Asia/Tokyo')->format('Y年m月d日 H時i分s秒'); }}に投稿 --}}
                                testさんが{{ \Carbon\Carbon::parse($my_article->created_at)->setTimezone('Asia/Tokyo')->format('Y年m月d日 H時i分s秒'); }}に投稿
                            </div>
                            <p>
                                <a href="{{ route('articles.show', $my_article->id) }}">{{ $my_article->title }}</a>
                            </p>
                            <p>
                                <i class="fas fa-tags"></i>
                                @foreach ($my_article->tags as $my_article_tag)
                                {{ $my_article_tag->name }};
                                @endforeach
                            </p>
                            <p>
                                <i class="fas fa-thumbs-up"></i>
                                LGTM {{ $my_article->likes_count }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </article>

        <aside class="aside-right">
            <nav id="right-nav">
                <ul class="right-content">
                    <li class="right-nav-li"><a href="#">お知らせ</a></li>
                    <li class="right-nav-li"><a href="#">おすすめの記事</a></li>
                    <li class="right-nav-li"><a href="#">記事ランキング</a></li>
                </ul>
            </nav>

            <div id="right-hamburger">
                <span class="right-inner_line" id="right-line1"></span>
                <span class="right-inner_line" id="right-line2"></span>
                <span class="right-inner_line" id="right-line3"></span>
            </div>
        </aside>
    </div>
@endsection
