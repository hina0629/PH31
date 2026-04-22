<?php
// PHP Samples Project Index
// 各セクションとファイルの定義（データ化）
$sections = [
    [
        'id' => '04_hello',
        'label' => 'Hello World (基本)',
        'public' => true,
        'files' => [
            [
                'name' => 'info.php',
                'label' => 'PHP情報表示',
            ],
            [
                'name' => 'demo.php',
                'label' => 'Hello World',
            ]
        ]
    ],
    [
        'id' => '05_variable',
        'label' => '変数とデータ型',
        'public' => true,
        'files' => [
            [
                'name' => 'player.php',
                'label' => '変数の基本',
            ],
            [
                'name' => 'superglobals.php',
                'label' => 'スーパーグローバル変数',
            ],
            [
                'name' => 'check.php',
                'label' => 'データ型チェック',
            ]
        ]
    ],
    [
        'id' => '06_calculate',
        'label' => '演算',
        'public' => true,
        'files' => [
            [
                'name' => 'order.php',
                'label' => '演算の基本',
            ],
        ]
    ],
    [
        'id' => '07_includes',
        'label' => '外部ファイルの読み込み',
        'public' => true,
        'files' => [
            [
                'name' => 'index.php',
                'label' => 'ファイル分離の基本',
            ],
        ]
    ],
    [
        'id' => '08_condition',
        'label' => '条件分岐 (if/match)',
        'public' => true,
        'files' => [
            [
                'name' => 'menu.php',
                'label' => 'メニュー',
            ],
            [
                'name' => 'garbage.php',
                'label' => 'ゴミ出しカレンダー',
            ],
            [
                'name' => 'payment.php',
                'label' => 'お支払い判定',
            ]
        ]
    ],
    [
        'id' => '09_loops',
        'label' => '繰り返し処理 (for/while)',
        'public' => true,
        'files' => [
            [
                'name' => 'bingo.php',
                'label' => 'ビンゴカード生成',
            ],
            [
                'name' => 'calculate_loan.php',
                'label' => 'ローン計算シミュレーター',
            ]
        ]
    ],
    [
        'id' => '10_array_object',
        'label' => '配列とオブジェクト',
        'public' => true,
        'files' => [
            [
                'name' => 'user/',
                'label' => 'ユーザープロフィール',
            ]
        ]
    ],
    [
        'id' => '11_function',
        'label' => '関数とクロージャ',
        'public' => true,
        'files' => [
            [
                'name' => 'data_check.php',
                'label' => 'ビルトイン関数',
            ],
            [
                'name' => 'order.php',
                'label' => 'ユーザ定義関数',
            ],
        ]
    ],
    [
        'id' => '12_form_session',
        'label' => 'フォームとセッション',
        'public' => true,
        'files' => [
            [
                'name' => 'get_request.php',
                'label' => 'GETリクエスト',
            ],
            [
                'name' => 'post_request.php',
                'label' => 'POSTリクエスト',
            ],
        ]
    ],
    [
        'id' => '13_datetime',
        'label' => '日付',
        'public' => true,
        'files' => [
            [
                'name' => 'date.php',
                'label' => 'date()関数',
            ],
            [
                'name' => 'datetime.php',
                'label' => 'DateTimeクラスの使い方',
            ],
            [
                'name' => 'calendar.php',
                'label' => 'カレンダー表示',
            ],
        ]
    ],
    [
        'id' => '14_class',
        'label' => 'オブジェクト指向とクラス',
        'public' => true,
        'files' => [
            [
                'name' => 'instance.php',
                'label' => 'OOPとクラス',
            ],
            [
                'name' => 'card_list.php',
                'label' => 'カードリスト',
            ],
        ]
    ],
    [
        'id' => '15_card_game',
        'label' => 'クラスの応用',
        'public' => true,
        'files' => [
            [
                'name' => 'card_list.php',
                'label' => 'ポリモーフィズム',
            ],
        ]
    ],
    [
        'id' => '16_mysql',
        'label' => 'MySQL & PDO',
        'public' => true,
        'files' => [
            [
                'name' => 'fin/create_database.php',
                'label' => 'DB作成',
            ],
            [
                'name' => 'fin/connect_test.php',
                'label' => 'DB接続テスト',
            ],
            [
                'name' => 'fin/connect_test_for_module.php',
                'label' => 'DB接続テスト（モジュール化）',
            ],
        ]
    ],
    [
        'id' => '17_mysql_crud',
        'label' => 'CRUD操作',
        'public' => true,
        'files' => [
            [
                'name' => 'fin/',
                'label' => 'CRUD操作',
            ],
        ]
    ],
    [
        'id' => '18_register',
        'label' => 'ユーザー登録',
        'public' => true,
        'files' => [
            ['name' => 'fin/regist/', 'label' => '登録画面'],
        ]
    ],
    [
        'id' => '19_signin',
        'label' => 'ユーザー認証',
        'public' => true,
        'files' => [
            ['name' => '/', 'label' => 'サインイン画面'],
        ]
    ],
    [
        'id' => '20_php_sns',
        'label' => 'PHP SNS',
        'public' => true,
        'files' => [
            [
                'name' => 'home/',
                'label' => 'SNSアプリ',
            ],
        ]
    ],
];
