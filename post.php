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

    public static function searchByKeyword($keyword)
    {
        self::initPDO();

        $query = "SELECT * FROM posts WHERE visible = 1 AND (title LIKE :keyword OR body LIKE :keyword)";

        $stmt = self::$pdo->prepare($query);
        $keyword = '%' . $keyword . '%';
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $posts = array_map(function ($row) {
            return new Post($row);
        }, $rows);

        return $posts;
    }

    public static function getImageSource($post_id)
    {
        self::initPDO();

        $query = "SELECT img_src FROM post_img WHERE post_id = :post_id LIMIT 1";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute(['post_id' => $post_id]);
        $imgSrc = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($imgSrc) {
            return $imgSrc['img_src'];
        } else {
            return null;
        }
    }

    public static function getById($post_id)
    {
        self::initPDO();

        $query = "SELECT * FROM posts WHERE post_id = :post_id LIMIT 1";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute([':post_id' => $post_id]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($post) {
            return new self($post);
        } else {
            return null; // Return null if the post doesn't exist
        }
    }
}
