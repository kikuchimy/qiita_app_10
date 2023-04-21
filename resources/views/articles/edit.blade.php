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
    <div class="article-create">
        <form action="{{ route('articles.update', $article->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="select-tag">
                <label for="tag"><span class="mgl"><i class="fas fa-tags size"></i></span><span class="mgl">タグ</span></label>
                <input type="text" id="tags" name="tags" class="write-tag-area" placeholder="記事に関するタグをスペース区切りで5つまで入力" value="{{ $article->tags }}" autofocus>
            </div>
            <div class="write-title">
                <label for="title"><span class="mgl"><i class="fas fa-book-open"></i></span><span class="mgl">タイトル</span></label>
                <input type="text" id="title" name="title" class="write-title-area" placeholder="記事のタイトルを記載してください" value="{{ $article->title }}">
            </div>
            <div class="write-text">
                <label for="textarea"><span class="mgl"><i class="far fa-edit"></i></span><span class="mgl">本文</span></label>
                <textarea id="textarea" name="body" class="write-text-area" placeholder="記事の本文を記載してください">{{ $article->body }}</textarea>
            </div>
            <button type="submit" class="submit-button">記事を更新</button>
        </form>
        <button type="button" class="return-button" onclick="location.href='{{ route('articles.index') }}'">一覧へ戻る</button>
    </div>
@endsection
