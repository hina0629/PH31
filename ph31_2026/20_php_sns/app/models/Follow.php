<?php

namespace App\Models;

use PDO;
use PDOException;
use Lib\Database;

class Follow
{
    /**
     * フォロー関係の取得
     *
     * @param int $follower_id フォローするユーザーID
     * @param int $followee_id フォローされるユーザーID
     * @return array|null フォロー情報、存在しなければ null
     */
    public function fetch(int $follower_id, int $followee_id): ?array
    {
        if (empty($follower_id) || empty($followee_id)) {
            return null;
        }
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT * FROM follows
                    WHERE follower_id = :follower_id
                    AND followee_id = :followee_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['follower_id' => $follower_id, 'followee_id' => $followee_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /**
     * フォローを追加
     */
    public function insert(int $follower_id, int $followee_id): bool
    {
        if ($follower_id === $followee_id) {
            return false;
        }

        try {
            $pdo = Database::getInstance();
            // TODO: follows テーブルにデータを追加：INSERT
            // (follower_id, followee_id)
            $sql = '';
            $stmt = $pdo->prepare($sql);
            return $stmt->execute(['follower_id' => $follower_id, 'followee_id' => $followee_id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * フォローを削除
     */
    public function delete(int $follower_id, int $followee_id): bool
    {
        try {
            $pdo = Database::getInstance();
            // TODO: follows テーブルからデータを削除：DELETE
            // follower_id と followee_id が一致するレコードを削除
            $sql = '';
            $stmt = $pdo->prepare($sql);
            return $stmt->execute(['follower_id' => $follower_id, 'followee_id' => $followee_id]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * フォローのトグル（フォロー中ならアンフォロー、未フォローならフォロー）
     */
    public function update(int $follower_id, int $followee_id): bool
    {
        if ($this->fetch($follower_id, $followee_id)) {
            return $this->delete($follower_id, $followee_id);
        } else {
            return $this->insert($follower_id, $followee_id);
        }
    }

    /**
     * フォロー数（自分がフォローしている数）
     *
     * @param int $user_id ユーザーID
     * @return int フォロー数
     */
    public function countFollowing(int $user_id): int
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT COUNT(0) AS cnt FROM follows WHERE follower_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['cnt'];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    /**
     * フォロワー数（自分をフォローしている数）
     *
     * @param int $user_id ユーザーID
     * @return int フォロワー数
     */
    public function countFollowers(int $user_id): int
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT COUNT(*) AS cnt FROM follows WHERE followee_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int) $result['cnt'];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    public function getFollowingUsers(int $user_id): array
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT
                        users.id,
                        users.account_name,
                        users.display_name,
                        users.profile,
                        users.profile_image,
                        follows.created_at AS followed_at
                    FROM follows
                    INNER JOIN users ON follows.followee_id = users.id
                    WHERE follows.follower_id = :user_id
                    ORDER BY follows.created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getFollowerUsers(int $user_id): array
    {
        try {
            $pdo = Database::getInstance();
            $sql = "SELECT
                        users.id,
                        users.account_name,
                        users.display_name,
                        users.profile,
                        users.profile_image,
                        follows.created_at AS followed_at
                    FROM follows
                    INNER JOIN users ON follows.follower_id = users.id
                    WHERE follows.followee_id = :user_id
                    ORDER BY follows.created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
}
