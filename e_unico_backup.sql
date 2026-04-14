-- MySQL dump 10.13  Distrib 8.0.45, for Win64 (x86_64)
--
-- Host: localhost    Database: e_unico
-- ------------------------------------------------------
-- Server version	8.0.45

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `actividad_tramites`
--

DROP TABLE IF EXISTS `actividad_tramites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `actividad_tramites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `area_id` bigint unsigned DEFAULT NULL,
  `contribuyente_id` bigint unsigned NOT NULL,
  `tramite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tramite_id` bigint unsigned DEFAULT NULL,
  `documentos_subidos` json DEFAULT NULL,
  `documento_nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `accion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'registró',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `actividad_tramites_area_id_created_at_index` (`area_id`,`created_at`),
  KEY `idx_contribuyente` (`contribuyente_id`),
  KEY `idx_area` (`area_id`),
  KEY `idx_created` (`created_at`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_accion` (`accion`),
  CONSTRAINT `actividad_tramites_contribuyente_id_foreign` FOREIGN KEY (`contribuyente_id`) REFERENCES `contribuyentes` (`id`),
  CONSTRAINT `actividad_tramites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividad_tramites`
--

LOCK TABLES `actividad_tramites` WRITE;
/*!40000 ALTER TABLE `actividad_tramites` DISABLE KEYS */;
INSERT INTO `actividad_tramites` VALUES (1,3,1,1,'1.1',NULL,'\"[\\\"1_1_rfc\\\"]\"',NULL,NULL,'registró','2026-04-01 05:58:39','2026-04-01 05:58:39'),(2,2,2,1,'1. TRÁMITE DE ALINEAMIENTO, NÚMERO OFICIAL Y USO DE SUELO',NULL,'\"[\\\"1_identificacion\\\"]\"',NULL,NULL,'registró','2026-04-01 06:23:37','2026-04-01 06:23:37'),(3,4,3,1,'1. PROGRAMA INTERNO DE PROTECCIÓN CIVIL',NULL,'\"[\\\"proc1_9\\\"]\"',NULL,NULL,'registró','2026-04-01 06:25:08','2026-04-01 06:25:08'),(4,4,3,1,'2. MEDIDAS DE SEGURIDAD EN MATERIA DE PROTECCIÓN CIVIL',NULL,'\"[\\\"proc2_2\\\"]\"',NULL,NULL,'registró','2026-04-01 16:26:32','2026-04-01 16:26:32'),(5,2,2,1,'1. TRÁMITE DE ALINEAMIENTO, NÚMERO OFICIAL Y USO DE SUELO',NULL,'\"[]\"','Documento final',NULL,'completó trámite','2026-04-05 04:40:20','2026-04-05 04:40:20'),(6,2,2,1,'1. TRÁMITE DE ALINEAMIENTO, NÚMERO OFICIAL Y USO DE SUELO',NULL,'\"[\\\"identificacion\\\"]\"',NULL,NULL,'subió requisitos','2026-04-05 20:52:02','2026-04-05 20:52:02'),(7,2,2,1,'2. TRÁMITE DE USO DE SUELO ESPECÍFICO',NULL,'\"[\\\"2_predial\\\"]\"',NULL,NULL,'subió requisitos','2026-04-05 21:03:01','2026-04-05 21:03:01'),(8,5,4,1,'PERSONA FÍSICA - INGRESOS',NULL,'\"[\\\"curp\\\"]\"',NULL,NULL,'subió requisitos','2026-04-13 00:21:50','2026-04-13 00:21:50'),(9,3,1,1,'1.1',NULL,'\"[\\\"1_1_rfc\\\"]\"',NULL,NULL,'registró','2026-04-13 08:21:45','2026-04-13 08:21:45'),(10,3,1,1,'1.1',NULL,'\"[\\\"1_1_rfc\\\"]\"',NULL,NULL,'registró','2026-04-13 08:23:41','2026-04-13 08:23:41');
/*!40000 ALTER TABLE `actividad_tramites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `areas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areas`
--

LOCK TABLES `areas` WRITE;
/*!40000 ALTER TABLE `areas` DISABLE KEYS */;
INSERT INTO `areas` VALUES (1,'Industria y Comercio','Gestión de licencias comerciales e industriales',1,'2026-03-31 21:23:35','2026-03-31 21:23:35'),(2,'Desarrollo Urbano','Permisos de construcción y uso de suelo',1,'2026-03-31 21:23:35','2026-03-31 21:23:35'),(3,'Protección Civil','Dictámenes de seguridad y riesgo',1,'2026-03-31 21:23:35','2026-03-31 21:23:35'),(4,'Ingresos',NULL,1,'2026-04-07 21:47:41','2026-04-07 21:47:41');
/*!40000 ALTER TABLE `areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audit_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `record_id` bigint unsigned DEFAULT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_index` (`user_id`),
  KEY `audit_logs_action_index` (`action`),
  KEY `audit_logs_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contribuyentes`
--

DROP TABLE IF EXISTS `contribuyentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contribuyentes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rfc` longtext COLLATE utf8mb4_unicode_ci,
  `telefono` longtext COLLATE utf8mb4_unicode_ci,
  `email` longtext COLLATE utf8mb4_unicode_ci,
  `nombre_empresa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `giro_comercial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` longtext COLLATE utf8mb4_unicode_ci,
  `tipo_persona` enum('fisica','moral') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fisica',
  `user_id` bigint unsigned NOT NULL,
  `area_id` bigint unsigned NOT NULL DEFAULT '1',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `apellido_paterno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido_materno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `curp` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `contribuyentes_user_id_foreign` (`user_id`),
  KEY `idx_nombre` (`nombre`),
  KEY `idx_empresa` (`nombre_empresa`),
  KEY `idx_created` (`created_at`),
  CONSTRAINT `contribuyentes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contribuyentes`
--

LOCK TABLES `contribuyentes` WRITE;
/*!40000 ALTER TABLE `contribuyentes` DISABLE KEYS */;
INSERT INTO `contribuyentes` VALUES (1,'Neil Andre',NULL,'eyJpdiI6IlowRXI1SHhYRWIvRzZsYjZOeWFxbkE9PSIsInZhbHVlIjoiQ09KbjkzNUJWVzllZUVNSk9pZHpPQT09IiwibWFjIjoiYTgxNGRkNjAzMzNlMjNhYWQ1ZDExZGQ4NDUxMjA5NzAwNmVjM2Q3NDBlZDZkOWU0YThmYTgxMmY3MzUxZDc1NSIsInRhZyI6IiJ9','eyJpdiI6Im9CalNabTc5VHZvZGZVWlJEWVUxYVE9PSIsInZhbHVlIjoiK1BESjVRbVBDU0VzKyt3ZHJ6ZFFRUT09IiwibWFjIjoiOWEzNmRiOGVhODgwMzZmZDUyNTU1YjE0YTY4NDA4ZGY0NGNmNDkxNjZlZmExODNjZWVmOTMwNjVhMzI2ODA2NSIsInRhZyI6IiJ9','eyJpdiI6IjRpblVVZWFnQTlGSE5CVWpkSnpIUXc9PSIsInZhbHVlIjoiUk9zbmVGSWlUNkxXNXZTTGRMV2pNdz09IiwibWFjIjoiNzcxOWM2Nzg3NTZlYjk3YmVjNzg3YzJjYmQ2MTdlYzk0ZDllNjE1ZTU2OGFhMjkzYjI5NzNhZTc2MDZhYWZiMSIsInRhZyI6IiJ9','El Camaroncin','Mariscos','eyJpdiI6IjRkMCs0UkdVdTJxQkJhNjRDNHRHNnc9PSIsInZhbHVlIjoiRXZCc2RsZzZjYWpsbEtaL2FxWm4xZ2dJczFHTXo2SVZsSlVrZU01QXVJZ0JaOHFjcFUwdHhKZExyMUZqTDNLWiIsIm1hYyI6ImJiNWVkZjk5NjRjODBmYzhmZjMwMGFhNGQ0ZmFlM2IxMWI4YWRlOWUyY2ZjZjk4NzYyMmYyZjkyZmQwYmUyNzEiLCJ0YWciOiIifQ==','fisica',3,1,1,'2026-03-31 21:53:51','2026-03-31 21:53:51','Dominguez','García','');
/*!40000 ALTER TABLE `contribuyentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentos_adjuntos`
--

DROP TABLE IF EXISTS `documentos_adjuntos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentos_adjuntos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tramite_documento_id` bigint unsigned NOT NULL,
  `nombre_documento` varchar(255) NOT NULL,
  `archivo_path` varchar(500) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tramite_documento` (`tramite_documento_id`),
  KEY `idx_nombre` (`nombre_documento`),
  CONSTRAINT `documentos_adjuntos_ibfk_1` FOREIGN KEY (`tramite_documento_id`) REFERENCES `tramites_documentos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentos_adjuntos`
--

LOCK TABLES `documentos_adjuntos` WRITE;
/*!40000 ALTER TABLE `documentos_adjuntos` DISABLE KEYS */;
INSERT INTO `documentos_adjuntos` VALUES (1,15,'1_1_rfc','documentos/1/HqXtvFXW8Rm9dKOpWXHEG1ioPkhUVjLV9s24Ua7s.pdf','2026-04-13 08:21:45','2026-04-13 08:21:45'),(2,16,'1_1_rfc','documentos/1/IFjEF7Tt1vTo98qWSDva6tQwBkFa2ylzZZlGpSCU.pdf','2026-04-13 08:23:41','2026-04-13 08:23:41');
/*!40000 ALTER TABLE `documentos_adjuntos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentos_vigencia`
--

DROP TABLE IF EXISTS `documentos_vigencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentos_vigencia` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contribuyente_id` bigint unsigned NOT NULL,
  `area_id` bigint unsigned DEFAULT NULL,
  `es_universal` tinyint(1) NOT NULL DEFAULT '0',
  `subido_por_area` bigint unsigned DEFAULT NULL,
  `tramite_documento_id` bigint unsigned DEFAULT NULL,
  `nombre_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `archivo_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `estado` enum('vigente','vencido') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vigente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documentos_vigencia_tramite_documento_id_foreign` (`tramite_documento_id`),
  KEY `documentos_vigencia_area_id_estado_fecha_vencimiento_index` (`area_id`,`estado`,`fecha_vencimiento`),
  KEY `idx_contribuyente` (`contribuyente_id`),
  KEY `idx_area` (`area_id`),
  KEY `idx_fecha_vencimiento` (`fecha_vencimiento`),
  CONSTRAINT `documentos_vigencia_contribuyente_id_foreign` FOREIGN KEY (`contribuyente_id`) REFERENCES `contribuyentes` (`id`),
  CONSTRAINT `documentos_vigencia_tramite_documento_id_foreign` FOREIGN KEY (`tramite_documento_id`) REFERENCES `tramites_documentos` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentos_vigencia`
--

LOCK TABLES `documentos_vigencia` WRITE;
/*!40000 ALTER TABLE `documentos_vigencia` DISABLE KEYS */;
INSERT INTO `documentos_vigencia` VALUES (1,1,1,0,NULL,NULL,'1_1_rfc','documentos/1/1fGTxgXxwiSO905lTEy5Km451XuETWCL4TcMQQSO.pdf','2027-03-31','vigente','2026-04-01 05:58:39','2026-04-01 05:58:39'),(2,1,2,0,NULL,NULL,'1_identificacion','desarrollo/documentos/1/77LTdj9HRTvF6sgN3Uwb4Dxd5PDintyPA9O0oxBc.pdf','2027-04-01','vigente','2026-04-01 06:23:37','2026-04-01 06:23:37'),(3,1,3,0,NULL,NULL,'proc1_9','proteccion/documentos/1/kS7TLfhtZVNYN9xLgs4sDSCNZaO8gGmEH4oeSgwh.pdf','2027-04-01','vigente','2026-04-01 06:25:08','2026-04-01 06:25:08'),(4,1,3,0,NULL,NULL,'proc2_2','proteccion/documentos/1/hZupyYbb1DbPxtQRu7wdocUUcZhoCHawCtrCCCz2.pdf','2027-04-01','vigente','2026-04-01 16:26:32','2026-04-01 16:26:32'),(5,1,2,0,NULL,NULL,'identificacion','desarrollo/documentos/1/O0uRba8RoMeULFdO5c277oGV0aSGtTeqSHhQdufL.pdf','2027-04-05','vigente','2026-04-05 20:52:02','2026-04-05 20:52:02'),(6,1,2,0,NULL,NULL,'2_predial','desarrollo/documentos/1/fPln7R5w3MGIqNzaGXbCoGRZD1uuORazPOQfTgB2.pdf','2027-04-05','vigente','2026-04-05 21:03:01','2026-04-05 21:03:01'),(7,1,4,0,NULL,NULL,'curp','ingresos/documentos/1/K6IzfG1IwhUO4S85XftQ7iC0DjGmZXCqTOoQwV3f.pdf','2027-04-12','vigente','2026-04-13 00:21:50','2026-04-13 00:21:50'),(8,1,1,0,NULL,NULL,'1_1_rfc','documentos/1/HqXtvFXW8Rm9dKOpWXHEG1ioPkhUVjLV9s24Ua7s.pdf','2027-04-13','vigente','2026-04-13 08:21:45','2026-04-13 08:21:45'),(9,1,1,0,NULL,NULL,'1_1_rfc','documentos/1/IFjEF7Tt1vTo98qWSDva6tQwBkFa2ylzZZlGpSCU.pdf','2027-04-13','vigente','2026-04-13 08:23:41','2026-04-13 08:23:41');
/*!40000 ALTER TABLE `documentos_vigencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_at_available_at_index` (`queue`,`reserved_at`,`available_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_03_11_045046_create_areas_table',1),(5,'2026_03_11_045101_create_contribuyentes_table',1),(6,'2026_03_11_045112_create_documentos_table',1),(7,'2026_03_11_045132_create_expedientes_table',1),(8,'2026_03_11_045145_add_area_id_to_users_table',1),(9,'2026_03_11_052728_add_rol_and_activo_to_users_table',1),(10,'2026_03_11_172020_add_nombre_apellidos_to_users_table',1),(11,'2026_03_11_194913_add_last_login_to_users_table',1),(12,'2026_03_12_042459_create_permission_tables',1),(13,'2026_03_16_225618_create_documentos_industria_table',1),(14,'2026_03_16_230533_add_area_id_to_contribuyentes_table',1),(15,'2026_03_16_233810_fix_contribuyentes_table',1),(16,'2026_03_19_052259_create_tramites_table',1),(17,'2026_03_19_052311_create_subtramites_table',1),(18,'2026_03_19_052328_create_requisitos_table',1),(19,'2026_03_19_052342_create_tramites_documentos_table',1),(20,'2026_03_20_055933_create_actividad_tramites_table',1),(21,'2026_03_20_060739_create_documentos_vigencia_table',1),(22,'2026_03_20_074616_add_apellidos_to_contribuyentes_table',1),(23,'2026_03_20_075444_make_apellidos_nullable_in_contribuyentes',1),(24,'2026_03_25_190956_add_area_id_to_tramites_documentos_table',1),(25,'2026_03_25_193830_add_tramite_to_tramites_documentos_table',1),(26,'2026_03_26_010715_add_area_id_to_actividad_tramites_table',1),(27,'2026_03_27_015521_add_area_id_to_documentos_vigencia_table',1),(28,'2026_03_31_235001_add_area_id_and_details_to_historial_tables',2),(29,'2026_04_04_202716_add_documento_final_to_tramites_documentos_table',3),(30,'2026_04_04_223739_add_documento_final_fields_to_tramites_documentos',4),(31,'2026_04_05_160032_add_es_universal_to_documentos_vigencia',5),(32,'2026_04_06_105713_add_last_login_at_to_users_table',6),(33,'2026_04_12_231147_add_indexes_for_performance',7),(34,'2026_04_12_233416_encrypt_existing_contribuyente_data',8),(35,'2026_04_12_235954_create_audit_logs_table',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2),(2,'App\\Models\\User',3),(2,'App\\Models\\User',4),(2,'App\\Models\\User',5);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ordenes_cobro`
--

DROP TABLE IF EXISTS `ordenes_cobro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordenes_cobro` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contribuyente_id` bigint unsigned NOT NULL,
  `area_id` bigint unsigned NOT NULL,
  `folio` varchar(50) NOT NULL,
  `orden_cobro` text,
  `cotizacion` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `contribuyente_id` (`contribuyente_id`),
  KEY `area_id` (`area_id`),
  KEY `idx_folio` (`folio`),
  KEY `idx_created` (`created_at`),
  CONSTRAINT `ordenes_cobro_ibfk_1` FOREIGN KEY (`contribuyente_id`) REFERENCES `contribuyentes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ordenes_cobro_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordenes_cobro`
--

LOCK TABLES `ordenes_cobro` WRITE;
/*!40000 ALTER TABLE `ordenes_cobro` DISABLE KEYS */;
/*!40000 ALTER TABLE `ordenes_cobro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (32,'ver contribuyentes','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(33,'crear contribuyentes','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(34,'editar contribuyentes','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(35,'eliminar contribuyentes','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(36,'ver documentos','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(37,'subir documentos','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(38,'ver expediente','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(39,'ver cotejo','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(40,'ver historial','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(41,'exportar csv','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(42,'crear ordenes','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(43,'ver ordenes','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(44,'acceso industria','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(45,'acceso desarrollo','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(46,'acceso proteccion','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(47,'acceso ingresos','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(48,'administrar usuarios','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(49,'ver configuracion','web','2026-04-13 03:50:22','2026-04-13 03:50:22'),(50,'editar configuracion','web','2026-04-13 03:50:22','2026-04-13 03:50:22');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(32,2),(33,2),(34,2),(35,2),(36,2),(37,2),(38,2),(39,2),(40,2),(41,2),(42,2),(43,2),(44,2),(45,2),(46,2),(47,2),(32,3),(33,3),(36,3),(37,3),(38,3),(39,3),(40,3),(41,3),(42,3),(43,3),(44,3),(45,3),(46,3),(47,3),(32,4),(33,4),(36,4),(37,4),(38,4),(39,4),(40,4),(41,4),(42,4),(43,4),(44,4),(45,4),(46,4),(47,4);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador General','web','2026-03-31 21:23:35','2026-03-31 21:23:35'),(2,'Administrador de área','web','2026-03-31 21:23:35','2026-03-31 21:23:35'),(3,'Jefe de área','web','2026-03-31 21:23:35','2026-03-31 21:23:35'),(4,'Usuario','web','2026-03-31 21:23:35','2026-03-31 21:23:35');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('x7DZ5SCz9UQVVWLm6M7gzTy9ON75Cj3cpb4tECoi',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiS202cjRJYWdoNkZ3ZTg1Y01ZVEhjb1ZTTTRpYzN5dnJOTW9uSXhsVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=',1776055660);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tramites_documentos`
--

DROP TABLE IF EXISTS `tramites_documentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tramites_documentos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contribuyente_id` bigint unsigned NOT NULL,
  `tramite_id` bigint unsigned DEFAULT NULL,
  `area_id` bigint unsigned DEFAULT NULL,
  `tramite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtramite_id` bigint unsigned DEFAULT NULL,
  `campos_texto` json DEFAULT NULL,
  `documento_final_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mostrar_en_cotejo` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tramites_documentos_tramite_id_foreign` (`tramite_id`),
  KEY `tramites_documentos_subtramite_id_foreign` (`subtramite_id`),
  KEY `tramites_documentos_user_id_foreign` (`user_id`),
  KEY `idx_contribuyente` (`contribuyente_id`),
  KEY `idx_area` (`area_id`),
  KEY `idx_created` (`created_at`),
  KEY `idx_mostrar_cotejo` (`mostrar_en_cotejo`),
  CONSTRAINT `tramites_documentos_contribuyente_id_foreign` FOREIGN KEY (`contribuyente_id`) REFERENCES `contribuyentes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tramites_documentos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tramites_documentos`
--

LOCK TABLES `tramites_documentos` WRITE;
/*!40000 ALTER TABLE `tramites_documentos` DISABLE KEYS */;
INSERT INTO `tramites_documentos` VALUES (1,1,NULL,1,'1.1',NULL,NULL,NULL,0,3,'2026-04-01 05:58:39','2026-04-01 05:58:39'),(2,1,NULL,2,'1. TRÁMITE DE ALINEAMIENTO, NÚMERO OFICIAL Y USO DE SUELO',NULL,NULL,NULL,0,2,'2026-04-01 06:23:37','2026-04-01 06:23:37'),(3,1,NULL,3,'1. PROGRAMA INTERNO DE PROTECCIÓN CIVIL',NULL,NULL,NULL,0,4,'2026-04-01 06:25:08','2026-04-01 06:25:08'),(4,1,NULL,3,'2. MEDIDAS DE SEGURIDAD EN MATERIA DE PROTECCIÓN CIVIL',NULL,NULL,NULL,0,4,'2026-04-01 16:26:32','2026-04-01 16:26:32'),(5,1,NULL,2,'1. TRÁMITE DE ALINEAMIENTO, NÚMERO OFICIAL Y USO DE SUELO',NULL,NULL,'desarrollo/documentos_finales/1/7YhjyR7JArRqqUxrxYnvIx6BMY0LcMBW7ypwv0y9.pdf',1,2,'2026-04-05 04:40:20','2026-04-05 04:40:20'),(6,1,NULL,2,'1. TRÁMITE DE ALINEAMIENTO, NÚMERO OFICIAL Y USO DE SUELO',NULL,NULL,NULL,0,2,'2026-04-05 20:52:02','2026-04-05 20:52:02'),(7,1,NULL,2,'2. TRÁMITE DE USO DE SUELO ESPECÍFICO',NULL,NULL,'desarrollo/documentos_finales/1/eB2kLR2FW2FFpEQYVMfXRHBb6qZLvo4xibxD2Gxv.pdf',1,2,'2026-04-05 21:01:02','2026-04-05 21:01:02'),(8,1,NULL,2,'2. TRÁMITE DE USO DE SUELO ESPECÍFICO',NULL,NULL,NULL,0,2,'2026-04-05 21:03:01','2026-04-05 21:03:01'),(9,1,NULL,2,'2. TRÁMITE DE USO DE SUELO ESPECÍFICO',NULL,NULL,'desarrollo/documentos_finales/1/La9GJCdm8Q3rmR5ju7D1vXFgRDtPA2KeiUDkJeFC.pdf',1,2,'2026-04-05 21:03:14','2026-04-05 21:03:14'),(10,1,NULL,3,'1. PROGRAMA INTERNO DE PROTECCIÓN CIVIL',NULL,NULL,'proteccion/documentos_finales/1/2mKAM5FXjX5eiBBRqxDHlwd8J3BRK0znCqAKHWK1.pdf',1,4,'2026-04-06 02:47:22','2026-04-06 02:47:22'),(11,1,NULL,4,'PERSONA FÍSICA - INGRESOS',NULL,NULL,NULL,0,5,'2026-04-13 00:21:50','2026-04-13 00:21:50'),(12,1,NULL,1,'1.1',NULL,NULL,NULL,0,3,'2026-04-13 08:00:55','2026-04-13 08:00:55'),(13,1,NULL,1,'1.1',NULL,NULL,NULL,0,3,'2026-04-13 08:05:18','2026-04-13 08:05:18'),(14,1,NULL,1,'1.1',NULL,NULL,NULL,0,3,'2026-04-13 08:09:21','2026-04-13 08:09:21'),(15,1,NULL,1,'1.1',NULL,NULL,NULL,0,3,'2026-04-13 08:21:45','2026-04-13 08:21:45'),(16,1,NULL,1,'1.1',NULL,NULL,NULL,0,3,'2026-04-13 08:23:41','2026-04-13 08:23:41');
/*!40000 ALTER TABLE `tramites_documentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_completo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'usuario',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `area_id` bigint unsigned DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_area_id_foreign` (`area_id`),
  CONSTRAINT `users_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrador',NULL,'admin@expedienteunico.com',NULL,NULL,'$2y$12$emPesV.VZQtGC3yC4jW.jOwocad9wDO2mQBCzPxHlEUxNFTtsHVK2','administrador',NULL,'2026-04-13 07:59:55','2026-03-31 21:23:35','2026-04-13 07:59:55',NULL,1),(2,'Bryan Candia','Bryan Candia','bryave007@gmail.com','2231435671',NULL,'$2y$12$UXv59sgitwkXfeq.be0gquFi0BOMcYHjnekYDuPZPtWm1RSLYBAle','Administrador de área',NULL,'2026-04-13 08:25:24','2026-03-31 21:27:57','2026-04-13 08:25:24',2,1),(3,'Concha','Jonathan Jaime Concha Calvillo','jony@gmail.com','2231435671',NULL,'$2y$12$j46VXN/spa7sd4M3KY06S.wkdWOJskP6uP3KvD9XuFksrp89HlxZG','Administrador de área',NULL,'2026-04-13 08:00:19','2026-03-31 21:51:47','2026-04-13 08:00:19',1,1),(4,'Mitziote','María Guadalupe Mitzi Flores','mariaflores@gmail.com','2211377469',NULL,'$2y$12$6idQ6k1d884haUF.q7ElwuDKJXLXGB62UdwKqwxUL4Z98u5VUVq/.','Administrador de área',NULL,'2026-04-13 08:26:29','2026-03-31 22:35:38','2026-04-13 08:26:29',3,1),(5,'Iguana','Lisbeth Tellez','lis@gmail.com','2231435671',NULL,'$2y$12$mhyCneWWvkYdqEfDnSHLa.zDnyUlAuBzLD9mmf25/qbBUjOSsi6gq','Administrador de área',NULL,'2026-04-13 00:20:54','2026-04-07 21:51:45','2026-04-13 00:20:54',4,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-13  2:33:28
