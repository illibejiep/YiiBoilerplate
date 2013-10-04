CREATE TABLE 'user' (
  id INTEGER NOT NULL  PRIMARY KEY AUTOINCREMENT,
  username varchar(20) NOT NULL,
  password varchar(128) NOT NULL,
  email varchar(128) NOT NULL,
  activkey varchar(128) NOT NULL DEFAULT '',
  created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  lastvisit TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  superuser int(1) NOT NULL DEFAULT '0',
  status int(1) NOT NULL DEFAULT '0'
);

INSERT INTO 'user' (id, username, password, email, activkey, superuser, status) VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'webmaster@example.com', '21232f297a57a5a743894a0e4a801fc3', 1, 1);
INSERT INTO 'user' (id, username, password, email, activkey, superuser, status) VALUES (2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@example.com', 'fe01ce2a7fbac8fafaed7c982a04e229', 0, 1);
