<?php

/**
 * サニタイズ関数1
 * @param string $str サニタイズする文字列
 * @return string サニタイズ後の文字列
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * サニタイズ関数2
 * @param array $data サニタイズするデータ
 * @return array サニタイズ後のデータ
 */
function sanitize(array $data): array
{
    $cleaned = [];
    foreach ($data as $key => $value) {
        $cleaned[$key] = $value ? h((string) $value) : $value;
    }
    return $cleaned;
}
