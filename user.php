<?php
class User
{
    public $user_id;
    public $username;
    public $email;
    public $password;
    public $profile_picture;
    public $is_admin;
    public $is_banned;
    public $about_me;
    private static $pdo;

    private static function initPDO()
    {
        if (self::$pdo === null) {
            self::$pdo = require_once 'db.php';
        }
    }

    private function __construct($entry)
    {
        $this->user_id = $entry['user_id'];
        $this->username = $entry['username'];
        $this->email = $entry['email'];
        $this->password = $entry['password'];
        $this->profile_picture = $entry['profile_picture'];
        $this->is_admin = $entry['is_admin'];
        $this->is_banned = $entry['is_banned'];
        $this->about_me = $entry['about_me'];
    }

    public static function getByEmail($email)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user) {
            return null;
        }

        return new User($user);
    }

    public static function getByUsername($username)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if (!$user) {
            return null;
        }

        return new User($user);
    }

    public static function getById($user_id)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("SELECT * FROM users WHERE user_id = :user_id LIMIT 1");
        $stmt->execute(['user_id' => $user_id]);
        $user = $stmt->fetch();

        if (!$user) {
            return null;
        }

        return new User($user);
    }

    public static function insertUser($username, $email, $password, $admin_bool)
    {
        self::initPDO();

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = self::$pdo->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (:username, :email, :password, :is_admin)");
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'is_admin' => $admin_bool
        ]);
    }

    public static function setProfilePicture($user_id, $profile_picture_path)
    {
        self::initPDO();

        $profile_picture_data = file_get_contents($profile_picture_path);
        if ($profile_picture_data === false) {
            throw new Exception("Could not read profile picture data");
        }

        $stmt = self::$pdo->prepare("UPDATE users SET profile_picture = :profile_picture WHERE user_id = :user_id");
        $stmt->execute([
            'profile_picture' => $profile_picture_data,
            'user_id' => $user_id
        ]);
    }

    public static function getFollowers($user_id)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("SELECT * FROM follow WHERE followed_user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $followers = $stmt->fetchAll();

        return $followers;
    }

    public static function getFollowerCount($user_id)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("SELECT COUNT(*) FROM follows WHERE followed_user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $followerCount = $stmt->fetchColumn();

        return $followerCount;
    }

    public static function getFollowingCount($user_id)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("SELECT COUNT(*) FROM follows WHERE following_user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $followingCount = $stmt->fetchColumn();

        return $followingCount;
    }
}
