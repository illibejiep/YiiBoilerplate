drop table if exists auth_item;
drop table if exists auth_item_child;
drop table if exists auth_assignment;
drop table if exists rights;

create table auth_item
(
   name varchar(64) not null,
   type integer not null,
   description text,
   bizrule text,
   data text,
   primary key (name)
);

create table auth_item_child
(
   parent varchar(64) not null,
   child varchar(64) not null,
   primary key (parent,child),
   foreign key (parent) references auth_item (name) on delete cascade on update cascade,
   foreign key (child) references auth_item (name) on delete cascade on update cascade
);

create table auth_assignment
(
   itemname varchar(64) not null,
   userid integer not null,
   bizrule text,
   data text,
   primary key (itemname,userid),
   foreign key (itemname) references auth_item (name) on delete cascade on update cascade
);

create table rights
(
	itemname varchar(64) not null,
	type integer not null,
	weight integer not null,
	primary key (itemname),
	foreign key (itemname) references auth_item (name) on delete cascade on update cascade
);

INSERT INTO auth_item (name, type, description, bizrule, data) VALUES
('Admin', 2, 'Администратор', NULL, 'N;'),
('Authenticated', 2, 'Зарегистрированный пользователь', NULL, 'N;'),
('Guest', 2, 'Гость', NULL, 'N;');

INSERT INTO auth_assignment (itemname, userid, bizrule, data) VALUES
('Admin', '1', NULL, 'N;'), -- цифру 1 нужно заменить на ID администратора (в нашем примере это первый пользователь)
('Authenticated', '2', NULL, 'N;');