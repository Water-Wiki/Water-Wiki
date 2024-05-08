CREATE TABLE Account        (uid INTEGER AUTO_INCREMENT PRIMARY KEY, 
                            username VARCHAR(1000) NOT NULL UNIQUE, 
                            password VARCHAR(1000) NOT NULL, 
                            displayName VARCHAR(1000) NOT NULL, 
                            email VARCHAR(1000) NOT NULL,
                            permissionLevel INTEGER DEFAULT 0, 
                            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP);

CREATE TABLE Badge          (name VARCHAR(255) PRIMARY KEY, 
                            timestamp DATETIME NOT NULL, 
                            uid INTEGER);

CREATE TABLE Likes          (likeID INTEGER AUTO_INCREMENT PRIMARY KEY, 
                            timestamp DATETIME NOT NULL);

CREATE TABLE ForumPost      (postID INTEGER AUTO_INCREMENT PRIMARY KEY, 
                            title VARCHAR(1000) NOT NULL, 
                            description VARCHAR(1000) NOT NULL, 
                            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP);

CREATE TABLE PageComment        (commentID INTEGER AUTO_INCREMENT PRIMARY KEY, 
                            content VARCHAR(1000) NOT NULL, 
                            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP);

CREATE TABLE Page           (pageID INTEGER AUTO_INCREMENT PRIMARY KEY, 
                            title VARCHAR(1000) NOT NULL, 
                            description VARCHAR(1000) NOT NULL, 
                            image VARCHAR(1000) NOT NULL,
                            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP);

CREATE TABLE ActivityLog    (activityID INTEGER AUTO_INCREMENT PRIMARY KEY, 
                            description VARCHAR(1000) NOT NULL, 
                            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP);

CREATE TABLE Category       (categoryID ENUM('Fertilizer', 'Plant', 'Shop', 'Tool') PRIMARY KEY);

ALTER TABLE User ADD name VARCHAR(255); 
ALTER TABLE User ADD CONSTRAINT FK_Badge FOREIGN KEY (name) REFERENCES Badge (name) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE PageComment ADD uid INTEGER; 
ALTER TABLE PageComment ADD CONSTRAINT FK_Comment_User FOREIGN KEY (uid) REFERENCES Account (uid) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE PageComment ADD pageID INTEGER; 
ALTER TABLE PageComment ADD CONSTRAINT FK_Comment_Page FOREIGN KEY (uid) REFERENCES Page (pageID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Post ADD uid INTEGER; 
ALTER TABLE Post ADD CONSTRAINT FK_ForumPost FOREIGN KEY (uid) REFERENCES Account (uid) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Likes ADD uid INTEGER; 
ALTER TABLE Likes ADD CONSTRAINT FK_Likes FOREIGN KEY (uid) REFERENCES Account (uid) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE ActivityLog ADD uid INTEGER; 
ALTER TABLE ActivityLog ADD CONSTRAINT FK_Log FOREIGN KEY (uid) REFERENCES Account (uid) ON DELETE CASCADE ON UPDATE CASCADE;

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