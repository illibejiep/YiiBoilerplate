CREATE TABLE "user" (
  id serial PRIMARY KEY,
  username varchar(20) NOT NULL,
  password varchar(128) NOT NULL,
  email varchar(128) NOT NULL,
  activkey varchar(128),
  created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  lastvisit TIMESTAMP ,
  superuser integer NOT NULL DEFAULT 0,
  status integer NOT NULL DEFAULT 1
);

INSERT INTO "user" (username, password, email, activkey, superuser, status )
VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3', 'webmaster@example.com', '21232f297a57a5a743894a0e4a801fc3', 1, 1);
INSERT INTO "user" (username, password, email, activkey, superuser, status )
VALUES ('demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@example.com', 'fe01ce2a7fbac8fafaed7c982a04e229', 0, 1);