-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.33 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para contratista
CREATE DATABASE IF NOT EXISTS `contratista` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;
USE `contratista`;

-- Volcando estructura para tabla contratista.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla contratista.failed_jobs: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Volcando estructura para tabla contratista.files
CREATE TABLE IF NOT EXISTS `files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aceptacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla contratista.files: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` (`id`, `name`, `descripcion`, `file`, `aceptacion`, `created_at`, `updated_at`) VALUES
	(9, 'data', 'holaaaa', 'https://drive.google.com/uc?id=1eoekee9psvDnoGwcyfDvrUGg0Gvtszpe&export=media', '0', '2021-12-29 21:11:22', '2021-12-29 21:11:22'),
	(10, 'data', 'holaaaa', 'https://drive.google.com/uc?id=14_HZLH9jZkYezso8krviT14l06h7m7sd&export=media', '0', '2021-12-29 21:11:28', '2021-12-29 21:11:28'),
	(11, 'data', 'holaaaa', 'https://drive.google.com/uc?id=1ql-bVzEQKK7sdSbSHO8y-Kej95MWozl_&export=media', '0', '2021-12-29 21:11:55', '2021-12-29 21:11:55'),
	(12, 'data', 'holaaaa', 'https://drive.google.com/uc?id=14vb4M7blnXbl9eeL8LcVkKSELDwh-ftY&export=media', '0', '2021-12-29 21:12:03', '2021-12-29 21:12:03'),
	(13, 'data', 'holaaaa', 'https://drive.google.com/uc?id=1HRF_VepgGGCEQF2U-u05rBTmUff2M-wh&export=media', '0', '2021-12-29 21:12:08', '2021-12-29 21:12:08'),
	(15, 'data', 'holaaaa', 'https://drive.google.com/uc?id=1JaKRaoeUqtn_pGZoV8Ek0-JxrSGUOAbY&export=media', '0', '2021-12-29 22:18:35', '2021-12-29 22:18:35');
/*!40000 ALTER TABLE `files` ENABLE KEYS */;

-- Volcando estructura para tabla contratista.file_users
CREATE TABLE IF NOT EXISTS `file_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_nit` int(11) NOT NULL,
  `file_id` bigint(20) unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `file_users_user_nit_foreign` (`user_nit`),
  KEY `file_users_file_id_foreign` (`file_id`),
  CONSTRAINT `file_users_file_id_foreign` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`),
  CONSTRAINT `file_users_user_nit_foreign` FOREIGN KEY (`user_nit`) REFERENCES `users` (`nit`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla contratista.file_users: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `file_users` DISABLE KEYS */;
INSERT INTO `file_users` (`id`, `user_nit`, `file_id`, `date`) VALUES
	(3, 1, 9, '2021-12-29 21:11:22'),
	(4, 1, 10, '2021-12-29 21:11:28'),
	(5, 1, 11, '2021-12-29 21:11:55'),
	(6, 1, 12, '2021-12-29 21:12:03'),
	(7, 1, 13, '2021-12-29 21:12:08'),
	(9, 13, 15, '2021-12-29 22:18:35');
/*!40000 ALTER TABLE `file_users` ENABLE KEYS */;

-- Volcando estructura para tabla contratista.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla contratista.migrations: ~9 rows (aproximadamente)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2021_12_01_150407_create_permission_tables', 1),
	(6, '2021_12_15_195915_create_proyectos_table', 1),
	(7, '2021_12_15_200206_create_proyecto_users_table', 1),
	(8, '2021_12_15_200251_create_files_table', 1),
	(9, '2021_12_15_200305_create_file_users_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Volcando estructura para tabla contratista.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla contratista.model_has_permissions: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;

-- Volcando estructura para tabla contratista.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla contratista.model_has_roles: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(3, 'App\\Models\\User', 2),
	(2, 'App\\Models\\User', 3),
	(3, 'App\\Models\\User', 4);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;

-- Volcando estructura para tabla contratista.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla contratista.password_resets: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Volcando estructura para tabla contratista.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla contratista.permissions: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Volcando estructura para tabla contratista.proyectos
CREATE TABLE IF NOT EXISTS `proyectos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ubicacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `proyectos_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla contratista.proyectos: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT INTO `proyectos` (`id`, `name`, `descripcion`, `ubicacion`) VALUES
	(1, 'NATURA', 'proyecto 1', 'calle'),
	(2, 'RESUMEN', 'proyecto 2', 'calle'),
	(3, 'TERRAVIVA', 'proyecto 3', 'calle');
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;

-- Volcando estructura para tabla contratista.proyecto_users
CREATE TABLE IF NOT EXISTS `proyecto_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_nit` int(11) NOT NULL,
  `proyecto_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `proyecto_users_user_nit_foreign` (`user_nit`),
  KEY `proyecto_users_proyecto_id_foreign` (`proyecto_id`),
  CONSTRAINT `proyecto_users_proyecto_id_foreign` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `proyecto_users_user_nit_foreign` FOREIGN KEY (`user_nit`) REFERENCES `users` (`nit`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla contratista.proyecto_users: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `proyecto_users` DISABLE KEYS */;
INSERT INTO `proyecto_users` (`id`, `user_nit`, `proyecto_id`) VALUES
	(1, 1, 1),
	(2, 1151654, 1),
	(3, 13, 2);
/*!40000 ALTER TABLE `proyecto_users` ENABLE KEYS */;

-- Volcando estructura para tabla contratista.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla contratista.roles: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Coordinador', 'web', '2021-12-29 18:56:39', '2021-12-29 18:56:39'),
	(2, 'Aux', 'web', '2021-12-29 18:56:39', '2021-12-29 18:56:39'),
	(3, 'Contratista', 'web', '2021-12-29 18:56:39', '2021-12-29 18:56:39');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Volcando estructura para tabla contratista.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla contratista.role_has_permissions: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;

-- Volcando estructura para tabla contratista.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nit` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_nit_unique` (`nit`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla contratista.users: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `nit`, `name`, `last_name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 1004804515, 'GABRIEL', 'GARCIA', 'GABRIELARTUROGQ@UFPS.EDU.CO', '2021-12-29 13:55:53', '12345', NULL, '2021-12-29 13:55:55', '2021-12-29 13:55:55'),
	(2, 1, 'ARTUR', 'QUINTERO', 'arturo@gmaila.com', NULL, '$2y$10$Z2bK.NZzx/iyo.UEAewpneKhrLM7rAg.59giFZkQP4YwK1vj4HwD.', NULL, '2021-12-29 19:00:11', '2021-12-29 19:01:06'),
	(3, 1151654, 'LUIS', 'PEDRAZA', 'l@g.com', NULL, '$2y$10$lPr1p345f5VmePze8I6XzelUCMSr1Qc5s1YK3QGL1OzDfCHIPURzi', NULL, '2021-12-29 19:25:24', '2021-12-29 19:25:24'),
	(4, 13, 'DAVID', 'VALENCIA', 'g@mm.com', NULL, '$2y$10$yaAQ2ELS/ZRTRd7tZeT2s.iWvaO4nMuoSvuMPWg0XiUTaeFe9yADq', NULL, '2021-12-29 22:16:30', '2021-12-29 22:16:30');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
