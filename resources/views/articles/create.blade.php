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
        <form action="{{ route('articles.store') }}" method="POST">
            @csrf
            <div class="select-tag">
                <label for="tag"><span class="mgl"><i class="fas fa-tags size"></span></i><span class="mgl">タグ</span></label>
                <input type="text" id="tags" name="tags" class="write-tag-area" placeholder="知識に関連するタグをスペース区切りで5つまで入力 (例 Ruby Rails)" autofocus>
            </div>
            <div class="write-title">
                <label for="title"><span class="mgl"><i class="fas fa-book-open"></span></i><span class="mgl">タイトル</span></label>
                <input type="text" id="title" name="title" class="write-title-area" placeholder="記事のタイトルを記載してください">
            </div>
            <div class="write-text">
                <label for="textarea"><span class="mgl"><i class="far fa-edit"></span></i><span class="mgl">本文</span></label>
                <textarea id="textarea" name="body" class="write-text-area" placeholder="エンジニアに関わる知識をMarkdown記法で書いて共有しよう"></textarea>
            </div>
            <button type="submit" class="submit-button"><i class="fas fa-file-import"></i><span class="mgl">Qiita_app</span>に投稿</button>
        </form>
        <button type="button" class="return-button" onclick="location.href='{{ route('articles.index') }}'">一覧へ戻る</button>
    </div>
@endsection
