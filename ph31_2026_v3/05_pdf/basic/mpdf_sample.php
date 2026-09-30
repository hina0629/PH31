<?php
// composer require mpdf/mpdf で mPDF をインストールしてください
require_once dirname(__DIR__, 2) . '/bootstrap.php';

use Mpdf\Mpdf;

// 初期化（日本語モード・A4サイズ）
$config = [
    'mode' => 'ja-JP',
    'format' => 'A4'
];

// TODO: Mpdf のインスタンス化
$mpdf = new Mpdf($config);

// HTMLを書き込み
$html = '
    <h1 style="color: #4f46e5;">こんにちは、mPDF！</h1>
    <p>これは最小構成のサンプルです。</p>
';

// TODO: HTMLの書き込み: WriteHTML()
$mpdf->WriteHtml($html);

// TODO: ブラウザに表示: Output() (I: Inline, D: Download)
$mpdf->Output('sample.pdf', 'I');