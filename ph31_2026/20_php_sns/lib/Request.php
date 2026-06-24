<?php

namespace Lib;

class Request
{
    /**
     * POSTリクエストかどうかを返す
     * @return bool
     */
    public static function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * リダイレクト
     * @param string $path リダイレクト先パス
     * @return void
     */
    public static function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . $path);
        exit;
    }

    /**
     * POSTリクエストでなければリダイレクト
     * @param string $path リダイレクト先パス
     * @return void
     */
    public static function checkPost(string $path = ""): void
    {
        if (!self::isPost()) {
            $path ? self::redirect($path) : exit;
        }
    }
}
