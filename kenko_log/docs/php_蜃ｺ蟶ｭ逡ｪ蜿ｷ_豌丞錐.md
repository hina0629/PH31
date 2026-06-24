# Kenko Log 未完成箇所調査レポート

## 提出者

- 出席番号:
- 氏名:
- 調査日:



## 調査した項目一覧
1. No.1: DB 接続情報 
2. 
3. 
4. 
5. 
6. 
7. 
8. 

## No1. DB 接続情報 
#### 症状
データベースに接続できない

#### 確認したファイル
- env.php
- admin/create_database.php

#### 原因
実行環境に合わせてDB 接続情報を設定し、DBを構築する必要がある

#### 修正内容
- DB接続設定

```php
const DB_CONNECTION = 'mysql';
const DB_HOST = '127.0.0.1';
const DB_NAME = 'health_log';
const DB_USER = 'root';
const DB_PASS = '';
const DB_PORT = '3306';
const DB_CHARSET = 'utf8mb4';
```

### 動作確認
- データベース初期化画面で、セットアップを実行し「セットアップ完了」と表示
- DBクライアントでDB作成確認

## No2. トップページのキャッチコピー
#### 症状
トップページ左側にキャッチコピーが表示されない。

#### 確認したファイル
- ./index.php
- components/top/hero_left.php

#### 原因
`index.php` で `components/top/hero_left.php` が読み込まれていない。

#### 修正内容
PHPで include

```php
<?php include "components/top/hero_right.php" ?>
```

#### 動作確認
トップページのヒーローセクションにキャッチコピーが表示された。
---

## AI 利用について

- AI を利用したか:
- 利用した内容:
- 自分で確認した内容:

## 現状の問題点
- 
- 

## まとめ