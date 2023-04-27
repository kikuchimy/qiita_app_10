<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Guzzle読み込み
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $method = 'GET';
        $tag_id = 'PHP';
        $per_page = 10;

        // QIITA_URLの値を取得してURLを定義
        // $url = config('qiita.url') . '/api/v2/tags/' . $tag_id . '/items';
        $url = config('qiita.url') . '/api/v2/tags/' . $tag_id . '/items?per_page=' . $per_page;

        // $optionsにトークンを指定
        $options = [
            'headers' => [
                // 'Authorization' => 'Bearer ' . config('qiita.token'),
                'Authorization' => 'Bearer ' . Crypt::decryptString(Auth::user()->token),
            ],
        ];

        // Client(接続する為のクラス)を生成
        $client = new Client();

        // try catchでエラー時の処理を書く
        try {
            // データを取得し、JSON形式からPHPの変数に変換
            $response = $client->request($method, $url, $options);
            $body = $response->getBody();
            $articles = json_decode($body, false);
        } catch (\Throwable $th) {
            $articles = null;
        }

        // 自分の記事を取得
        $method = 'GET';
        $per_page = 10;

        // QIITA_URLの値を取得してURLを定義
        $url = config('qiita.url') . '/api/v2/authenticated_user/items?per_page=' . $per_page;

        // $optionsにトークンを指定
        $options = [
            'headers' => [
                // 'Authorization' => 'Bearer ' . config('qiita.token'),
                'Authorization' => 'Bearer ' . Crypt::decryptString(Auth::user()->token),
            ],
        ];

        // Client(接続する為のクラス)を生成
        $client = new Client();

        // try catchでエラー時の処理を書く
        try {
            // データを取得し、JSON形式からPHPの変数に変換
            $response = $client->request($method, $url, $options);
            $body = $response->getBody();
            $my_articles = json_decode($body, false);
        } catch (\Throwable $th) {
            $my_articles = null;
        }

        // return view('articles.index')->with(compact('articles'));
        return view('articles.index')->with(compact('articles', 'my_articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $method = 'POST';

        // QIITA_URLの値を取得してURLを定義
        $url = config('qiita.url') . '/api/v2/items';

        // スペース区切りの文字列を配列に変換し、JSON形式に変換
        $tag_array = explode(' ', $request->tags);
        $tags = array_map(function ($tag) {
            return ['name' => $tag];
        }, $tag_array);

        // 送信するデータを整形
        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'private' => true,
            'tags' => $tags
        ];

        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                // 'Authorization' => 'Bearer ' . config('qiita.token'),
                'Authorization' => 'Bearer ' . Crypt::decryptString(Auth::user()->token),
            ],
            'json' => $data,
        ];

        // Client(接続する為のクラス)を生成
        $client = new Client();

        try {
            // データを送信する
            $client->request($method, $url, $options);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // GuzzleHttpで発生したエラーの場合はcatchする
            return back()->withErrors(['error' => '記事投稿に失敗しました']);
        }
        return redirect()->route('articles.index')->with('flash_message', '記事の投稿に成功しました' );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $method = 'GET';

        // QIITA_URLの値を取得してURLを定義
        $url = config('qiita.url') . '/api/v2/items/' . $id;

        // Client(接続する為のクラス)を生成
        $client = new Client();

        // $optionsにトークンを指定
        $options = [
            'headers' => [
                // 'Authorization' => 'Bearer ' . config('qiita.token'),
                'Authorization' => 'Bearer ' . Crypt::decryptString(Auth::user()->token),
            ],
        ];

        try {
            // データを取得し、JSON形式からPHPの変数に変換
            $response = $client->request($method, $url, $options);
            $body = $response->getBody();
            $article = json_decode($body, false);

            // 変換するクラスをインスタンス化して設定を追加
            $parser = new \cebe\markdown\GithubMarkdown();
            $parser->keepListStartNumber = true;  // olタグの番号の初期化を有効にする
            $parser->enableNewlines = true;  // 改行を有効にする

            // MarkdownをHTML文字列に変換し、HTMLに変換(エスケープする)
            $html_string = $parser->parse($article->body);
            $article->html = new \Illuminate\Support\HtmlString($html_string);
        } catch (\Throwable $th) {
            return back();
        }

        $method = 'GET';

        // QIITA_URLの値を取得してURLを定義
        $url = config('qiita.url') . '/api/v2/authenticated_user';

        // $optionsにトークンを指定
        $options = [
            'headers' => [
                // 'Authorization' => 'Bearer ' . config('qiita.token'),
                'Authorization' => 'Bearer ' . Crypt::decryptString(Auth::user()->token),
            ],
        ];

        // Client(接続する為のクラス)を生成
        $client = new Client();

        try {
            // データを取得し、JSON形式からPHPの変数に変換
            $response = $client->request($method, $url, $options);
            $body = $response->getBody();
            $user = json_decode($body, false);
        } catch (\Throwable $th) {
            return back();
        }

        // return view('articles.show')->with(compact('article'));
        return view('articles.show')->with(compact('article', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $method = 'GET';

        // QIITA_URLの値を取得してURLを定義
        $url = config('qiita.url') . '/api/v2/items/' . $id;

        // $optionsにトークンを指定
        $options = [
            'headers' => [
                // 'Authorization' => 'Bearer ' . config('qiita.token'),
                'Authorization' => 'Bearer ' . Crypt::decryptString(Auth::user()->token),
            ],
        ];

        // Client(接続する為のクラス)を生成
        $client = new Client();

        try {
            // データを取得し、JSON形式からPHPの変数に変換
            $response = $client->request($method, $url, $options);
            $body = $response->getBody();
            $article = json_decode($body, false);

            // tagsを配列からスペース区切りに変換
            $tag_array = array_map(function ($tag) {
                return $tag->name;
            }, $article->tags);
            $article->tags = implode(' ', $tag_array);
        } catch (\Throwable $th) {
            return back();
        }

        return view('articles.edit')->with(compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $method = 'PATCH';

        // QIITA_URLの値を取得してURLを定義
        $url = config('qiita.url') . '/api/v2/items/'. $id;

        // スペース区切りの文字列を配列に変換し、JSON形式に変換
        $tag_array = explode(' ', $request->tags);
        $tags = array_map(function ($tag) {
            return ['name' => $tag];
        }, $tag_array);

        // 送信するデータを整形
        $data = [
            'title' => $request->title,
            'body' => $request->body,
            'private' => true,
            'tags' => $tags
        ];

        $options = [
            'headers' => [
                // 'Authorization' => 'Bearer ' . config('qiita.token'),
                'Authorization' => 'Bearer ' . Crypt::decryptString(Auth::user()->token),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => $data,
        ];

        // Client(接続する為のクラス)を生成
        $client = new Client();

        try {
            // データを取得し、JSON形式からPHPの変数に変換
            $response = $client->request($method, $url, $options);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return back()->withErrors(['error' => '記事の更新に失敗しました']);
        }
        return redirect()->route('articles.index')->with('flash_message', '記事の更新に成功しました。' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $method = 'DELETE';

        // QIITA_URLの値を取得してURLを定義
        $url = config('qiita.url') . '/api/v2/items/' . $id;

        // $optionsにトークンを指定
        $options = [
            'headers' => [
                // 'Authorization' => 'Bearer ' . config('qiita.token'),
                'Authorization' => 'Bearer ' . Crypt::decryptString(Auth::user()->token),
            ],
        ];

        // Client(接続する為のクラス)を生成
        $client = new Client();

        try {
            $response = $client->request($method, $url, $options);
        // } catch (\GuzzleHttp\Exception\ClientException $e) {
        //     return back()->withErrors(['error' => '記事の削除に失敗しました']);
        //     // return redirect()->route('articles.index')->withErrors(['error' => '記事の削除に失敗しました']);
        // } catch (\GuzzleHttp\Exception\ConnectException $e) {
        //     return back()->withErrors(['error' => '記事の削除に失敗しました']);
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect()->route('articles.index')->withErrors(['error' => '記事の削除に失敗しました']);
        }

        return redirect()->route('articles.index')->with('flash_message', '記事を削除しました');
    }
}
