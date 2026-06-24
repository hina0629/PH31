<?php

namespace App\Services;

use App\Models\Reply;
use App\Models\Tweet;
use App\Models\User;

class TweetService
{
    public function getTimelineTweets(int $authUserId, string $tab = 'public', int $limit = 10, int $offset = 0): array
    {
        $tweet = new Tweet();
        // $tabの値で条件分岐し、投稿を取得
        $tweets = match ($tab) {
            'followers' => $tweet->getByFollowingUsers($authUserId, $limit, $offset),
            default => $tweet->get($authUserId, $limit, $offset),
        };
        // 取得した投稿にユーザ情報をマージ
        return $this->hydrateTweets($tweets, $authUserId);
    }

    public function searchTweets(string $keyword, int $authUserId): array
    {
        $tweet = new Tweet();
        // $keywordで検索して投稿を取得
        $tweets = $tweet->search($keyword, $authUserId);
        // 投稿にユーザ情報をマージ
        return $this->hydrateTweets($tweets, $authUserId);
    }

    public function getTweetDetail(int $tweetId, int $authUserId): ?array
    {
        $tweet = new Tweet();
        $reply = new Reply();
        // 投稿を取得
        $tweetData = $tweet->findWithUser($tweetId, $authUserId);
        // 投稿がなければnullを返す
        if (!$tweetData) return null;
        // 投稿にユーザ情報をマージ
        $tweetData = $this->hydrateTweet($tweetData, $authUserId);
        // リプライを取得
        $tweetData['replies'] = $this->hydrateReplies($reply->getByTweetId($tweetId));
        // 投稿データを返す
        return $tweetData;
    }

    public function hydrateTweets(?array $tweets, int $authUserId): array
    {
        if (!$tweets) return [];
        foreach ($tweets as &$tweet) {
            // 投稿にユーザ情報をマージ
            $tweet = $this->hydrateTweet($tweet, $authUserId);
        }
        unset($tweet);

        return $tweets;
    }

    public function hydrateTweet(array $tweet, int $authUserId): array
    {
        // プロフィール画像を設定
        $tweet['profile_image_url'] = User::profileImage($tweet['profile_image'] ?? null);
        $tweet['liked'] = (bool) ($tweet['liked'] ?? false);

        if (empty($tweet['image_path'])) {
            $tweet['image_path'] = null;
        }
        // いいね数を設定
        $tweet['like_count'] = (int) ($tweet['like_count'] ?? 0);
        // リプライ数を設定
        $tweet['reply_count'] = (int) ($tweet['reply_count'] ?? 0);

        return $tweet;
    }

    public function hydrateReplies(?array $replies): array
    {
        if (!$replies) return [];

        foreach ($replies as &$reply) {
            $reply['profile_image_url'] = User::profileImage($reply['profile_image'] ?? null);
        }
        unset($reply);

        return $replies;
    }
}
