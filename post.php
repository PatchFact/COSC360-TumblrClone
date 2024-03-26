<?php
class Post
{
    public $post_id;
    public $title;
    public $body;
    public $user_id;
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
        $this->post_id = $entry['post_id'];
        $this->title = $entry['title'];
        $this->body = $entry['body'];
        $this->user_id = $entry['user_id'];
        $this->visible = $entry['visible'];
        $this->created_at = $entry['created_at'];
    }

    public static function fetchAll()
    {
        self::initPDO();

        $query = "SELECT * FROM posts";

        $stmt = self::$pdo->prepare($query);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $posts = array_map(function ($row) {
            return new Post($row);
        }, $rows);

        return $posts;
    }
}
