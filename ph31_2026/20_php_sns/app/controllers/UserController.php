<?php

namespace App\Controllers;

use App\Models\Tweet;
use App\Models\User;
use App\Models\AuthUser;
use App\Models\Follow;
use App\Requests\UserUpdateRequest;
use App\Services\TweetService;
use Lib\Csrf;
use Lib\Request;
use Lib\View;

class UserController extends AuthenticatedController
{
    private function findRequestedUser(): ?array
    {
        // ユーザIDを取得: GETで取得したID、またはログインユーザのID
        $user_id = (int) ($_GET['id'] ?? $this->authUser['id']);
        // ユーザ情報を取得: ユーザIDで検索
        $user = new User();
        return $user->find($user_id);
    }

    private function buildProfileData(array $user_data): array
    {
        $tweet = new Tweet();
        $follow = new Follow();

        return [
            'tweet_count' => $tweet->countByUserID($user_data['id']),
            'follow_count' => $follow->countFollowing((int) $user_data['id']),
            'follower_count' => $follow->countFollowers((int) $user_data['id']),
            'is_following' => (int) $this->authUser['id'] === (int) $user_data['id']
                ? false
                : (bool) $follow->fetch((int) $this->authUser['id'], (int) $user_data['id']),
        ];
    }

    public function update()
    {
        // バリデート&リダイレクト
        $posts = UserUpdateRequest::validateOrRedirect();
        // ユーザ情報を更新
        $user = new User();
        $result = $user->update($this->authUser['id'], $posts);
        // 更新失敗
        if (!$result) {
            $_SESSION[APP_KEY]['user_edit'] = [
                'form' => $posts,
                'error' => '更新に失敗しました。',
            ];
            Request::redirect('user/edit.php');
        }

        // ユーザ情報をセッションに保存
        $this->authUser = $user->find($this->authUser['id']);
        // 認証ユーザ情報を更新
        AuthUser::set($this->authUser);
        // セッションに成功メッセージを設定
        $_SESSION[APP_KEY]['user_edit'] = [
            'success' => '保存しました。',
        ];
        // 編集画面へリダイレクト
        Request::redirect('user/edit.php');
    }

    public function logout()
    {
        AuthUser::logout();
        // ログアウト処理後のリダイレクト先を指定
        Request::redirect('login/');
    }

    public function uploadProfileImage()
    {
        // POSTチェック
        Request::checkPost('user/edit.php');
        // CSRFトークンを検証
        if (!Csrf::verify()) {
            $_SESSION[APP_KEY]['user_edit'] = [
                'error' => '不正なリクエストです。',
            ];
            Request::redirect('user/edit.php');
        }
        // ユーザ情報を更新
        $user = new User();
        // 画像アップロード
        $result = $user->uploadProfileImage($this->authUser['id']);
        // 更新失敗
        if (!$result) {
            $_SESSION[APP_KEY]['user_edit'] = [
                'error' => '画像の更新に失敗しました。',
            ];
            Request::redirect('user/edit.php');
        }
        // ユーザ情報をセッションに保存
        $this->authUser = $user->find($this->authUser['id']);
        // 認証ユーザ情報を更新
        AuthUser::set($this->authUser);
        // セッションに成功メッセージを設定
        $_SESSION[APP_KEY]['user_edit'] = [
            'success' => '画像を更新しました。',
        ];
        // 編集画面へリダイレクト
        Request::redirect('user/edit.php');
    }

    public function edit()
    {
        // ユーザ情報をDBから再読み込み
        $user = new User();
        $this->authUser = $user->find($this->authUser['id']);
        // セッションからeditStateを取得
        $editState = $_SESSION[APP_KEY]['user_edit'] ?? [];

        // フラッシュメッセージ
        unset($_SESSION[APP_KEY]['user_edit']['error']);
        unset($_SESSION[APP_KEY]['user_edit']['success']);

        // Viewをレンダリング: app/views/user/edit.view.php
        View::render('user/edit', [
            'auth_user' => $this->authUser,
            'form' => $editState['form'] ?? [],
            'error' => $editState['error'] ?? null,
            'success' => $editState['success'] ?? null,
        ]);
    }

    public function follow()
    {
        // POSTチェック
        Request::checkPost();

        // フォローするユーザID
        $followee_id = (int) ($_POST['followee_id'] ?? 0);

        // フォロー処理（トグル）
        $follow = new Follow();
        $follow->update((int) $this->authUser['id'], $followee_id);

        // ユーザページへリダイレクト
        Request::redirect('user/?id=' . $followee_id);
    }

    public function unfollow()
    {
        // POSTチェック
        Request::checkPost();

        // フォロー解除するユーザID
        $followee_id = (int) ($_POST['followee_id'] ?? 0);

        // フォロー解除処理（トグル）
        $follow = new Follow();
        $follow->update((int) $this->authUser['id'], $followee_id);

        // ユーザページへリダイレクト
        Request::redirect('user/?id=' . $followee_id);
    }

    public function index()
    {
        // ユーザ情報を検索
        $user_data = $this->findRequestedUser();
        // 該当ユーザがなければホームへリダイレクト
        if (!$user_data) {
            Request::redirect('home/');
        }

        // プロフィールデータ
        $profile = $this->buildProfileData($user_data);

        // 投稿データを取得
        $tweet = new Tweet();
        $tweetService = new TweetService();

        // Viewをレンダリング: app/views/user/index.view.php
        View::render('user/index', [
            'auth_user' => $this->authUser,
            'user_data' => $user_data,
            'tweets' => $tweetService->hydrateTweets(
                $tweet->getByUserID((int) $user_data['id'], (int) $this->authUser['id']),
                (int) $this->authUser['id']
            ),
            'active_tab' => 'posts',
            ...$profile,
        ]);
    }

    public function following()
    {
        // ユーザ情報を検索
        $user_data = $this->findRequestedUser();
        // 該当ユーザがなければホームへリダイレクト
        if (!$user_data) Request::redirect('home/');

        // フォローデータを取得
        $follow = new Follow();
        $users = $follow->getFollowingUsers((int) $user_data['id']);

        // Viewをレンダリング: app/views/user/following.view.php
        View::render('user/following', [
            'auth_user' => $this->authUser,
            'user_data' => $user_data,
            'users' => $users,
            'active_tab' => 'following',
            ...$this->buildProfileData($user_data),
        ]);
    }

    public function followers()
    {
        // ユーザ情報を検索
        $user_data = $this->findRequestedUser();
        // 該当ユーザがなければホームへリダイレクト
        if (!$user_data) Request::redirect('home/');

        // フォロワーデータを取得
        $follow = new Follow();
        $users = $follow->getFollowerUsers((int) $user_data['id']);

        // Viewをレンダリング: app/views/user/followers.view.php
        View::render('user/followers', [
            'auth_user' => $this->authUser,
            'user_data' => $user_data,
            'users' => $users,
            'active_tab' => 'followers',
            ...$this->buildProfileData($user_data),
        ]);

        // フォロー一覧を取得
        $follow = new Follow();
        $users = $follow->getFollowerUsers((int) $user_data['id']);

        // Viewをレンダリング: app/views/user/followers.view.php
        View::render('user/followers', [
            'auth_user' => $this->authUser,
            'user_data' => $user_data,
            'users' => $users,
            'active_tab' => 'followers',
            ...$this->buildProfileData($user_data),
        ]);
    }
}
