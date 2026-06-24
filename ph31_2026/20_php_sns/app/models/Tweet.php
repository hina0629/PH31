<?php

namespace App\Models;

use PDO;
use PDOException;
use RuntimeException;
use Lib\Database;
use Lib\File;

class Tweet
{
    private ?string $lastError = null;

    public function getLastError(): ?string
    {
        return $this->lastError;
    }

    /**
     * 投稿データを取得
     *
     * @return array|null 投稿データの連想配列、もしくは該当する投稿がなければ null
     */
    public function get(int $auth_user_id, int $limit = 10, int $offset = 0): ?array
    {
        return $this->fetchTweets('', [], $auth_user_id, $limit, $offset);
    }

    public function getByFollowingUsers(int $auth_user_id, int $limit = 10, int $offset = 0): ?array
    {
        $where = 'tweets.user_id IN (
            SELECT follows.followee_id
            FROM follows
            WHERE follows.follower_id = :auth_user_id
        )';

        return $this->fetchTweets($where, ['auth_user_id' => $auth_user_id], $auth_user_id, $limit, $offset);
    }

    public function getByUserID(int $user_id, int $auth_user_id, int $limit = 50): ?array
    {
        return $this->fetchTweets('tweets.user_id = :user_id', ['user_id' => $user_id], $auth_user_id, $limit);
    }

    /**
     * キーワード検索して取得
     *
     * @return array|null 投稿データの連想配列、もしくは該当する投稿がなければ null
     */
    public function search(string $keyword, int $auth_user_id, int $limit = 50): ?array
    {
        // # 直後のスペース有無を正規化して両方にマッチさせる
        // 例: "#anime" → "%#anime%" と "%# anime%" の両方を検索
        $normalized = preg_replace('/#\s+/', '#', $keyword);   // "# anime" → "#anime"
        $spaced     = preg_replace('/#(?=\S)/', '# ', $normalized); // "#anime" → "# anime"

        // TODO: WHERE で LIKE 検索: 
        $where = "";
        // $where  = '(tweets.message LIKE :keyword OR tweets.message LIKE :keyword_spaced)';

        $params = [];
        // TODO: 検索パラメータ: 
        // 'keyword' => "%{$normalized}%",
        // 'keyword_spaced' => "%{$spaced}%",

        return $this->fetchTweets($where, $params, $auth_user_id, $limit);
    }

    private function fetchTweets(string $where, array $params, int $auth_user_id, int $limit, int $offset = 0): ?array
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT
                    tweets.id,
                    tweets.message,
                    tweets.user_id,
                    tweets.image_path,
                    tweets.created_at,
                    tweets.updated_at,
                    users.account_name,
                    users.display_name,
                    users.profile_image,
                    COUNT(DISTINCT likes.id) AS like_count,
                    COUNT(DISTINCT replies.id) AS reply_count,
                    CASE WHEN COUNT(DISTINCT my_likes.id) > 0 THEN 1 ELSE 0 END AS liked
                FROM tweets
                JOIN users ON tweets.user_id = users.id
                LEFT JOIN likes ON tweets.id = likes.tweet_id
                LEFT JOIN replies ON tweets.id = replies.tweet_id
                LEFT JOIN likes AS my_likes
                    ON tweets.id = my_likes.tweet_id
                    AND my_likes.user_id = :viewer_user_id"
                . ($where ? " WHERE {$where}" : "")
                . " GROUP BY
                    tweets.id,
                    tweets.message,
                    tweets.user_id,
                    tweets.image_path,
                    tweets.created_at,
                    tweets.updated_at,
                    users.account_name,
                    users.display_name,
                    users.profile_image
                ORDER BY tweets.created_at DESC
                LIMIT :limit OFFSET :offset";
            $params['viewer_user_id'] = $auth_user_id;
            $params['limit']  = $limit;
            $params['offset'] = $offset;
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * 投稿データを取得
     *
     * @param int $id 投稿ID
     * @return array|null 投稿データの連想配列、もしくは該当する投稿がなければ null
     */
    public function find(int $id): ?array
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT * FROM tweets WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            $value = $stmt->fetch(PDO::FETCH_ASSOC);
            return $value;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * 投稿データを取得
     *
     * @param int $id 投稿ID
     * @return array|null 投稿データの連想配列、もしくは該当する投稿がなければ null
     */
    public function findWithUser(int $id, ?int $auth_user_id = null): ?array
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT
                        t.*,
                        u.display_name,
                        u.account_name,
                        u.profile_image,

                        (SELECT COUNT(*) FROM likes WHERE tweet_id = t.id) AS like_count,
                        (SELECT COUNT(*) FROM replies WHERE tweet_id = t.id) AS reply_count,

                        CASE
                            WHEN EXISTS (
                                SELECT 1 FROM likes
                                WHERE tweet_id = t.id AND user_id = :viewer_user_id
                            ) THEN 1 ELSE 0
                        END AS liked

                    FROM tweets t
                    JOIN users u ON t.user_id = u.id
                    WHERE t.id = :id;";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'viewer_user_id' => $auth_user_id,
            ]);
            $value = $stmt->fetch(PDO::FETCH_ASSOC);
            return $value;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * ユーザデータをDBに登録する
     *
     * @param int $user_id ユーザID
     * @param array $data 登録する投稿データ
     * @return mixed 登録成功時は投稿ID、失敗時は null
     */
    public function insert(int $user_id, array $data): ?int
    {
        $this->lastError = null;

        try {
            $data['user_id'] = $user_id;
            $data['image_path'] = $this->uploadImage();

            $pdo = Database::getInstance();
            // TODO: tweets テーブルにデータを追加：INSERT
            // (user_id, message, image_path)
            $sql = '';
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute($data);
            if ($result) {
                return $pdo->lastInsertId();
            }
            $this->lastError = 'tweet insert execute returned false';
            return null;
        } catch (RuntimeException $e) {
            $this->lastError = $e->getMessage();
            error_log($e->getMessage());
            return null;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * 投稿データを削除
     *
     * @param int $id 投稿ID
     * @return mixed
     */
    public function delete(int $id): bool
    {
        try {
            $pdo = Database::getInstance();
            $sql = "DELETE FROM tweets WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * 投稿データのカウント
     *
     * @param int $user_id ユーザID
     * @return int 投稿数
     */
    public function countByUserID($user_id): int
    {
        try {
            $pdo = Database::getInstance();
            // TODO: tweets テーブルからユーザIDが一致するレコード数を取得：COUNT
            $sql = 'SELECT COUNT(0)';

            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    /**
     * 画像データを取得
     *
     * @return array|null 画像データの連想配列、もしくは該当する画像がなければ null
     */
    public function getImages(): ?array
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT id, image_path FROM tweets
                    WHERE image_path IS NOT NULL AND image_path != ''
                    ORDER BY created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * アップロード画像を取得
     *
     * @return ?string 成功した場合は画像ファイルパス、失敗した場合は null
     */
    public function uploadImage(): ?string
    {
        if (!isset($_FILES['file']) || $_FILES['file']['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('image upload error code: ' . $_FILES['file']['error']);
        }

        return File::upload(UPLOADS_BASE);
    }
}
