<?php
// 2つ上のディレクトリにあるvendor/autoload.phpを読み込む
require '../../vendor/autoload.php';

// QRコード生成ライブラリの読み込み
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;

// QRコードのサイズ
$size = 300;
// QRコードのマージン
$margin = 10;

// URLを取得
$text = $_GET['url'] ?? '';
if (!$text) {
    http_response_code(400);
    echo 'URLが指定されていません。';
    exit;
}

// TODO: QRコード生成
$qrCode = new QrCode(
    data: $text,
    encoding: new Encoding('UTF-8'),
    size: $size,
    margin: $margin,
);

// TODO: PNGとして出力
$writer = new PngWriter();
// $writer = new Endroid\QrCode\Writer\PngWriter();
$result = $writer->write($qrCode);

// TODO: 画像出力
header('Content-Type: ' . $result->getMimeType());
// 出来上がった画像を文字列で出力
echo $result->getString();

// TODO: 画像をファイルに保存
$domain = parse_url($text, PHP_URL_HOST);
$file_name = $domain . '.png';
$result->saveToFile('../images/' . $file_name);