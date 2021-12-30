-- SQLINES DEMO *** ---------------------------------------
-- SQLINES DEMO ***              127.0.0.1
-- SQLINES DEMO *** idor:         5.7.33 - MySQL Community Server (GPL)
-- SQLINES DEMO ***              Win64
-- SQLINES DEMO *** :             11.2.0.6213
-- SQLINES DEMO *** ---------------------------------------

/* SQLINES DEMO *** ARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/* SQLINES DEMO *** tf8 */;
/* SQLINES DEMO *** tf8mb4 */;
/* SQLINES DEMO *** REIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/* SQLINES DEMO *** L_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/* SQLINES DEMO *** L_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- SQLINES DEMO *** ra para tabla contratista.roles
-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE SEQUENCE roles_seq;

CREATE TABLE IF NOT EXISTS roles (
  id bigint check (id > 0) NOT NULL DEFAULT NEXTVAL ('roles_seq'),
  name varchar(255) NOT NULL,
  guard_name varchar(255) NOT NULL,
  created_at timestamp(0) NULL DEFAULT NULL,
  updated_at timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT roles_name_guard_name_unique UNIQUE  (name,guard_name)
)   ;

ALTER SEQUENCE roles_seq RESTART WITH 4;

-- SQLINES DEMO *** ra la tabla contratista.roles: ~0 rows (aproximadamente)
/* SQLINES DEMO ***  `roles` DISABLE KEYS */;
INSERT INTO roles (id, name, guard_name, created_at, updated_at) VALUES
	(1, 'Coordinador', 'web', '2021-12-29 18:56:39', '2021-12-29 18:56:39'),
	(2, 'Aux', 'web', '2021-12-29 18:56:39', '2021-12-29 18:56:39'),
	(3, 'Contratista', 'web', '2021-12-29 18:56:39', '2021-12-29 18:56:39');
/* SQLINES DEMO ***  `roles` ENABLE KEYS */;

-- SQLINES DEMO *** ra para tabla contratista.role_has_permissions
-- SQLINES LICENSE FOR EVALUATION USE ONLY

-- SQLINES DEMO *** ra para tabla contratista.failed_jobs
-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE SEQUENCE failed_jobs_seq;

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

-- SQLINES DEMO *** ra la tabla contratista.failed_jobs: ~0 rows (aproximadamente)
/* SQLINES DEMO ***  `failed_jobs` DISABLE KEYS */;
/* SQLINES DEMO ***  `failed_jobs` ENABLE KEYS */;

-- SQLINES DEMO *** ra para tabla contratista.files
-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE SEQUENCE files_seq;

CREATE TABLE IF NOT EXISTS files (
  id bigint check (id > 0) NOT NULL DEFAULT NEXTVAL ('files_seq'),
  name varchar(255) NOT NULL,
  descripcion varchar(255) NOT NULL,
  file varchar(255) NOT NULL,
  aceptacion varchar(255) NOT NULL,
  created_at timestamp(0) NULL DEFAULT NULL,
  updated_at timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (id)
)   ;

ALTER SEQUENCE files_seq RESTART WITH 16;

-- SQLINES DEMO *** ra la tabla contratista.files: ~6 rows (aproximadamente)
/* SQLINES DEMO ***  `files` DISABLE KEYS */;
INSERT INTO files (id, name, descripcion, file, aceptacion, created_at, updated_at) VALUES
	(9, 'data', 'holaaaa', 'https://drive.google.com/uc?id=1eoekee9psvDnoGwcyfDvrUGg0Gvtszpe&export=media', '0', '2021-12-29 21:11:22', '2021-12-29 21:11:22'),
	(10, 'data', 'holaaaa', 'https://drive.google.com/uc?id=14_HZLH9jZkYezso8krviT14l06h7m7sd&export=media', '0', '2021-12-29 21:11:28', '2021-12-29 21:11:28'),
	(11, 'data', 'holaaaa', 'https://drive.google.com/uc?id=1ql-bVzEQKK7sdSbSHO8y-Kej95MWozl_&export=media', '0', '2021-12-29 21:11:55', '2021-12-29 21:11:55'),
	(12, 'data', 'holaaaa', 'https://drive.google.com/uc?id=14vb4M7blnXbl9eeL8LcVkKSELDwh-ftY&export=media', '0', '2021-12-29 21:12:03', '2021-12-29 21:12:03'),
	(13, 'data', 'holaaaa', 'https://drive.google.com/uc?id=1HRF_VepgGGCEQF2U-u05rBTmUff2M-wh&export=media', '0', '2021-12-29 21:12:08', '2021-12-29 21:12:08'),
	(15, 'data', 'holaaaa', 'https://drive.google.com/uc?id=1JaKRaoeUqtn_pGZoV8Ek0-JxrSGUOAbY&export=media', '0', '2021-12-29 22:18:35', '2021-12-29 22:18:35');
/* SQLINES DEMO ***  `files` ENABLE KEYS */;

-- SQLINES DEMO *** ra para tabla contratista.file_users
-- SQLINES LICENSE FOR EVALUATION USE ONLY

-----

-- SQLINES DEMO *** ra para tabla contratista.users
-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE SEQUENCE users_seq;

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
)   ;

ALTER SEQUENCE users_seq RESTART WITH 5;

-- SQLINES DEMO *** ra la tabla contratista.users: ~0 rows (aproximadamente)
/* SQLINES DEMO ***  `users` DISABLE KEYS */;
INSERT INTO users (id, nit, name, last_name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES
	(1, 1004804515, 'GABRIEL', 'GARCIA', 'GABRIELARTUROGQ@UFPS.EDU.CO', '2021-12-29 13:55:53', '$2y$10$gwJyiolLGrD/NQScrtO45OfjOtAIGG6ZdF5YJADQ29bpUv20EO/Em', 'DNj1rqMSBuOanVsWjF1TLyJLunjodCH7uPq2Ek1NpfSMQpN5Z6qdTGG87bkH', '2021-12-29 13:55:55', '2021-12-30 20:51:41'),
	(2, 1, 'ARTUR', 'QUINTERO', 'arturo@gmaila.com', '2021-12-30 08:05:30', '$2y$10$Z2bK.NZzx/iyo.UEAewpneKhrLM7rAg.59giFZkQP4YwK1vj4HwD.', NULL, '2021-12-29 19:00:11', '2021-12-29 19:01:06'),
	(3, 1151654, 'LUIS', 'PEDRAZA', 'l@g.com', '2021-12-30 08:05:31', '$2y$10$lPr1p345f5VmePze8I6XzelUCMSr1Qc5s1YK3QGL1OzDfCHIPURzi', NULL, '2021-12-29 19:25:24', '2021-12-29 19:25:24'),
	(4, 13, 'DAVID', 'VALENCIA', 'g@mm.com', '2021-12-30 08:05:32', '$2y$10$yaAQ2ELS/ZRTRd7tZeT2s.iWvaO4nMuoSvuMPWg0XiUTaeFe9yADq', NULL, '2021-12-29 22:16:30', '2021-12-29 22:16:30');
/* SQLINES DEMO ***  `users` ENABLE KEYS */;


-----
CREATE SEQUENCE file_users_seq;

CREATE TABLE IF NOT EXISTS file_users (
  id bigint check (id > 0) NOT NULL DEFAULT NEXTVAL ('file_users_seq'),
  user_nit int NOT NULL,
  file_id bigint check (file_id > 0) NOT NULL,
  date timestamp(0) NOT NULL,
  PRIMARY KEY (id)
 ,
  CONSTRAINT file_users_file_id_foreign FOREIGN KEY (file_id) REFERENCES files (id),
  CONSTRAINT file_users_user_nit_foreign FOREIGN KEY (user_nit) REFERENCES users (nit)
)   ;

ALTER SEQUENCE file_users_seq RESTART WITH 10;

-- SQLINES DEMO *** ra la tabla contratista.file_users: ~6 rows (aproximadamente)
/* SQLINES DEMO ***  `file_users` DISABLE KEYS */;

CREATE INDEX file_users_user_nit_foreign ON file_users (user_nit);
CREATE INDEX file_users_file_id_foreign ON file_users (file_id);
INSERT INTO file_users (id, user_nit, file_id, date) VALUES
	(3, 1, 9, '2021-12-29 21:11:22'),
	(4, 1, 10, '2021-12-29 21:11:28'),
	(5, 1, 11, '2021-12-29 21:11:55'),
	(6, 1, 12, '2021-12-29 21:12:03'),
	(7, 1, 13, '2021-12-29 21:12:08'),
	(9, 13, 15, '2021-12-29 22:18:35');
/* SQLINES DEMO ***  `file_users` ENABLE KEYS */;

-- SQLINES DEMO *** ra para tabla contratista.migrations
-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE SEQUENCE migrations_seq;

CREATE TABLE IF NOT EXISTS migrations (
  id int check (id > 0) NOT NULL DEFAULT NEXTVAL ('migrations_seq'),
  migration varchar(255) NOT NULL,
  batch int NOT NULL,
  PRIMARY KEY (id)
)   ;

ALTER SEQUENCE migrations_seq RESTART WITH 10;

-- SQLINES DEMO *** ra la tabla contratista.migrations: ~9 rows (aproximadamente)
/* SQLINES DEMO ***  `migrations` DISABLE KEYS */;
INSERT INTO migrations (id, migration, batch) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2021_12_01_150407_create_permission_tables', 1),
	(6, '2021_12_15_195915_create_proyectos_table', 1),
	(7, '2021_12_15_200206_create_proyecto_users_table', 1),
	(8, '2021_12_15_200251_create_files_table', 1),
	(9, '2021_12_15_200305_create_file_users_table', 1);
/* SQLINES DEMO ***  `migrations` ENABLE KEYS */;


-- SQLINES DEMO *** ra para tabla contratista.model_has_roles
-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE IF NOT EXISTS model_has_roles (
  role_id bigint check (role_id > 0) NOT NULL,
  model_type varchar(255) NOT NULL,
  model_id bigint check (model_id > 0) NOT NULL,
  PRIMARY KEY (role_id,model_id,model_type)
 ,
  CONSTRAINT model_has_roles_role_id_foreign FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE
)  ;

CREATE INDEX model_has_roles_model_id_model_type_index ON model_has_roles (model_id,model_type);

-- SQLINES DEMO *** ra la tabla contratista.model_has_roles: ~4 rows (aproximadamente)
/* SQLINES DEMO ***  `model_has_roles` DISABLE KEYS */;
INSERT INTO model_has_roles (role_id, model_type, model_id) VALUES
	(1, 'AppModelsUser', 1),
	(3, 'AppModelsUser', 2),
	(3, 'AppModelsUser', 3),
	(2, 'AppModelsUser', 4);
/* SQLINES DEMO ***  `model_has_roles` ENABLE KEYS */;

-- SQLINES DEMO *** ra para tabla contratista.password_resets
-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE TABLE IF NOT EXISTS password_resets (
  email varchar(255) NOT NULL,
  token varchar(255) NOT NULL,
  created_at timestamp(0) NULL DEFAULT NULL
)  ;

CREATE INDEX password_resets_email_index ON password_resets (email);

-- SQLINES DEMO *** ra la tabla contratista.password_resets: ~0 rows (aproximadamente)
/* SQLINES DEMO ***  `password_resets` DISABLE KEYS */;
/* SQLINES DEMO ***  `password_resets` ENABLE KEYS */;

-- SQLINES DEMO *** ra para tabla contratista.permissions
-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE SEQUENCE permissions_seq;

CREATE TABLE IF NOT EXISTS permissions (
  id bigint check (id > 0) NOT NULL DEFAULT NEXTVAL ('permissions_seq'),
  name varchar(255) NOT NULL,
  guard_name varchar(255) NOT NULL,
  created_at timestamp(0) NULL DEFAULT NULL,
  updated_at timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT permissions_name_guard_name_unique UNIQUE  (name,guard_name)
)  ;

-- SQLINES DEMO *** ra la tabla contratista.permissions: ~0 rows (aproximadamente)
/* SQLINES DEMO ***  `permissions` DISABLE KEYS */;
/* SQLINES DEMO ***  `permissions` ENABLE KEYS */;

-- SQLINES DEMO *** ra para tabla contratista.proyectos
-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE SEQUENCE proyectos_seq;

CREATE TABLE IF NOT EXISTS proyectos (
  id bigint check (id > 0) NOT NULL DEFAULT NEXTVAL ('proyectos_seq'),
  name varchar(255) NOT NULL,
  descripcion varchar(255) NOT NULL,
  ubicacion varchar(255) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT proyectos_name_unique UNIQUE  (name)
)   ;

ALTER SEQUENCE proyectos_seq RESTART WITH 4;

-- SQLINES DEMO *** ra la tabla contratista.proyectos: ~3 rows (aproximadamente)
/* SQLINES DEMO ***  `proyectos` DISABLE KEYS */;
INSERT INTO proyectos (id, name, descripcion, ubicacion) VALUES
	(1, 'NATURA', 'proyecto 1', 'calle'),
	(2, 'RESUMEN', 'proyecto 2', 'calle'),
	(3, 'TERRAVIVA', 'proyecto 3', 'calle');
/* SQLINES DEMO ***  `proyectos` ENABLE KEYS */;

-- SQLINES DEMO *** ra para tabla contratista.proyecto_users
-- SQLINES LICENSE FOR EVALUATION USE ONLY
CREATE SEQUENCE proyecto_users_seq;

CREATE TABLE IF NOT EXISTS proyecto_users (
  id bigint check (id > 0) NOT NULL DEFAULT NEXTVAL ('proyecto_users_seq'),
  user_nit int NOT NULL,
  proyecto_id bigint check (proyecto_id > 0) NOT NULL,
  PRIMARY KEY (id)
 ,
  CONSTRAINT proyecto_users_proyecto_id_foreign FOREIGN KEY (proyecto_id) REFERENCES proyectos (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT proyecto_users_user_nit_foreign FOREIGN KEY (user_nit) REFERENCES users (nit) ON DELETE CASCADE ON UPDATE CASCADE
)   ;

ALTER SEQUENCE proyecto_users_seq RESTART WITH 11;

-- SQLINES DEMO *** ra la tabla contratista.proyecto_users: ~0 rows (aproximadamente)
/* SQLINES DEMO ***  `proyecto_users` DISABLE KEYS */;

CREATE INDEX proyecto_users_user_nit_foreign ON proyecto_users (user_nit);
CREATE INDEX proyecto_users_proyecto_id_foreign ON proyecto_users (proyecto_id);
INSERT INTO proyecto_users (id, user_nit, proyecto_id) VALUES
	(3, 13, 2),
	(5, 1, 2),
	(7, 1151654, 2),
	(9, 1151654, 1),
	(10, 1151654, 3);
/* SQLINES DEMO ***  `proyecto_users` ENABLE KEYS */;


CREATE TABLE IF NOT EXISTS role_has_permissions (
  permission_id bigint check (permission_id > 0) NOT NULL,
  role_id bigint check (role_id > 0) NOT NULL,
  PRIMARY KEY (permission_id,role_id)
 ,
  CONSTRAINT role_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES permissions (id) ON DELETE CASCADE,
  CONSTRAINT role_has_permissions_role_id_foreign FOREIGN KEY (role_id) REFERENCES roles (id) ON DELETE CASCADE
)  ;

CREATE INDEX role_has_permissions_role_id_foreign ON role_has_permissions (role_id);

-- SQLINES DEMO *** ra la tabla contratista.role_has_permissions: ~0 rows (aproximadamente)
/* SQLINES DEMO ***  `role_has_permissions` DISABLE KEYS */;
/* SQLINES DEMO ***  `role_has_permissions` ENABLE KEYS */;



/* SQLINES DEMO *** E=IFNULL(@OLD_SQL_MODE, '') */;
/* SQLINES DEMO *** _KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/* SQLINES DEMO *** ER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/* SQLINES DEMO *** ES=IFNULL(@OLD_SQL_NOTES, 1) */;