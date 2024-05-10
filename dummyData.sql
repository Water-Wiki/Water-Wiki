-- Create a stored procedure to generate accounts
DELIMITER //

CREATE PROCEDURE generateAccounts(IN num_accounts INT)
BEGIN
    DECLARE counter INT DEFAULT 0;
    DECLARE username_prefix VARCHAR(255);
    DECLARE email_prefix VARCHAR(255);

    SET username_prefix = 'user';
    SET email_prefix = 'user@example.com';

    WHILE counter < num_accounts DO
        INSERT INTO accounts (username, email, password)
        VALUES (
            CONCAT(username_prefix, counter),
            CONCAT(email_prefix, counter, '@example.com'),
            "password123!"
        );
        SET counter = counter + 1;
    END WHILE;
END//

CREATE PROCEDURE generate_random_pages(IN num_pages INT, IN num_start INT)
BEGIN
    DECLARE counter INT DEFAULT 0;
    DECLARE article_content TEXT;

    WHILE counter < num_pages DO
        SET article_content = '';
        SET counter = counter + 1;
        SET num_start = num_start + 1;
        INSERT INTO pages (title, content, created_at, image, pageCategoryid)
        VALUES (
            CONCAT('Article ', num_start),
            (SELECT GROUP_CONCAT(content SEPARATOR ' ')
             FROM (
                     SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(
                         'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                         ' ',
                         FLOOR(1 + RAND() * 10)
                     ), ' ', -1) AS content
                     FROM information_schema.columns
                     LIMIT 5
             ) AS t
            ),
            CURRENT_TIMESTAMP,
            (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX('images/cactus.png images/fern.png images/flytrap.png images/Plant_List_Image.png images/sunflower.png', ' ', FLOOR(1 + RAND() * 5)), ' ', -1)),
            (SELECT FLOOR(1 + RAND() * (SELECT COUNT(*) FROM pagecategories)))
        );
    END WHILE;
END//

CREATE PROCEDURE generate_random_forums(IN num_forums INT, IN num_start INT)
BEGIN
    DECLARE counter INT DEFAULT 0;
    DECLARE article_content TEXT;

    WHILE counter < num_forums DO
        SET article_content = '';
        SET counter = counter + 1;
        SET num_start = num_start + 1;
        INSERT INTO forums (title, content, created_at, userid)
        VALUES (
            CONCAT('Article ', num_start),
            (SELECT GROUP_CONCAT(content SEPARATOR ' ')
             FROM (
                     SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(
                         'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                         ' ',
                         FLOOR(1 + RAND() * 10)
                     ), ' ', -1) AS content
                     FROM information_schema.columns
                     LIMIT 5
             ) AS t
            ),
            CURRENT_TIMESTAMP,
            (SELECT FLOOR(1 + RAND() * (SELECT COUNT(*) FROM accounts)))
        );
    END WHILE;
END//

CREATE PROCEDURE generate_random_comments(IN num_comments INT)
BEGIN
    DECLARE counter INT DEFAULT 0;
    DECLARE article_content TEXT;

    WHILE counter < num_comments DO
        SET article_content = '';
        SET counter = counter + 1;
        INSERT INTO comments (content, created_at, userid, pageid)
        VALUES (
            (SELECT GROUP_CONCAT(content SEPARATOR ' ')
             FROM (
                     SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(
                         'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                         ' ',
                         FLOOR(1 + RAND() * 10)
                     ), ' ', -1) AS content
                     FROM information_schema.columns
                     LIMIT 5
             ) AS t
            ),
            CURRENT_TIMESTAMP,
            (SELECT FLOOR(1 + RAND() * (SELECT COUNT(*) FROM accounts))),
            (SELECT FLOOR(1 + RAND() * (SELECT COUNT(*) FROM pages)))
        );
    END WHILE;
END//

CREATE PROCEDURE generate_random_fcomments(IN num_comments INT)
BEGIN
    DECLARE counter INT DEFAULT 0;
    DECLARE article_content TEXT;

    WHILE counter < num_comments DO
        SET article_content = '';
        SET counter = counter + 1;
        INSERT INTO comments (content, created_at, userid, forumid)
        VALUES (
            (SELECT GROUP_CONCAT(content SEPARATOR ' ')
             FROM (
                     SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(
                         'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                         ' ',
                         FLOOR(1 + RAND() * 10)
                     ), ' ', -1) AS content
                     FROM information_schema.columns
                     LIMIT 5
             ) AS t
            ),
            CURRENT_TIMESTAMP,
            (SELECT FLOOR(1 + RAND() * (SELECT COUNT(*) FROM accounts))),
            (SELECT FLOOR(1 + RAND() * (SELECT COUNT(*) FROM forums)))
        );
    END WHILE;
END//

CREATE PROCEDURE generate_random_badges(IN num_badges INT)
BEGIN
    DECLARE counter INT DEFAULT 0;

    WHILE counter < num_badges DO
        SET counter = counter + 1;
        INSERT INTO badges (badgeTypeid, created_at, userid)
        VALUES (
            (SELECT FLOOR(1 + RAND() * (SELECT COUNT(*) FROM badgetypes))),
            CURRENT_TIMESTAMP,
            (SELECT FLOOR(1 + RAND() * (SELECT COUNT(*) FROM accounts)))
        );
    END WHILE;
END//

CREATE PROCEDURE generate_random_likes(IN num_likes INT)
BEGIN
    DECLARE counter INT DEFAULT 0;

    WHILE counter < num_likes DO
        SET counter = counter + 1;
        INSERT INTO likes (commentid, created_at, userid)
        VALUES (
            (SELECT FLOOR(1 + RAND() * (SELECT COUNT(*) FROM comments))),
            CURRENT_TIMESTAMP,
            (SELECT FLOOR(1 + RAND() * (SELECT COUNT(*) FROM accounts)))
        );
    END WHILE;
END//

CREATE PROCEDURE generate_random_dislikes(IN num_dislikes INT)
BEGIN
    DECLARE counter INT DEFAULT 0;

    WHILE counter < num_dislikes DO
        SET counter = counter + 1;
        INSERT INTO dislikes (commentid, created_at, userid)
        VALUES (
            (SELECT FLOOR(1 + RAND() * (SELECT COUNT(*) FROM comments))),
            CURRENT_TIMESTAMP,
            (SELECT FLOOR(1 + RAND() * (SELECT COUNT(*) FROM accounts)))
        );
    END WHILE;
END//

CREATE PROCEDURE generate_random_stars(IN num_stars INT)
BEGIN
    DECLARE counter INT DEFAULT 0;

    WHILE counter < num_stars DO
        SET counter = counter + 1;
        INSERT INTO stars (userid, created_at, receiverid)
        VALUES (
            (SELECT FLOOR(1 + RAND() * (SELECT COUNT(*) FROM accounts))),
            CURRENT_TIMESTAMP,
            (SELECT FLOOR(1 + RAND() * (SELECT COUNT(*) FROM accounts)))
        );
    END WHILE;
END//

DELIMITER ;

-- Call the stored procedure to generate accounts
CALL generateAccounts(50);
CALL generate_random_badges(50);
CALL generate_random_pages(50, 0);
CALL generate_random_pages(50, 50);
CALL generate_random_pages(50, 100);
CALL generate_random_pages(50, 150);
CALL generate_random_forums(50, 0);
CALL generate_random_comments(50);
CALL generate_random_comments(50);
CALL generate_random_comments(50);
CALL generate_random_comments(50);
CALL generate_random_comments(50);
CALL generate_random_fcomments(50);
CALL generate_random_fcomments(50);
CALL generate_random_likes(50);
CALL generate_random_likes(50);
CALL generate_random_likes(50);
CALL generate_random_dislikes(50);
CALL generate_random_dislikes(50);
CALL generate_random_stars(50);