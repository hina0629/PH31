<?php

namespace App\Models;

use Lib\Request;

class AuthUser extends User
{
    /**
     * 認証ユーザ情報を取得
     *
     * @return array|null 認証ユーザ情報、もしくは該当するユーザがなければ null
     */
    public static function get(): ?array
    {
        // セッションから認証ユーザ情報を取得
        $auth_user = $_SESSION[APP_KEY]['auth_user'] ?? null;
        // 認証ユーザ情報が存在しない場合は null を返す
        if (empty($auth_user)) return null;
        // 認証ユーザ情報を返す
        return $auth_user;
    }

    public static function set(array $auth_user): void
    {
        // セッションから認証ユーザ情報を取得
        $_SESSION[APP_KEY]['auth_user'] = $auth_user;
    }

    public static function isLogin(): bool
    {
        // セッションから認証ユーザ情報を取得
        $auth_user = self::get();
        // 認証ユーザ情報が存在する場合は true を返す
        return !empty($auth_user);
    }

    /**
     * ログインチェック
     *
     * @return array|null 認証ユーザ情報、もしくは該当するユーザがなければ null
     */
    public static function checkLogin(): array
    {
        // セッションから認証ユーザ情報を取得
        $auth_user = self::get();
        // 認証ユーザ情報が存在しない場合はログイン画面にリダイレクト
        if (empty($auth_user)) Request::redirect('login/');
        // 認証ユーザ情報を返す
        return $auth_user;
    }

    /**
     * ログアウト処理
     */
    public static function logout(): void
    {
        // TODO: セッションから認証ユーザ情報を削除: unset() で APP_KEY, auth_user

        // ログアウト処理後のリダイレクト先を指定
        Request::redirect('login/');
    }
}
