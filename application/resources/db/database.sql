-- TODO: DEPRECATED

CREATE TABLE sysuser (
    user_id int NOT null AUTO_INCREMENT,
    first_name varchar(255) NOT NULL,
    last_name  varchar(255),
    email varchar(255) NOT NULL UNIQUE,
    access_token varchar(255) UNIQUE,
    password varchar(32) NOT NULL,
    role  varchar(30) not null default 'editor',
    PRIMARY KEY (sysuser_id)
);

CREATE TABLE post (
    post_id int NOT null AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    content  text,
    status varchar(30) not null default 'draft',-- published, removed
    created_date datetime default CURRENT_TIMESTAMP,
    published_date datetime,
    removed_date datetime,    
    editor_id int not null,
    PRIMARY KEY (post_id)
);

ALTER TABLE post ADD FOREIGN KEY (editor_id) REFERENCES sysuser(user_id);


CREATE TABLE tag (
    tag_id varchar(150) NOT null ,
    description varchar(255) NOT NULL,
    editor_id int not null,
    PRIMARY KEY (tag_id)
);

ALTER TABLE post ADD FOREIGN KEY (editor_id) REFERENCES sysuser(user_id);

create table post_tag(
    post_tag_id int NOT null AUTO_INCREMENT,
    tag_id varchar(50) not null,
    post_id int not null,    
    PRIMARY KEY (post_tag_id)
);

ALTER TABLE post_tag ADD CONSTRAINT uc_post UNIQUE (tag_id,post_id);

ALTER TABLE post_tag ADD FOREIGN KEY (tag_id) REFERENCES tag(tag_id);

ALTER TABLE post_tag ADD FOREIGN KEY (post_id) REFERENCES post(post_id);

-- carregando usuário administrador
INSERT INTO `sysuser` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role`, `access_token`) VALUES (NULL, 'Admin', 'Administrator', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 'admin', '');