

CREATE TABLE IF NOT EXISTS users (
  id bigint check (id > 0) NOT NULL DEFAULT NEXTVAL ('users_seq'),
  nit int NOT NULL,
  name varchar(255) NOT NULL,
  last_name varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  email_verified_at timestamp(0) NULL DEFAULT NULL,
  password varchar(255) NOT NULL,
  remember_token varchar(100) DEFAULT NULL,
  created_at timestamp(0) NULL DEFAULT NULL,
  updated_at timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT users_nit_unique UNIQUE (nit),
  CONSTRAINT users_email_unique UNIQUE  (email)
)  ;

INSERT INTO users (id, nit, name, last_name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES
	(1, 1004804515, 'GABRIEL', 'GARCIA', 'GABRIELARTUROGQ@UFPS.EDU.CO', '2022-01-03 14:35:52', '12345', NULL, '2022-01-03 14:35:55', '2022-01-03 14:35:55');
	


--------




CREATE TABLE IF NOT EXISTS failed_jobs (
  id bigint check (id > 0) NOT NULL DEFAULT NEXTVAL ('failed_jobs_seq'),
  uuid varchar(255) NOT NULL,
  connection text NOT NULL,
  queue text NOT NULL,
  payload text NOT NULL,
  exception text NOT NULL,
  failed_at timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid)
)  ;

------


CREATE TABLE IF NOT EXISTS proyectos (
  id bigint check (id > 0) NOT NULL DEFAULT NEXTVAL ('proyectos_seq'),
  name varchar(255) NOT NULL,
  descripcion varchar(255) NOT NULL,
  ubicacion varchar(255) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT proyectos_name_unique UNIQUE  (name)
)  ;

-----

CREATE TABLE IF NOT EXISTS files (
  id bigint check (id > 0) NOT NULL DEFAULT NEXTVAL ('files_seq'),
  name varchar(255) NOT NULL,
  name_drive varchar(255) NOT NULL,
  descripcion varchar(255) NOT NULL,
  file varchar(255) NOT NULL,
  aceptacion varchar(255) NOT NULL,
  proyecto_id bigint check (proyecto_id > 0) NOT NULL,
  created_at timestamp(0) NULL DEFAULT NULL,
  updated_at timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (id)
 ,
  CONSTRAINT files_proyecto_id_foreign FOREIGN KEY (proyecto_id) REFERENCES proyectos (id) ON DELETE CASCADE ON UPDATE CASCADE
)  ;

CREATE INDEX files_proyecto_id_foreign ON files (proyecto_id);



-------



CREATE TABLE IF NOT EXISTS file_users (
  id bigint check (id > 0) NOT NULL DEFAULT NEXTVAL ('file_users_seq'),
  user_nit int NOT NULL,
  file_id bigint check (file_id > 0) NOT NULL,
  date timestamp(0) NOT NULL,
  PRIMARY KEY (id)
 ,
  CONSTRAINT file_users_file_id_foreign FOREIGN KEY (file_id) REFERENCES files (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT file_users_user_nit_foreign FOREIGN KEY (user_nit) REFERENCES users (nit)
)  ;

CREATE INDEX file_users_user_nit_foreign ON file_users (user_nit);
CREATE INDEX file_users_file_id_foreign ON file_users (file_id);


------


CREATE TABLE IF NOT EXISTS jobs (
  id bigint check (id > 0) NOT NULL,
  queue varchar(255) NOT NULL,
  payload text NOT NULL,
  attempts smallint check (attempts > 0) NOT NULL,
  reserved_at int check (reserved_at > 0) DEFAULT NULL,
  available_at int check (available_at > 0) NOT NULL,
  created_at int check (created_at > 0) NOT NULL,
  PRIMARY KEY (id)
)  ;

CREATE INDEX jobs_queue_index ON jobs (queue);




-----



CREATE TABLE IF NOT EXISTS roles (
  id bigint check (id > 0) NOT NULL DEFAULT NEXTVAL ('roles_seq'),
  name varchar(255) NOT NULL,
  guard_name varchar(255) NOT NULL,
  created_at timestamp(0) NULL DEFAULT NULL,
  updated_at timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT roles_name_guard_name_unique UNIQUE  (name,guard_name)
)  ;

INSERT INTO roles (id, name, guard_name, created_at, updated_at) VALUES
	(1, 'Coordinador', 'web', '2022-01-03 19:35:22', '2022-01-03 19:35:22'),
	(2, 'Aux', 'web', '2022-01-03 19:35:22', '2022-01-03 19:35:22'),
	(3, 'Contratista', 'web', '2022-01-03 19:35:22', '2022-01-03 19:35:22');

-----



CREATE TABLE IF NOT EXISTS permissions (
  id bigint check (id > 0) NOT NULL DEFAULT NEXTVAL ('permissions_seq'),
  name varchar(255) NOT NULL,
  guard_name varchar(255) NOT NULL,
  created_at timestamp(0) NULL DEFAULT NULL,
  updated_at timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT permissions_name_guard_name_unique UNIQUE  (name,guard_name)
)  ;


-----


CREATE TABLE IF NOT EXISTS model_has_permissions (
  permission_id bigint check (permission_id > 0) NOT NULL,
  model_type varchar(255) NOT NULL,
  model_id bigint check (model_id > 0) NOT NULL,
  PRIMARY KEY (permission_id,model_id,model_type)
 ,
  CONSTRAINT model_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE
)  ;

CREATE INDEX model_has_permissions_model_id_model_type_index ON model_has_permissions (model_id,model_type);


-------
CREATE TABLE IF NOT EXISTS model_has_roles (
  role_id bigint check (role_id > 0) NOT NULL,
  model_type varchar(255) NOT NULL,
  model_id bigint check (model_id > 0) NOT NULL,
  PRIMARY KEY (role_id,model_id,model_type)
 ,
  CONSTRAINT model_has_roles_role_id_foreign FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE
)  ;

CREATE INDEX model_has_roles_model_id_model_type_index ON model_has_roles (model_id,model_type);


INSERT INTO model_has_roles (role_id, model_type, model_id) VALUES
	(1, 'App\Models\User', 1);



-----------
CREATE TABLE IF NOT EXISTS password_resets (
  email varchar(255) NOT NULL,
  token varchar(255) NOT NULL,
  created_at timestamp(0) NULL DEFAULT NULL
)  ;

CREATE INDEX password_resets_email_index ON password_resets (email);




----
CREATE TABLE IF NOT EXISTS proyecto_users (
  id bigint check (id > 0) NOT NULL DEFAULT NEXTVAL ('proyecto_users_seq'),
  user_nit int NOT NULL,
  proyecto_id bigint check (proyecto_id > 0) NOT NULL,
  PRIMARY KEY (id)
 ,
  CONSTRAINT proyecto_users_proyecto_id_foreign FOREIGN KEY (proyecto_id) REFERENCES proyectos (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT proyecto_users_user_nit_foreign FOREIGN KEY (user_nit) REFERENCES users (nit) ON DELETE CASCADE ON UPDATE CASCADE
)  ;

CREATE INDEX proyecto_users_user_nit_foreign ON proyecto_users (user_nit);
CREATE INDEX proyecto_users_proyecto_id_foreign ON proyecto_users (proyecto_id);




----

CREATE TABLE IF NOT EXISTS role_has_permissions (
  permission_id bigint check (permission_id > 0) NOT NULL,
  role_id bigint check (role_id > 0) NOT NULL,
  PRIMARY KEY (permission_id,role_id)
 ,
  CONSTRAINT role_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE,
  CONSTRAINT role_has_permissions_role_id_foreign FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE
)  ;

CREATE INDEX role_has_permissions_role_id_foreign ON role_has_permissions (role_id);


-------

CREATE TABLE IF NOT EXISTS migrations (
  id int check (id > 0) NOT NULL DEFAULT NEXTVAL ('migrations_seq'),
  migration varchar(255) NOT NULL,
  batch int NOT NULL,
  PRIMARY KEY (id)
)  ;

INSERT INTO migrations (id, migration, batch) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2021_12_01_150407_create_permission_tables', 1),
	(6, '2021_12_15_195915_create_proyectos_table', 1),
	(7, '2021_12_15_200206_create_proyecto_users_table', 1),
	(8, '2021_12_15_200251_create_files_table', 1),
	(9, '2021_12_15_200305_create_file_users_table', 1),
	(10, '2022_01_04_153514_create_jobs_table', 2);
