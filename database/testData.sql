-- Password for users is password123

INSERT INTO users (username, email, password, logged_in, is_admin, about_me) VALUES
('JohnDoe', 'johndoe@example.com', '$2y$10$RqJGAsRXGNdAJws8JshlwOWxr9ckkH.MMd1uzW7D0hStsEqPE9ZHC', TRUE, FALSE, 'Just a regular Joe.'),
('JaneDoe', 'janedoe@example.com', '$2y$10$ZVTK4qIikkzLWXhnjkBySeuQ2q/GuceExqRaBe8kuss4YdxkNm0Wi', FALSE, FALSE, 'Photography enthusiast.'),
('AdminUser', 'admin@example.com', 'adminpass', TRUE, TRUE, 'The boss.');

INSERT INTO posts (title, body, user_id, visible) VALUES
('First Post', 'This is the first post.', 1, TRUE),
('Second Post', 'This is the second post.', 2, TRUE),
('Hidden Post', 'This post is not visible.', 1, FALSE);

INSERT INTO comments (body, user_id, post_id, visible) VALUES
('Great post!', 2, 1, TRUE),
('Thank you!', 1, 1, TRUE),
('Interesting take.', 3, 2, TRUE);

INSERT INTO follows (following_user_id, followed_user_id) VALUES
(1, 2),
(2, 1),
(3, 1);

INSERT INTO vote (user_id, post_id, vote) VALUES
(1, 2, 1),
(2, 1, -1),
(3, 1, 1);
