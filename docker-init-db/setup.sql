-- setup database script
use demo;

-- create all tables 
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS sysuser (
    user_id int NOT null AUTO_INCREMENT,
    first_name varchar(255) NOT NULL,
    last_name  varchar(255),
    email varchar(255) NOT NULL UNIQUE,
    access_token varchar(255) UNIQUE,
    password varchar(32) NOT NULL,
    role  varchar(30) not null default 'editor',
    PRIMARY KEY (user_id)
) ENGINE=InnoDB  CHARSET=utf8 COMMENT='system users';


CREATE TABLE IF NOT EXISTS  post (
    post_id int NOT null AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    content  text,
    status varchar(30) not null default 'draft',-- published, removed
    created_date datetime default CURRENT_TIMESTAMP,
    published_date datetime,
    removed_date datetime,    
    editor_id int not null,
    PRIMARY KEY (post_id),
    CONSTRAINT fk_post_user_id FOREIGN KEY (editor_id) REFERENCES sysuser(user_id)
)ENGINE=InnoDB  CHARSET=utf8 COMMENT='portal posts';


CREATE TABLE IF NOT EXISTS  tag (
    tag_id varchar(150) NOT null ,
    description varchar(255) NOT NULL,
    editor_id int not null,
    PRIMARY KEY (tag_id)
)ENGINE=InnoDB  CHARSET=utf8 COMMENT='portal tags';


CREATE TABLE IF NOT EXISTS   post_tag(
    post_tag_id int NOT null AUTO_INCREMENT,
    tag_id varchar(50) not null,
    post_id int not null,    
    PRIMARY KEY (post_tag_id),
    CONSTRAINT uc_post UNIQUE (tag_id,post_id),
    CONSTRAINT fk_post_tag_tag  FOREIGN KEY (tag_id) REFERENCES tag(tag_id),
    CONSTRAINT fk_post_tag_post FOREIGN KEY (post_id) REFERENCES post(post_id)
)ENGINE=InnoDB  CHARSET=utf8 COMMENT='post tags';

SET FOREIGN_KEY_CHECKS = 1;


-- load data to database
DELIMITER $$

CREATE PROCEDURE loadConfig()
BEGIN
    DECLARE countUsers DECIMAL DEFAULT 0;

    SELECT count(1) 
    INTO countUsers
    FROM sysuser;

    IF countUsers = 0 THEN
        -- admin inserted
        INSERT INTO `sysuser` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role`, `access_token`) VALUES (NULL, 'Admin', 'Administrator', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'admin', '');

        -- inserindo tags
        INSERT INTO tag (tag_id, description, editor_id) values ('sport','sport',1);
        INSERT INTO tag (tag_id, description, editor_id) values ('fun','fun',1);
        INSERT INTO tag (tag_id, description, editor_id) values ('kids','kids',1);

        -- insertindo posts
        INSERT INTO post (title, content, editor_id) values ('title 1', 'content 1', 1);
        INSERT INTO post (title, content, editor_id) values ('title 2', 'content 2', 1);
        INSERT INTO post (title, content, editor_id) values ('title 3', 'content 3', 1);
        INSERT INTO post (title, content, editor_id) values ('title 4', 'content 4', 1);

    END IF;
    
END $$
DELIMITER ;

call loadConfig;

drop  procedure loadConfig;