create table auth_item
(
   name varchar(64) not null,
   type integer not null,
   description text,
   bizrule text,
   data text,
   primary key (name)
) engine=InnoDB;

create table auth_item_child
(
   parent varchar(64) not null,
   child varchar(64) not null,
   primary key (parent,child),
   foreign key (parent) references auth_item (name) on delete cascade on update cascade,
   foreign key (child) references auth_item (name) on delete cascade on update cascade
) engine=InnoDB;

create table auth_assignment
(
   itemname varchar(64) not null,
   userid integer not null,
   bizrule text,
   data text,
   primary key (itemname,userid),
   foreign key (itemname) references auth_item (name) on delete cascade on update cascade
) engine=InnoDB;

create table rights
(
	itemname varchar(64) not null,
	type integer not null,
	weight integer not null,
	primary key (itemname),
	foreign key (itemname) references auth_item (name) on delete cascade on update cascade
) engine=InnoDB;

INSERT INTO auth_item (name, type, description, bizrule, data) VALUES
('Admin', 2, 'Администратор', NULL, 'N;'),
('Authenticated', 2, 'Зарегистрированный пользователь', NULL, 'N;'),
('Guest', 2, 'Гость', NULL, 'N;');

INSERT INTO auth_assignment (itemname, userid, bizrule, data) VALUES
('Admin', '1', NULL, 'N;'),
('Authenticated', '2', NULL, 'N;');

CREATE TABLE `user` (
  id                   integer auto_increment primary key,
  username             varchar(255)  ,
  password             varchar(128)  ,
  email                varchar(128)  ,
  activkey             varchar(128)  ,
  superuser            integer DEFAULT 0 NOT NULL,
  status               integer DEFAULT 1 NOT NULL,
  firstname            varchar(255)  ,
  lastname             varchar(255)  ,
  created              timestamp DEFAULT current_timestamp NOT NULL,
  lastvisit            timestamp  ,
  city_id              integer  ,
  modified             timestamp
) engine=InnoDB;

INSERT INTO `user` (username, password, email, activkey, superuser, status )
VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3', 'webmaster@example.com', '21232f297a57a5a743894a0e4a801fc3', 1, 1);
INSERT INTO `user` (username, password, email, activkey, superuser, status )
VALUES ('demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@example.com', 'fe01ce2a7fbac8fafaed7c982a04e229', 0, 1);

CREATE TABLE user_oauth (
	id                   integer auto_increment primary key,
	user_id              integer  ,
	service              varchar(255)  ,
	foreign_id           varchar(1023)  ,
	CONSTRAINT user_oauth_service_user_id_uniq UNIQUE ( service, user_id ),
	FOREIGN KEY user_oauth_user_id_fkey ( user_id ) REFERENCES `user`( id ) ON DELETE CASCADE ON UPDATE CASCADE
 ) engine=InnoDB;
CREATE INDEX user_oauth_user_idx ON user_oauth ( user_id );
CREATE INDEX user_oauth_service_idx ON user_oauth ( service );