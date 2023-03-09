/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `access_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hub_id` char(36) DEFAULT NULL,
  `user_id` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `access_logs_hub_id_foreign` (`hub_id`),
  KEY `access_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `access_logs_hub_id_foreign` FOREIGN KEY (`hub_id`) REFERENCES `hub` (`id`),
  CONSTRAINT `access_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `club_threads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `club_threads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hub_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `message_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `club_threads_hub_id_foreign` (`hub_id`),
  KEY `club_threads_user_id_foreign` (`user_id`),
  CONSTRAINT `club_threads_hub_id_foreign` FOREIGN KEY (`hub_id`) REFERENCES `hub` (`id`),
  CONSTRAINT `club_threads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `college_year_threads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `college_year_threads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hub_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `message_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `college_year_threads_hub_id_foreign` (`hub_id`),
  KEY `college_year_threads_user_id_foreign` (`user_id`),
  CONSTRAINT `college_year_threads_hub_id_foreign` FOREIGN KEY (`hub_id`) REFERENCES `hub` (`id`),
  CONSTRAINT `college_year_threads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `contact_administrators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_administrators` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `contact_type_id` bigint(20) unsigned NOT NULL,
  `user_id` char(36) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_administrators_user_id_foreign` (`user_id`),
  KEY `contact_administrators_contact_type_id_foreign` (`contact_type_id`),
  CONSTRAINT `contact_administrators_contact_type_id_foreign` FOREIGN KEY (`contact_type_id`) REFERENCES `contact_types` (`id`),
  CONSTRAINT `contact_administrators_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `contact_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contact_types_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `department_threads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department_threads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hub_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `message_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `department_threads_hub_id_foreign` (`hub_id`),
  KEY `department_threads_user_id_foreign` (`user_id`),
  CONSTRAINT `department_threads_hub_id_foreign` FOREIGN KEY (`hub_id`) REFERENCES `hub` (`id`),
  CONSTRAINT `department_threads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `hub`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hub` (
  `id` char(36) NOT NULL COMMENT '(DC2Type:guid)',
  `thread_secondary_category_id` bigint(20) unsigned NOT NULL,
  `user_id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hub_user_id_foreign` (`user_id`),
  KEY `hub_thread_secondary_category_id_foreign` (`thread_secondary_category_id`),
  CONSTRAINT `hub_thread_secondary_category_id_foreign` FOREIGN KEY (`thread_secondary_category_id`) REFERENCES `thread_secondary_categorys` (`id`),
  CONSTRAINT `hub_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `job_hunting_threads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_hunting_threads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hub_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `message_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `job_hunting_threads_hub_id_foreign` (`hub_id`),
  KEY `job_hunting_threads_user_id_foreign` (`user_id`),
  CONSTRAINT `job_hunting_threads_hub_id_foreign` FOREIGN KEY (`hub_id`) REFERENCES `hub` (`id`),
  CONSTRAINT `job_hunting_threads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `lecture_threads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lecture_threads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hub_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `message_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lecture_threads_hub_id_foreign` (`hub_id`),
  KEY `lecture_threads_user_id_foreign` (`user_id`),
  CONSTRAINT `lecture_threads_hub_id_foreign` FOREIGN KEY (`hub_id`) REFERENCES `hub` (`id`),
  CONSTRAINT `lecture_threads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `club_thread_id` bigint(20) unsigned DEFAULT NULL,
  `college_year_thread_id` bigint(20) unsigned DEFAULT NULL,
  `department_thread_id` bigint(20) unsigned DEFAULT NULL,
  `job_hunting_thread_id` bigint(20) unsigned DEFAULT NULL,
  `lecture_thread_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `likes_club_thread_id_foreign` (`club_thread_id`),
  KEY `likes_college_year_thread_id_foreign` (`college_year_thread_id`),
  KEY `likes_department_thread_id_foreign` (`department_thread_id`),
  KEY `likes_job_hunting_thread_id_foreign` (`job_hunting_thread_id`),
  KEY `likes_lecture_thread_id_foreign` (`lecture_thread_id`),
  KEY `likes_user_id_foreign` (`user_id`),
  CONSTRAINT `likes_club_thread_id_foreign` FOREIGN KEY (`club_thread_id`) REFERENCES `club_threads` (`id`),
  CONSTRAINT `likes_college_year_thread_id_foreign` FOREIGN KEY (`college_year_thread_id`) REFERENCES `college_year_threads` (`id`),
  CONSTRAINT `likes_department_thread_id_foreign` FOREIGN KEY (`department_thread_id`) REFERENCES `department_threads` (`id`),
  CONSTRAINT `likes_job_hunting_thread_id_foreign` FOREIGN KEY (`job_hunting_thread_id`) REFERENCES `job_hunting_threads` (`id`),
  CONSTRAINT `likes_lecture_thread_id_foreign` FOREIGN KEY (`lecture_thread_id`) REFERENCES `lecture_threads` (`id`),
  CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` char(36) DEFAULT NULL COMMENT '(DC2Type:guid)',
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `thread_image_paths`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `thread_image_paths` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `club_thread_id` bigint(20) unsigned DEFAULT NULL,
  `college_year_thread_id` bigint(20) unsigned DEFAULT NULL,
  `department_thread_id` bigint(20) unsigned DEFAULT NULL,
  `job_hunting_thread_id` bigint(20) unsigned DEFAULT NULL,
  `lecture_thread_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` char(36) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `img_size` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `thread_image_paths_img_path_unique` (`img_path`),
  KEY `thread_image_paths_club_thread_id_foreign` (`club_thread_id`),
  KEY `thread_image_paths_college_year_thread_id_foreign` (`college_year_thread_id`),
  KEY `thread_image_paths_department_thread_id_foreign` (`department_thread_id`),
  KEY `thread_image_paths_job_hunting_thread_id_foreign` (`job_hunting_thread_id`),
  KEY `thread_image_paths_lecture_thread_id_foreign` (`lecture_thread_id`),
  KEY `thread_image_paths_user_id_foreign` (`user_id`),
  CONSTRAINT `thread_image_paths_club_thread_id_foreign` FOREIGN KEY (`club_thread_id`) REFERENCES `club_threads` (`id`),
  CONSTRAINT `thread_image_paths_college_year_thread_id_foreign` FOREIGN KEY (`college_year_thread_id`) REFERENCES `college_year_threads` (`id`),
  CONSTRAINT `thread_image_paths_department_thread_id_foreign` FOREIGN KEY (`department_thread_id`) REFERENCES `department_threads` (`id`),
  CONSTRAINT `thread_image_paths_job_hunting_thread_id_foreign` FOREIGN KEY (`job_hunting_thread_id`) REFERENCES `job_hunting_threads` (`id`),
  CONSTRAINT `thread_image_paths_lecture_thread_id_foreign` FOREIGN KEY (`lecture_thread_id`) REFERENCES `lecture_threads` (`id`),
  CONSTRAINT `thread_image_paths_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `thread_primary_categorys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `thread_primary_categorys` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `thread_secondary_categorys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `thread_secondary_categorys` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `thread_primary_category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `thread_secondary_categorys_thread_primary_category_id_foreign` (`thread_primary_category_id`),
  CONSTRAINT `thread_secondary_categorys_thread_primary_category_id_foreign` FOREIGN KEY (`thread_primary_category_id`) REFERENCES `thread_primary_categorys` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_page_themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_page_themes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `theme_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` char(36) NOT NULL COMMENT '(DC2Type:guid)',
  `user_page_theme_id` bigint(20) unsigned NOT NULL DEFAULT 1,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_user_page_theme_id_foreign` (`user_page_theme_id`),
  CONSTRAINT `users_user_page_theme_id_foreign` FOREIGN KEY (`user_page_theme_id`) REFERENCES `user_page_themes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` VALUES (2,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` VALUES (3,'2014_10_12_200000_add_two_factor_columns_to_users_table',1);
INSERT INTO `migrations` VALUES (4,'2016_01_04_173148_create_admin_tables',1);
INSERT INTO `migrations` VALUES (5,'2019_08_19_000000_create_failed_jobs_table',1);
INSERT INTO `migrations` VALUES (6,'2019_12_14_000001_create_personal_access_tokens_table',1);
INSERT INTO `migrations` VALUES (7,'2022_04_30_125059_create_sessions_table',1);
INSERT INTO `migrations` VALUES (8,'2022_05_05_112244_create_hub_table',1);
INSERT INTO `migrations` VALUES (9,'2022_05_09_134146_create_likes_table',1);
INSERT INTO `migrations` VALUES (10,'2022_05_25_073001_create_access_logs_table',1);
INSERT INTO `migrations` VALUES (11,'2022_06_17_115624_create_user_page_themas_table',1);
INSERT INTO `migrations` VALUES (12,'2022_06_26_051216_create_thread_categorys_table',1);
INSERT INTO `migrations` VALUES (13,'2022_07_04_132802_change_unique_thread_id_to_hub_table',2);
INSERT INTO `migrations` VALUES (14,'2022_07_04_132958_add_thread_category_type_to_hub_table',2);
INSERT INTO `migrations` VALUES (15,'2022_07_05_111214_create_department_threads_table',2);
INSERT INTO `migrations` VALUES (16,'2022_07_05_133024_create_college_year_threads_table',2);
INSERT INTO `migrations` VALUES (17,'2022_07_05_133029_create_club_threads_table',2);
INSERT INTO `migrations` VALUES (18,'2022_07_05_133034_create_lecture_threads_table',2);
INSERT INTO `migrations` VALUES (19,'2022_07_05_133058_create_job_hunting_threads_table',2);
INSERT INTO `migrations` VALUES (20,'2022_07_09_111745_create_thread_image_paths_table',2);
INSERT INTO `migrations` VALUES (21,'2022_07_16_061648_change_unique_img_path_to_thread_image_paths_table',2);
INSERT INTO `migrations` VALUES (22,'2022_08_08_223259_change_string_thread_name_to_access_logs_table',2);
INSERT INTO `migrations` VALUES (23,'2022_08_08_223317_change_string_thread_id_to_access_logs_table',2);
INSERT INTO `migrations` VALUES (24,'2022_08_13_205002_create_contact_administrators_table',2);
INSERT INTO `migrations` VALUES (25,'2022_08_21_225233_drop_column_is_admin_to_user_table',2);
INSERT INTO `migrations` VALUES (26,'2022_08_22_183914_add_is_enabled_to_hub_table',2);
INSERT INTO `migrations` VALUES (27,'2022_08_26_230150_add_column_deleted_at_to_users_table',2);
INSERT INTO `migrations` VALUES (28,'2022_08_30_230832_change_column_id_type_uuid_to_users_table',2);
INSERT INTO `migrations` VALUES (29,'2022_09_01_162533_change_column_user_id_type_uuid_to_sessions_table',2);
INSERT INTO `migrations` VALUES (30,'2022_09_01_231044_change_column_id_type_uuid_to_hub_table',2);
INSERT INTO `migrations` VALUES (31,'2022_09_01_232617_add_column_user_id_to_access_logs_table',2);
INSERT INTO `migrations` VALUES (32,'2022_09_01_232813_add_column_hub_id_to_access_logs_table',2);
INSERT INTO `migrations` VALUES (33,'2022_09_01_234435_drop_column_user_email_to_access_logs_table',2);
INSERT INTO `migrations` VALUES (34,'2022_09_01_234448_drop_column_thread_name_to_access_logs_table',2);
INSERT INTO `migrations` VALUES (35,'2022_09_01_234453_drop_column_thread_id_to_access_logs_table',2);
INSERT INTO `migrations` VALUES (36,'2022_09_01_235129_drop_column_access_log_to_access_logs_table',2);
INSERT INTO `migrations` VALUES (37,'2022_09_02_231331_add_column_sessions_id_to_access_logs_table',2);
INSERT INTO `migrations` VALUES (38,'2022_09_02_232652_allow_null_column_user_id_to_access_logs_table',2);
INSERT INTO `migrations` VALUES (39,'2022_09_02_234703_add_column_uri_to_access_logs_table',2);
INSERT INTO `migrations` VALUES (40,'2022_09_05_223619_drop_column_thread_id_to_thread_tables',2);
INSERT INTO `migrations` VALUES (41,'2022_09_05_223952_drop_column_user_name_to_thread_tables',2);
INSERT INTO `migrations` VALUES (42,'2022_09_05_224103_drop_column_user_email_to_thread_tables',2);
INSERT INTO `migrations` VALUES (43,'2022_09_05_224726_drop_column_is_validity_to_thread_tables',2);
INSERT INTO `migrations` VALUES (44,'2022_09_05_224946_add_column_hub_id_to_thread_tables',2);
INSERT INTO `migrations` VALUES (45,'2022_09_05_225120_add_column_user_id_to_thread_tables',2);
INSERT INTO `migrations` VALUES (46,'2022_09_15_231034_add_column_user_id_to_contact_administrators_table',2);
INSERT INTO `migrations` VALUES (47,'2022_09_15_231432_drop_column_report_email_to_contact_administrators_table',2);
INSERT INTO `migrations` VALUES (48,'2022_09_18_193501_add_column_thread_category_id_to_hub_table',2);
INSERT INTO `migrations` VALUES (49,'2022_09_18_193813_add_column_user_id_to_hub_table',2);
INSERT INTO `migrations` VALUES (50,'2022_09_18_194045_drop_column_thread_id_to_hub_table',2);
INSERT INTO `migrations` VALUES (51,'2022_09_18_194634_drop_column_thread_category_to_hub_table',2);
INSERT INTO `migrations` VALUES (52,'2022_09_18_194645_drop_column_thread_category_type_to_hub_table',2);
INSERT INTO `migrations` VALUES (53,'2022_09_18_194654_drop_column_user_email_to_hub_table',2);
INSERT INTO `migrations` VALUES (54,'2022_09_18_195651_rename_thread_name_to_name_on_hub_table',2);
INSERT INTO `migrations` VALUES (55,'2022_10_13_214551_add_column_club_thread_id_to_likes_table',2);
INSERT INTO `migrations` VALUES (56,'2022_10_13_214605_add_column_college_year_thread_id_to_likes_table',2);
INSERT INTO `migrations` VALUES (57,'2022_10_13_214616_add_column_department_thread_id_to_likes_table',2);
INSERT INTO `migrations` VALUES (58,'2022_10_13_214636_add_column_job_hunting_thread_id_to_likes_table',2);
INSERT INTO `migrations` VALUES (59,'2022_10_13_214646_add_column_lecture_thread_id_to_likes_table',2);
INSERT INTO `migrations` VALUES (60,'2022_10_14_214953_add_column_user_id_to_likes_table',2);
INSERT INTO `migrations` VALUES (61,'2022_10_14_215322_drop_column_thread_id_to_likes_table',2);
INSERT INTO `migrations` VALUES (62,'2022_10_14_215416_drop_column_message_id_to_likes_table',2);
INSERT INTO `migrations` VALUES (63,'2022_10_14_215433_drop_column_user_email_to_likes_table',2);
INSERT INTO `migrations` VALUES (64,'2022_10_15_151605_add_column_club_thread_id_to_thread_image_paths_table',2);
INSERT INTO `migrations` VALUES (65,'2022_10_15_151621_add_column_college_year_thread_id_to_thread_image_paths_table',2);
INSERT INTO `migrations` VALUES (66,'2022_10_15_151640_add_column_department_thread_id_to_thread_image_paths_table',2);
INSERT INTO `migrations` VALUES (67,'2022_10_15_151714_add_column_job_hunting_thread_id_to_thread_image_paths_table',2);
INSERT INTO `migrations` VALUES (68,'2022_10_15_151738_add_column_lecture_thread_id_to_thread_image_paths_table',2);
INSERT INTO `migrations` VALUES (69,'2022_10_15_153505_add_column_user_id_to_thread_image_paths_table',2);
INSERT INTO `migrations` VALUES (70,'2022_10_15_154007_drop_column_thread_id_to_thread_image_paths_table',2);
INSERT INTO `migrations` VALUES (71,'2022_10_15_154030_drop_column_message_id_to_thread_image_paths_table',2);
INSERT INTO `migrations` VALUES (72,'2022_10_15_154055_drop_column_user_email_to_thread_image_paths_table',2);
INSERT INTO `migrations` VALUES (73,'2022_10_29_200727_drop_table_user_page_themas',2);
INSERT INTO `migrations` VALUES (74,'2022_10_29_201059_create_user_page_themes_table',2);
INSERT INTO `migrations` VALUES (75,'2022_10_29_201500_add_column_user_page_theme_id_to_users_table',2);
INSERT INTO `migrations` VALUES (76,'2022_10_29_201849_drop_column_thema_to_users_table',2);
INSERT INTO `migrations` VALUES (77,'2022_11_06_144310_drop_table_admin_menu',3);
INSERT INTO `migrations` VALUES (78,'2022_11_06_144509_drop_table_admin_operation_log',3);
INSERT INTO `migrations` VALUES (79,'2022_11_06_144555_drop_table_admin_permissions',3);
INSERT INTO `migrations` VALUES (80,'2022_11_06_144652_drop_table_admin_roles',3);
INSERT INTO `migrations` VALUES (81,'2022_11_06_144733_drop_table_admin_role_menu',3);
INSERT INTO `migrations` VALUES (82,'2022_11_06_144805_drop_table_admin_role_permissions',3);
INSERT INTO `migrations` VALUES (83,'2022_11_06_144848_drop_table_admin_role_users',4);
INSERT INTO `migrations` VALUES (84,'2022_11_06_144922_drop_table_admin_users',4);
INSERT INTO `migrations` VALUES (85,'2022_11_06_144955_drop_table_admin_user_permissions',4);
INSERT INTO `migrations` VALUES (86,'2022_12_10_143354_drop_column_is_enabled_to_hub_table',5);
INSERT INTO `migrations` VALUES (87,'2022_12_10_143601_add_column_deleted_at_to_hub_table',5);
INSERT INTO `migrations` VALUES (88,'2022_12_11_214722_drop_thread_categorys',5);
INSERT INTO `migrations` VALUES (89,'2022_12_11_215321_create_thread_primary_categorys',5);
INSERT INTO `migrations` VALUES (90,'2022_12_11_215327_create_thread_secondary_categorys',5);
INSERT INTO `migrations` VALUES (91,'2022_12_11_220915_change_column_thread_secondary_category_id_to_hub',5);
INSERT INTO `migrations` VALUES (92,'2022_12_14_233235_add_column_deleted_at_to_threads_table',5);
INSERT INTO `migrations` VALUES (93,'2022_12_31_212013_drop_column_session_id_to_access_logs_table',5);
INSERT INTO `migrations` VALUES (94,'2022_12_31_212036_drop_column_uri_to_access_logs_table',5);
INSERT INTO `migrations` VALUES (95,'2023_02_21_145110_create_contact_types_table',5);
INSERT INTO `migrations` VALUES (96,'2023_02_21_145244_drop_column_type_to_contact_administrators_table',5);
INSERT INTO `migrations` VALUES (97,'2023_02_21_145402_add_column_contact_type_id_to_contact_administrators_table',5);
