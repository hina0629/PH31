<?php

namespace App\Models;

use PDO;
use PDOException;
use Lib\Database;

class Reply
{
    /**
     * ツイートIDに紐づく返信一覧を取得（ユーザー情報含む）
     *
     * @param int $tweet_id ツイートID
     * @return ?array 返信一覧、失敗時は null
     */
    public function getByTweetId(int $tweet_id): ?array
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT
                        replies.id,
                        replies.tweet_id,
                        replies.user_id,
                        replies.message,
                        replies.created_at,
                        users.display_name,
                        users.account_name,
                        users.profile_image
                    FROM replies
                    JOIN users ON replies.user_id = users.id
                    WHERE replies.tweet_id = :tweet_id
                    ORDER BY replies.created_at ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['tweet_id' => $tweet_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * 返信を投稿し、INSERT した ID を返す
     *
     * @param int    $tweet_id ツイートID
     * @param int    $user_id  投稿者ユーザーID
     * @param string $message  返信本文
     * @return int|null 成功時は lastInsertId、失敗時は null
     */
    public function insert(int $tweet_id, int $user_id, string $message): int|null
    {
        try {
            $pdo = Database::getInstance();
            $sql = "INSERT INTO replies (tweet_id, user_id, message)
                    VALUES (:tweet_id, :user_id, :message)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'tweet_id' => $tweet_id,
                'user_id'  => $user_id,
                'message'  => $message,
            ]);
            return (int) $pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * IDで返信を1件取得（ユーザー情報含む）
     *
     * @param int $id 返信ID
     * @return array|false 返信データ、存在しない場合は false
     */
    public function findById(int $id): array|false
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT
                        replies.id,
                        replies.tweet_id,
                        replies.user_id,
                        replies.message,
                        replies.created_at,
                        users.display_name,
                        users.account_name,
                        users.profile_image
                    FROM replies
                    JOIN users ON replies.user_id = users.id
                    WHERE replies.id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * 指定ツイートの返信数を取得
     *
     * @param int $tweet_id ツイートID
     * @return int 返信数
     */
    public function count(int $tweet_id): int
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT COUNT(*) AS cnt FROM replies WHERE tweet_id = :tweet_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['tweet_id' => $tweet_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['cnt'];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    /**
     * 返信を削除（本人のみ）
     *
     * @param int $id      返信ID
     * @param int $user_id 操作者ユーザーID（本人確認用）
     * @return bool 成功時は true
     */
    public function delete(int $id, int $user_id): bool
    {
        try {
            $pdo = Database::getInstance();
            $sql = "DELETE FROM replies WHERE id = :id AND user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute(['id' => $id, 'user_id' => $user_id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
