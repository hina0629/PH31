<?php
require_once __DIR__ . '/../app.php';

use Lib\Database;

try {
    $pdo = Database::getInstance();
    
    // カラムが存在するか確認
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'target_calories'");
    $columnExists = $stmt->fetch();
    
    if (!$columnExists) {
        // カラムを追加
        $pdo->exec("ALTER TABLE users ADD COLUMN target_calories INT DEFAULT 1000 AFTER password_hash");
        echo "Success: 'target_calories' column added to 'users' table.\n";
    } else {
        echo "Info: 'target_calories' column already exists.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
