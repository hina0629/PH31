<?php

namespace App\Controllers;

use App\Models\Tweet;
use App\Models\Like;
use App\Models\User;
use App\Services\TweetService;
use Lib\Request;
use Lib\View;

class HomeController extends AuthenticatedController
{
    public function index()
    {
        // タブの種類（公開・フォロー中）
        $tab = $_GET['tab'] ?? 'public';

        // 投稿タイムラインを取得: ログインユーザのID、タブの種類、表示件数
        $tweetService = new TweetService();
        $tweets = $tweetService->getTimelineTweets((int) $this->authUser['id'], $tab, 50);

        // Viewをレンダリング: app/views/home/index.view.php
        // TODO: $tweetsを渡す
        View::render('home/index', [
            'auth_user' => $this->authUser,
            'active_tab' => $tab,
        ]);
    }

    public function detail()
    {
        // TODO: GETパラメータからIDを取得: $_GET['id']
        $id = 0;
        // 投稿IDがなければホームにリダイレクト
        if (!$id) Request::redirect('home/');

        // 投稿詳細を取得: 投稿ID、ログインユーザのID
        $tweetService = new TweetService();
        $tweet_data = $tweetService->getTweetDetail((int) $id, (int) $this->authUser['id']);

        // 投稿詳細がなければホームにリダイレクト
        if (!$tweet_data) Request::redirect('home/');

        // Viewをレンダリング: app/views/home/detail.view.php
        View::render('home/detail', [
            'auth_user' => $this->authUser,
            'tweet' => $tweet_data,
            'replies' => $tweet_data['replies'],
        ]);
    }

    public function user_tweets()
    {
        // ユーザIDを取得
        $user_id = $_GET['id'] ?? null;

        // ユーザ検索
        $user = new User();
        $user_data = $user->find($user_id);

        // ユーザいない場合はホームにリダイレクト
        if (!$user_data) Request::redirect('home/');

        // ユーザ投稿データを取得: ユーザID、ログインユーザのID
        $tweet = new Tweet();
        $tweets = $tweet->getByUserID((int) $user_data['id'], (int) $this->authUser['id']);

        // Viewをレンダリング: app/views/home/user_tweets.view.php
        View::render('home/user_tweets', ['tweets' => $tweets]);
    }

    public function add()
    {
        // POST以外はリダイレクト
        Request::checkPost();

        // POSTデータを取得: 投稿内容、画像
        $posts = sanitize($_POST);

        // TODO: ログインユーザのIDに置き換える: $this->authUser['id']
        $posts['user_id'] = 0;

        $tweet = new Tweet();
        $tweet->insert($posts['user_id'], $posts);

        // トップにリダイレクト
        Request::redirect('home/');
    }

    public function search()
    {
        // キーワードを取得
        $keyword = trim((string) ($_GET['keyword'] ?? ''));
        $tweets = [];

        // キーワードがあれば検索実行
        if ($keyword !== '') {
            $tweetService = new TweetService();
            $tweets = $tweetService->searchTweets($keyword, (int) $this->authUser['id']);
        }

        // Viewをレンダリング: app/views/home/search.view.php
        View::render('home/search', [
            'auth_user' => $this->authUser,
            'keyword' => $keyword,
            'tweets' => $tweets,
        ]);
    }

    public function garally()
    {
        // 投稿クラス
        $tweet = new Tweet();

        // Viewをレンダリング: app/views/home/garally.view.php
        View::render('home/garally', [
            'auth_user' => $this->authUser,
            'tweets' => $tweet->getImages() ?? [],
        ]);
    }

    public function delete()
    {
        // POSTリクエスト以外は処理しない
        Request::checkPost();

        // POSTデータを取得
        $posts = sanitize($_POST);

        // ログインユーザのIDと投稿のユーザIDが一致しない場合はホームにリダイレクト
        if ((int) $this->authUser['id'] !== (int) $posts['user_id']) {
            Request::redirect('home/');
        }

        // 削除処理
        $tweet = new Tweet();
        $tweet->delete($posts['tweet_id']);

        // ホームにリダイレクト
        Request::redirect('home/');
    }
}
