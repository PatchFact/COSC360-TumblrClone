<?php
class Comment
{
    public $comment_id;
    public $body;
    public $user_id;
    public $post_id;
    public $visible;
    public $created_at;
    private static $pdo;

    private static function initPDO()
    {
        if (self::$pdo === null) {
            self::$pdo = require 'db.php';
        }
    }

    private function __construct($entry)
    {
        $this->comment_id = $entry['comment_id'];
        $this->body = $entry['body'];
        $this->user_id = $entry['user_id'];
        $this->post_id = $entry['post_id'];
        $this->visible = $entry['visible'];
        $this->created_at = $entry['created_at'];
    }

    public static function getByPostId($post_id)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("SELECT * FROM comments WHERE post_id = :post_id AND visible = 1");
        $stmt->execute(['post_id' => $post_id]);
        $commentsData = $stmt->fetchAll();

        $comments = [];
        foreach ($commentsData as $commentData) {
            $comments[] = new Comment($commentData);
        }

        return $comments;
    }

    public static function getById($comment_id)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("SELECT * FROM comments WHERE comment_id = :comment_id LIMIT 1");
        $stmt->execute(['comment_id' => $comment_id]);
        $comment = $stmt->fetch();

        if (!$comment) {
            return null;
        }

        return new Comment($comment);
    }

    public static function insertComment($body, $user_id, $post_id)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("INSERT INTO comments (body, user_id, post_id) VALUES (:body, :user_id, :post_id)");
        $stmt->execute([
            'body' => $body,
            'user_id' => $user_id,
            'post_id' => $post_id
        ]);

        return self::$pdo->lastInsertId();
    }

    public static function setVisibility($comment_id, $visible)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("UPDATE comments SET visible = :visible WHERE comment_id = :comment_id");
        $stmt->execute([
            'visible' => $visible,
            'comment_id' => $comment_id
        ]);

        if ($stmt->rowCount()) {
            return 1;
        } else {
            return null;
        }
    }
}
