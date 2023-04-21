{{-- {{ dd($article) }} --}}
@extends('layouts.main')

@section('content')
    @if (!empty($errors))
        <div class="error">
            @foreach($errors->all() as $error)
            <strong>
                {{ $error }}
            </strong>
            @endforeach
        </div>
    @endif
    <div class="article-show">
        <aside class="aside-lgtm">
            <div class="show-lgtm">
                <span>LG<br>TM</span>
            </div>
            <p class="show-like-count">{{ $article->likes_count }}</p>
        </aside>

        <article class="article-show-content">  
            <div class="user-wrapper">
                <img src= {{ $article->user->profile_image_url }} class="user-img">
                {{ $article->user->name }}さん
                <p>投稿日 {{ \Carbon\Carbon::parse($article->created_at)->setTimezone('Asia/Tokyo')->format('Y年m月d日 H時i分s秒'); }}</p>
            </div>

            <h1>{{ $article->title }}</h1>

            <p class="article-tag">
                <i class="fas fa-tags size"></i>
                @foreach ($article->tags as $article_tag)
                    <span class="mgr">
                        {{ $article_tag->name }}
                        @if (next($article->tags))
                            @php echo ',' @endphp
                        @endif
                    </span>
                @endforeach
            </p>

            {{-- <div> --}}
            <div class="markdown-body">
                {{-- {{ $article->body }} --}}
                {{-- {!! Str::markdown($article->body, ['html_input' => 'escape']) !!} --}}
                {{-- {{ $article->html }} --}}
                <p class="article-body">{{ $article->html }}</p>
            </div>
        </article>
    </div>
    @if ($article->user->permanent_id == $user->permanent_id)
        <div class="my-article-button">
            <button type="button" class="edit-button" onclick="location.href='{{ route('articles.edit', $article->id) }}'">編集する</button>
            <button type="submit" class="delete-button" form="delete-form" onclick="if(!confirm('本当に削除していいですか？')){return false};">削除する</button>
            <form action="{{ route('articles.destroy', $article->id) }}" method="post" id="delete-form">
                @csrf
                @method('DELETE')
            </form>
        </div>
    @endif
    <button type="button" class="show-return-button" onclick="location.href='{{ route('articles.index') }}'">一覧へ戻る</button>
@endsection
