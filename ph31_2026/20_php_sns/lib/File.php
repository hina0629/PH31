<?php

namespace Lib;

class File
{
    public static function localDir(string $path): string
    {
        // 末尾スラッシュを付けてディレクトリ連結を安定させる
        return rtrim(BASE_DIR . '/' . trim($path, '/'), '/') . '/';
    }

    public static function has(string $path): bool
    {
        $localDir = self::localDir($path);
        return file_exists($localDir);
    }

    public static function checkUploadDir(string $uploadDir): bool
    {
        // ディレクトリが存在しない場合は作成
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
                return false;
            }
        }
        // ディレクトリのパーミッションを設定
        if (is_dir($uploadDir)) {
            @chmod($uploadDir, 0777);
            return $uploadDir;
        }
        return false;
    }

    public static function upload(string $uploadDir, string $fileName = '', string $key = 'file'): ?string
    {
        // 画像がアップロードされているか確認
        if (isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK) {
            // アップロードされたファイルの情報を取得
            $tmpPath = $_FILES[$key]['tmp_name'];
            if (!is_uploaded_file($tmpPath)) {
                return null;
            }
            // 画像の拡張子を取得
            $extension = strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION));
            // 画像ファイル名を指定
            if ($fileName) {
                $fileName .= $extension ? ".{$extension}" : '';
            } else {
                $fileName = uniqid('', true) . ($extension ? ".{$extension}" : '');
            }
            // アップロード先のディレクトリを指定
            $localDir = self::localDir($uploadDir);
            // アップロード先のディレクトリを確認
            $checkedDir = self::checkUploadDir($localDir);
            if ($checkedDir === false) {
                return null;
            }
            // アップロード先のパスを指定
            $uploadPath = $checkedDir . $fileName;
            // ファイルを指定したディレクトリに移動
            if (move_uploaded_file($tmpPath, $uploadPath)) {
                // URLパス
                $imagePath = $uploadDir . $fileName;
                return $imagePath;
            }
        }
        return null;
    }
}
