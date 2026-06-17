<?php

namespace App\Models;

class AuthUser extends User
{
    private static string $key = APP_KEY;

    public static function check()
    {
        // セッションからユーザ情報を取得
        if (isset($_SESSION[self::$key])) {
            return $_SESSION[self::$key];
        }
    }

    public static function set(array $user)
    {
        // セッションにユーザ情報を保存
        $_SESSION[self::$key] = $user;
    }

    public static function clear()
    {
        // TODO: セッションからユーザ情報を削除
        if (isset($_SESSION[self::$key])) {
            unset($_SESSION[self::$key]);
        }
    }
}
