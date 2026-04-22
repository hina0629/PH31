<?php

/**
 * CLI (Command Line Interface) 実行用サンプル
 * 
 * 実行方法:
 * php 01_hello/cli_demo.php
 */

// ターミナルに文字を出力 (PHP_EOL は OS ごとの改行コード)
echo "----------------------------------------" . PHP_EOL;
echo "   PHP CLI Demo Program" . PHP_EOL;
echo "----------------------------------------" . PHP_EOL;

// ユーザーに入力を促す
echo "あなたのお名前を入力してください: ";

// 標準入力 (stdin) から 1行読み込む
$name = trim(fgets(STDIN));

if (empty($name)) {
    $name = "名無しさん";
}

// 結果を出力
echo PHP_EOL;
echo "こんにちは、" . $name . " さん！" . PHP_EOL;
echo "現在は " . date('Y-m-d H:i:s') . " です。" . PHP_EOL;
echo "CLIではHTMLタグを使わず、プレーンテキストで結果を表示します。" . PHP_EOL;
echo "----------------------------------------" . PHP_EOL;
