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
            self::$pdo = require 'db.php';
        }
    }

    public static function fetchAll()
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        $users = $stmt->fetchAll();

        $userObjects = [];
        foreach ($users as $user) {
            $userObjects[] = new User($user);
        }

        return $userObjects;
    }

    public static function searchByUsername($username)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("SELECT * FROM users WHERE username LIKE :username");
        $stmt->execute(['username' => '%' . $username . '%']);
        $users = $stmt->fetchAll();

        $userObjects = [];
        foreach ($users as $user) {
            $userObjects[] = new User($user);
        }

        return $userObjects;
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

    public static function setProfilePicture($user_id, $profile_picture)
    {
        self::initPDO();

        $profile_picture_data = file_get_contents($profile_picture);
        if ($profile_picture_data === false) {
            throw new Exception("Could not read profile picture data");
        }

        $stmt = self::$pdo->prepare("UPDATE users SET profile_picture = :profile_picture WHERE user_id = :user_id");
        $stmt->execute([
            'profile_picture' => $profile_picture_data,
            'user_id' => $user_id
        ]);

        if ($stmt->rowCount()) {
            return 1;
        } else {
            return null;
        }
    }

    public static function getProfilePicture($user_id)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("SELECT profile_picture FROM users WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $profile_picture = $stmt->fetchColumn();

        return $profile_picture;
    }

    public static function getFollowing($user_id)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("SELECT * FROM follows WHERE following_user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $followingIds = $stmt->fetchAll();

        $following = [];
        foreach ($followingIds as $followingId) {
            $followed = self::getById($followingId['followed_user_id']);
            $following[] = $followed;
        }

        return $following;
    }

    public static function getFollowers($user_id)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("SELECT * FROM follows WHERE followed_user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $followerIds = $stmt->fetchAll();

        $followers = [];
        foreach ($followerIds as $followerId) {
            $follower = self::getById($followerId['following_user_id']);
            $followers[] = $follower;
        }

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

    public static function setEmail($user_id, $new_email)
    {
        self::initPDO();

        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        $stmt = self::$pdo->prepare("UPDATE users SET email = :new_email WHERE user_id = :user_id");
        $stmt->execute([
            'new_email' => $new_email,
            'user_id' => $user_id
        ]);

        if ($stmt->rowCount()) {
            return 1;
        } else {
            return null;
        }
    }

    public static function setAbout($user_id, $about_me)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("UPDATE users SET about_me = :about_me WHERE user_id = :user_id");
        $stmt->execute([
            'about_me' => $about_me,
            'user_id' => $user_id
        ]);

        if ($stmt->rowCount()) {
            return 1;
        } else {
            return null;
        }
    }

    public static function setPassword($user_id, $new_password)
    {
        self::initPDO();

        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = self::$pdo->prepare("UPDATE users SET password = :new_password WHERE user_id = :user_id");
        $stmt->execute([
            'new_password' => $hashedPassword,
            'user_id' => $user_id
        ]);

        if ($stmt->rowCount()) {
            return 1;
        } else {
            return null;
        }
    }

    public static function isFollowing($user_id, $followed_user_id)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("SELECT * FROM follows WHERE following_user_id = :user_id AND followed_user_id = :followed_user_id");
        $stmt->execute([
            'user_id' => $user_id,
            'followed_user_id' => $followed_user_id
        ]);
        $follow = $stmt->fetch();

        if ($follow) {
            return true;
        } else {
            return false;
        }
    }

    public static function followUser($follower_id, $followed_id)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("INSERT INTO follows (following_user_id, followed_user_id) VALUES (:follower_id, :followed_id)");
        $stmt->execute([
            'follower_id' => $follower_id,
            'followed_id' => $followed_id
        ]);
    }

    public static function unfollowUser($follower_id, $followed_id)
    {
        self::initPDO();

        $stmt = self::$pdo->prepare("DELETE FROM follows WHERE following_user_id = :follower_id AND followed_user_id = :followed_id");
        $stmt->execute([
            'follower_id' => $follower_id,
            'followed_id' => $followed_id
        ]);
    }
}
