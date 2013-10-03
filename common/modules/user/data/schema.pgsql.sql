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

CREATE TABLE profile (
  user_id serial PRIMARY KEY,
  lastname varchar(50),
  firstname varchar(50)
);

CREATE TABLE profile_field (
  id serial PRIMARY KEY,
  varname varchar(50) NOT NULL,
  title varchar(255) NOT NULL,
  field_type varchar(50) NOT NULL,
  field_size integer NOT NULL DEFAULT 0,
  field_size_min integer NOT NULL DEFAULT 0,
  required integer NOT NULL DEFAULT 0,
  match varchar(255) NOT NULL DEFAULT '',
  range varchar(255) NOT NULL DEFAULT '',
  error_message varchar(255) NOT NULL DEFAULT '',
  other_validator TEXT NOT NULL DEFAULT '',
  "default" varchar(255) NOT NULL DEFAULT '',
  widget varchar(255) NOT NULL DEFAULT '',
  widgetparams TEXT NOT NULL DEFAULT '',
  position integer NOT NULL DEFAULT 0,
  visible integer NOT NULL DEFAULT 0
);

INSERT INTO "user" (username, password, email, activkey, superuser, status )
VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3', 'webmaster@example.com', '21232f297a57a5a743894a0e4a801fc3', 1, 1);
INSERT INTO "user" (username, password, email, activkey, superuser, status )
VALUES ('demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@example.com', 'fe01ce2a7fbac8fafaed7c982a04e229', 0, 1);

INSERT INTO profile (lastname, firstname) VALUES
('Admin', 'Administrator'),
('Demo', 'Demo');

INSERT INTO profile_field (varname, title, field_type, field_size, field_size_min, required, match, "range", error_message, other_validator, "default", widget, widgetparams, position, visible) VALUES
('lastname', 'Last Name', 'VARCHAR', 50, 3, 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
('firstname', 'First Name', 'VARCHAR', 50, 3, 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3);