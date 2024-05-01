CREATE TABLE User           (uid INTEGER PRIMARY KEY, 
                            username VARCHAR(1000) NOT NULL UNIQUE, 
                            password VARCHAR(1000) NOT NULL, 
                            displayName VARCHAR(1000) NOT NULL, 
                            permissionLevel VARCHAR(1000) NOT NULL, 
                            timestamp DATETIME NOT NULL);

CREATE TABLE Badge          (name VARCHAR(255) PRIMARY KEY, 
                            timestamp DATETIME NOT NULL, 
                            uid INTEGER);

CREATE TABLE Likes          (likeID VARCHAR(255) PRIMARY KEY, 
                            timestamp DATETIME NOT NULL);

CREATE TABLE ForumPost      (postID VARCHAR(255) PRIMARY KEY, 
                            title VARCHAR(1000) NOT NULL, 
                            description VARCHAR(1000) NOT NULL, 
                            timestamp DATETIME NOT NULL);

CREATE TABLE Comment        (commentID VARCHAR(255) PRIMARY KEY, 
                            content VARCHAR(1000) NOT NULL, 
                            timestamp DATETIME NOT NULL);

CREATE TABLE Page           (pageID VARCHAR(255) PRIMARY KEY, 
                            title VARCHAR(1000) NOT NULL, 
                            description VARCHAR(1000) NOT NULL, 
                            timestamp DATETIME NOT NULL);

CREATE TABLE ActivityLog    (activityID VARCHAR(255) PRIMARY KEY, 
                            description VARCHAR(1000) NOT NULL, 
                            timestamp DATETIME NOT NULL);

CREATE TABLE Category       (categoryID ENUM('Fertilizer', 'Plant', 'Shop', 'Tool') PRIMARY KEY);

ALTER TABLE User ADD name VARCHAR(255); 
ALTER TABLE User ADD CONSTRAINT FK_Badge FOREIGN KEY (name) REFERENCES Badge (name) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE User ADD commentID VARCHAR(255); 
ALTER TABLE User ADD CONSTRAINT FK_Comment FOREIGN KEY (commentID) REFERENCES Comment (commentID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE User ADD postID VARCHAR(255); 
ALTER TABLE User ADD CONSTRAINT FK_ForumPost FOREIGN KEY (postID) REFERENCES ForumPost (postID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE User ADD likeID VARCHAR(255); 
ALTER TABLE User ADD CONSTRAINT FK_Likes FOREIGN KEY (likeID) REFERENCES Likes (likeID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE User ADD activityID VARCHAR(255); 
ALTER TABLE User ADD CONSTRAINT FK_Log FOREIGN KEY (activityID) REFERENCES ActivityLog (activityID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Comment ADD likeID VARCHAR(255); 
ALTER TABLE Comment ADD CONSTRAINT FK_ComLikes FOREIGN KEY (likeID) REFERENCES Likes (likeID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Comment ADD replyTo VARCHAR(255); 
ALTER TABLE Comment ADD CONSTRAINT FK_ComReply FOREIGN KEY (replyTo) REFERENCES Comment (commentID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE ForumPost ADD likeID VARCHAR(255); 
ALTER TABLE ForumPost ADD CONSTRAINT FK_PostLikes FOREIGN KEY (likeID) REFERENCES Likes (likeID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE ForumPost ADD commentID VARCHAR(255); 
ALTER TABLE ForumPost ADD CONSTRAINT FK_PostComment FOREIGN KEY (commentID) REFERENCES Comment (commentID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Page ADD commentID VARCHAR(255); 
ALTER TABLE Page ADD CONSTRAINT FK_PageComment FOREIGN KEY (commentID) REFERENCES Comment (commentID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Page ADD categoryID ENUM('Fertilizer', 'Plant', 'Shop', 'Tool'); 
ALTER TABLE Page ADD CONSTRAINT FK_PageCategory FOREIGN KEY (categoryID) REFERENCES Category (categoryID) ON DELETE CASCADE ON UPDATE CASCADE;