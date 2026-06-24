<?php

namespace App\Requests;

use Lib\Csrf;
use Lib\Request;

class UserUpdateRequest
{
    public static function validateOrRedirect(): array
    {
        // POSTチェック
        Request::checkPost();
        // CSRFトークンを検証
        if (!Csrf::verify()) {
            self::redirectWithState([], '不正なリクエストです。');
        }
        // ユーザ情報取得
        $posts = sanitize($_POST);
        // CSRFトークンを削除
        unset($posts['csrf_token']);
        // バリデーション
        $validated = [
            'display_name' => trim((string) ($posts['display_name'] ?? '')),
            'profile' => trim((string) ($posts['profile'] ?? '')),
        ];
        // ディスプレイ名のチェック
        if ($validated['display_name'] === '') {
            self::redirectWithState($validated, 'ディスプレイ名は必須です。');
        }
        // ディスプレイ名の文字数チェック
        if (mb_strlen($validated['display_name']) > 255) {
            self::redirectWithState($validated, 'ディスプレイ名は255文字以内で入力してください。');
        }
        return $validated;
    }

    private static function redirectWithState(array $form, string $error): void
    {
        $_SESSION[APP_KEY]['user_edit'] = [
            'form' => $form,
            'error' => $error,
        ];

        Request::redirect('user/edit.php');
    }
}
