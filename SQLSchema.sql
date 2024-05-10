CREATE DATABASE main_database;
USE main_database;

CREATE TABLE pageCategories(
    pageCategoryid INT NOT NULL UNIQUE AUTO_INCREMENT,
    pageCategoryName TINYTEXT NOT NULL UNIQUE,
    PRIMARY KEY (pageCategoryid)
);

CREATE TABLE badgeTypes(
    badgeTypeid INT NOT NULL UNIQUE AUTO_INCREMENT,
    badgeTypeName TINYTEXT NOT NULL UNIQUE,
    PRIMARY KEY (badgeTypeid)
);

CREATE TABLE accounts (
    userid INT NOT NULL UNIQUE AUTO_INCREMENT, 
    username TINYTEXT NOT NULL UNIQUE, 
    password TINYTEXT NOT NULL, 
    displayName TINYTEXT DEFAULT '', 
    email TINYTEXT NOT NULL UNIQUE,
    aboutMe MEDIUMTEXT DEFAULT '',
    permissionLevel INT NOT NULL DEFAULT 0,
    create_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(userid)
);

CREATE TABLE pages (
    pageid INT NOT NULL AUTO_INCREMENT,
    title TINYTEXT NOT NULL UNIQUE,
    content LONGTEXT NOT NULL,
    image MEDIUMTEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    pageCategoryid INT DEFAULT 0,
    PRIMARY KEY (pageid),
    FOREIGN KEY (pageCategoryid) REFERENCES pageCategories(pageCategoryid) ON DELETE CASCADE
);

CREATE TABLE forums(
    forumid INT NOT NULL UNIQUE AUTO_INCREMENT,
    title TINYTEXT NOT NULL,
    content TINYTEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    userid INT NOT NULL,
    PRIMARY KEY (forumid),
    FOREIGN KEY (userid) REFERENCES accounts(userid) ON DELETE CASCADE -- reference user
);

CREATE TABLE comments (
    commentid INT NOT NULL UNIQUE AUTO_INCREMENT,
    content TINYTEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    userid INT NOT NULL,
    pageid INT DEFAULT NULL,
    forumid INT DEFAULT NULL,
    wallid INT DEFAULT NULL,
    replyid INT DEFAULT NULL,
    PRIMARY KEY (commentid),
    FOREIGN KEY (userid) REFERENCES accounts(userid) ON DELETE CASCADE, -- reference user
    FOREIGN KEY (pageid) REFERENCES pages(pageid) ON DELETE CASCADE, -- reference page
    FOREIGN KEY (forumid) REFERENCES forums(forumid) ON DELETE CASCADE, -- reference forum post
    FOREIGN KEY (wallid) REFERENCES accounts(userid) ON DELETE CASCADE, -- reference message wall
    FOREIGN KEY (replyid) REFERENCES comments(commentid) ON DELETE CASCADE -- reference comment you are replying to
);

CREATE TABLE likes(
    likeid INT NOT NULL AUTO_INCREMENT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    userid INT NOT NULL,
    commentid INT DEFAULT NULL,
    forumid INT DEFAULT NULL,
    PRIMARY KEY (likeid),
    FOREIGN KEY (userid) REFERENCES accounts(userid) ON DELETE CASCADE, -- the person who "liked"
    FOREIGN KEY (commentid) REFERENCES comments(commentid) ON DELETE CASCADE, -- the comment the "like" goes to
    FOREIGN KEY (forumid) REFERENCES forums(forumid) ON DELETE CASCADE -- the forum the "like" goes to
);

CREATE TABLE dislikes(
    dislikeid INT NOT NULL AUTO_INCREMENT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    userid INT NOT NULL,
    commentid INT DEFAULT NULL,
    forumid INT DEFAULT NULL,
    PRIMARY KEY (dislikeid),
    FOREIGN KEY (userid) REFERENCES accounts(userid) ON DELETE CASCADE, -- the person who "disliked"
    FOREIGN KEY (commentid) REFERENCES comments(commentid) ON DELETE CASCADE, -- the comment the "dislike" goes to
    FOREIGN KEY (forumid) REFERENCES forums(forumid) ON DELETE CASCADE -- the forum the "dislike" goes to
);

CREATE TABLE stars(
    starid INT NOT NULL AUTO_INCREMENT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    userid INT NOT NULL,
    receiverid INT NOT NULL,
    PRIMARY KEY (starid),
    FOREIGN KEY (userid) REFERENCES accounts(userid) ON DELETE CASCADE, -- the person who receives the star
    FOREIGN KEY (receiverid) REFERENCES accounts(userid) ON DELETE CASCADE -- the person who sends the star
);

CREATE TABLE badges (
    badgeid INT NOT NULL AUTO_INCREMENT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    userid INT NOT NULL,
    badgeTypeid INT DEFAULT 0,
    PRIMARY KEY (badgeid),
    FOREIGN KEY (userid) REFERENCES accounts(userid) ON DELETE CASCADE,
    FOREIGN KEY (badgeTypeid) REFERENCES badgeTypes(badgeTypeid) ON DELETE CASCADE
);

CREATE TABLE activities(
    activityid INT NOT NULL UNIQUE AUTO_INCREMENT,
    description TINYTEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    userid INT NOT NULL,
    pageid INT DEFAULT NULL,
    forumid INT DEFAULT NULL,
    wallid INT DEFAULT NULL,
   replyid INT DEFAULT NULL,
    likeid INT DEFAULT NULL,
    dislikeid INT DEFAULT NULL,
    starid INT DEFAULT NULL,
    badgeid INT DEFAULT NULL,
    PRIMARY KEY (activityid),
    FOREIGN KEY (userid) REFERENCES accounts(userid) ON DELETE CASCADE, -- reference user
    FOREIGN KEY (pageid) REFERENCES pages(pageid) ON DELETE CASCADE, -- reference page
    FOREIGN KEY (forumid) REFERENCES forums(forumid) ON DELETE CASCADE, -- reference forum post
    FOREIGN KEY (wallid) REFERENCES accounts(userid) ON DELETE CASCADE, -- reference message wall
    FOREIGN KEY (replyid) REFERENCES comments(commentid) ON DELETE CASCADE, -- reference the comment the action is done on
    FOREIGN KEY (likeid) REFERENCES likes(likeid) ON DELETE CASCADE, -- reference the like the action is done on
    FOREIGN KEY (dislikeid) REFERENCES dislikes(dislikeid) ON DELETE CASCADE, -- reference the like the action is done on
    FOREIGN KEY (starid) REFERENCES stars(starid) ON DELETE CASCADE, -- reference the like the action is done on
    FOREIGN KEY (badgeid) REFERENCES badges(badgeid) ON DELETE CASCADE -- reference the like the action is done on
);

INSERT INTO pageCategories(pageCategoryName) VALUES ("plant");
INSERT INTO pageCategories(pageCategoryName) VALUES ("fertilizer");
INSERT INTO pageCategories(pageCategoryName) VALUES ("tool");
INSERT INTO pageCategories(pageCategoryName) VALUES ("shop");

INSERT INTO badgeTypes(badgeTypeName) VALUES ("First Edit");
INSERT INTO badgeTypes(badgeTypeName) VALUES ("First Comment");
INSERT INTO badgeTypes(badgeTypeName) VALUES ("First Post");
INSERT INTO badgeTypes(badgeTypeName) VALUES ("First Page");
INSERT INTO badgeTypes(badgeTypeName) VALUES ("First Like");
INSERT INTO badgeTypes(badgeTypeName) VALUES ("First Dislike");
INSERT INTO badgeTypes(badgeTypeName) VALUES ("First Star");
INSERT INTO badgeTypes(badgeTypeName) VALUES ("Getting Started"); -- awarded when changing aboutme

INSERT INTO accounts(username, password, email) VALUES ("WaterWiki", "password123!", "WaterWiki@gmail.com");