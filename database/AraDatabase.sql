-- Drop tables if they exist
DROP TABLE IF EXISTS `follows`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `vote`;
DROP TABLE IF EXISTS `post_img`;

-- Create tables
CREATE TABLE `follows` (
  `following_user_id` integer NOT NULL,
  `followed_user_id` integer NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `users` (
  `user_id` integer PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` longblob,
  `logged_in` bool,
  `is_admin` bool DEFAULT false,
  `about_me` text,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `posts` (
  `post_id` integer PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `user_id` integer NOT NULL,
  `visible` bool DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `comments` (
  `comment_id` integer PRIMARY KEY AUTO_INCREMENT,
  `body` text NOT NULL,
  `user_id` integer NOT NULL,
  `post_id` integer NOT NULL,
  `visible` bool DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp
);

CREATE TABLE `vote` (
  `user_id` integer NOT NULL,
  `post_id` integer NOT NULL,
  `vote` integer
);

CREATE TABLE `post_img` (
  `post_id` integer NOT NULL,
  `img_src` longblob
);

-- Add foreign key constraints
ALTER TABLE `posts` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
ALTER TABLE `follows` ADD FOREIGN KEY (`following_user_id`) REFERENCES `users` (`user_id`);
ALTER TABLE `follows` ADD FOREIGN KEY (`followed_user_id`) REFERENCES `users` (`user_id`);
ALTER TABLE `comments` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
ALTER TABLE `vote` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
ALTER TABLE `vote` ADD FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`);
ALTER TABLE `comments` ADD FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`);
ALTER TABLE `post_img` ADD FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`);
