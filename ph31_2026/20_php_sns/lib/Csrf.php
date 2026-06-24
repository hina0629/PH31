<?php

namespace Lib;

class Csrf
{
    private const SESSION_KEY = 'csrf_token';

    /**
     * CSRFトークンを取得する（なければ生成してセッションに保存）
     */
    public static function token(): string
    {
        if (empty($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }
        return $_SESSION[self::SESSION_KEY];
    }

    /**
     * POSTされたトークンをセッションのトークンと照合する
     */
    public static function verify(): bool
    {
        $posted = $_POST['csrf_token'] ?? '';
        $stored = $_SESSION[self::SESSION_KEY] ?? '';
        return !empty($posted) && hash_equals($stored, $posted);
    }
}
