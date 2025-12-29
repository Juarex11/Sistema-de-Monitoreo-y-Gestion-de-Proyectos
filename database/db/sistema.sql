-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-12-2025 a las 04:59:39
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `tipo_cliente` enum('persona','empresa') NOT NULL DEFAULT 'empresa',
  `nombre_comercial` varchar(255) DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `ruc_dni` varchar(20) NOT NULL,
  `representante` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `telefono_alt` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_alt` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `pais` varchar(255) DEFAULT NULL,
  `actividad` varchar(255) DEFAULT NULL,
  `estado_cliente` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `creado_por` bigint(20) UNSIGNED DEFAULT NULL,
  `actualizado_por` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `codigo`, `tipo_cliente`, `nombre_comercial`, `razon_social`, `ruc_dni`, `representante`, `telefono`, `telefono_alt`, `email`, `email_alt`, `password`, `direccion`, `ciudad`, `pais`, `actividad`, `estado_cliente`, `creado_por`, `actualizado_por`, `created_at`, `updated_at`) VALUES
(2, 'CLI-0001', 'empresa', 'TIENDA PRUEBAS', 'TIENDA PRUEBA', '7526262', 'Raaa', '981031226', '981031226', 'crm@loudata.net.pe', 'crm@loudata.net.pe', NULL, 'Lima', 'Lima', 'Perú', 'Pescado', 'activo', 1, 1, '2025-12-12 02:04:46', '2025-12-12 02:18:49'),
(3, 'CLI-0003', 'persona', 'Milenco Diaz', 'TIENDA PRUEBA0', '22313123123', 'Raaa', '981031226', '981031226', 'crm@loudata.net.pe', 'crmaa@loudata.net.pe', '$2y$12$ocS3gbHpxF3fcG414vK6KONtJ70zFJyrW0ihIwb9WeTkjROTWb.p6', 'Lima', 'Lima', 'Perú', 'Pescado', 'activo', 1, 1, '2025-12-12 02:19:20', '2025-12-29 05:11:29'),
(4, 'CLI-0004', 'empresa', 'JUAREX TECHNOLOGY GROUP S.A.C.', 'JUAREX TECHNOLOGY GROUP S.A.C.', '20614212081', 'QUISPE CIRILO NOE PETER ANTONIO', '981031226', '981031226', 'crm@loudata.net.pe', 'crm@loudata.net.pe', '$2y$12$..yGt8mAtZiNThzvHNdp0esR03IfwnTBfDvs3yzYJSbBs3pFjA6tK', 'Lima', 'Lima', 'Perú', 'TI', 'activo', 1, 1, '2025-12-29 05:10:24', '2025-12-29 05:10:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_proyecto`
--

CREATE TABLE `cliente_proyecto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `proyecto_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cliente_proyecto`
--

INSERT INTO `cliente_proyecto` (`id`, `cliente_id`, `proyecto_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `cliente_id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` text NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `estado` enum('pendiente','aprobada','rechazada') NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cotizaciones`
--

INSERT INTO `cotizaciones` (`id`, `codigo`, `cliente_id`, `descripcion`, `total`, `estado`, `created_at`, `updated_at`) VALUES
(4, 'COT-20251212-1765558891', 2, 'Buena persona', 23600.00, 'aprobada', '2025-12-12 22:01:31', '2025-12-13 00:05:07'),
(5, 'COT-20251212-1765572138', 3, 'Jara Zegarra Minar', 12.00, 'aprobada', '2025-12-13 01:42:18', '2025-12-29 04:47:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion_items`
--

CREATE TABLE `cotizacion_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cotizacion_id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(12,2) NOT NULL,
  `tipo_pago` enum('unico','mensual','anual') NOT NULL DEFAULT 'unico',
  `aplica_igv` tinyint(1) NOT NULL DEFAULT 0,
  `total` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cotizacion_items`
--

INSERT INTO `cotizacion_items` (`id`, `cotizacion_id`, `titulo`, `descripcion`, `precio`, `tipo_pago`, `aplica_igv`, `total`, `created_at`, `updated_at`) VALUES
(5, 4, 'Auditoría Interna', 'Buena persona', 20000.00, 'mensual', 1, 23600.00, '2025-12-12 22:08:54', '2025-12-12 22:09:07'),
(6, 5, 'SISTEMA WEB', 'Sistema\r\n- Hosting, etc\r\n()', 12.00, 'unico', 0, 12.00, '2025-12-13 01:42:18', '2025-12-13 01:42:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion_proyecto`
--

CREATE TABLE `cotizacion_proyecto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proyecto_id` bigint(20) UNSIGNED NOT NULL,
  `cotizacion_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cotizacion_proyecto`
--

INSERT INTO `cotizacion_proyecto` (`id`, `proyecto_id`, `cotizacion_id`, `created_at`, `updated_at`) VALUES
(2, 1, 5, '2025-12-13 01:42:33', '2025-12-13 01:42:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_proyecto`
--

CREATE TABLE `documentos_proyecto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proyecto_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `ruta` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `extension` varchar(255) NOT NULL,
  `tamanio` int(11) DEFAULT NULL,
  `subido_por` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `documentos_proyecto`
--

INSERT INTO `documentos_proyecto` (`id`, `proyecto_id`, `nombre`, `descripcion`, `ruta`, `tipo`, `extension`, `tamanio`, `subido_por`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jose Llontop Bonilla', 'Buena persona', 'archivos_proyecto/1765577440_WhatsApp_Image_2025-12-10_at_9.28.56_AM.jpeg', 'imagen', 'jpeg', 91468, 1, '2025-12-13 03:08:47', '2025-12-13 03:10:40'),
(3, 1, 'Admin', 'Buena persona', 'archivos_proyecto/1765577460_COT-20251212-1765558891.pdf', 'pdf', 'pdf', 885878, 1, '2025-12-13 03:11:00', '2025-12-13 03:11:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `cargo` varchar(255) DEFAULT NULL,
  `celular` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `carrera` varchar(255) DEFAULT NULL,
  `ciclo` varchar(255) DEFAULT NULL,
  `remuneracion` decimal(10,2) DEFAULT NULL,
  `otros_datos` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `proyecto_id` bigint(20) UNSIGNED DEFAULT NULL,
  `estado` enum('activo','inactivo','finalizado') NOT NULL DEFAULT 'activo',
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `objetivos` text DEFAULT NULL,
  `capacidad_maxima` int(11) DEFAULT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  `notas` text DEFAULT NULL,
  `creado_por` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `codigo`, `nombre`, `descripcion`, `proyecto_id`, `estado`, `fecha_inicio`, `fecha_fin`, `objetivos`, `capacidad_maxima`, `ubicacion`, `notas`, `creado_por`, `created_at`, `updated_at`) VALUES
(1, 'EQ-20251212-1765580405', 'Desarrollo Web', '123', 1, 'activo', '2025-12-12', '2025-12-12', 'Terminar proyecto', 3, 'remoto', '123', 1, '2025-12-13 04:00:05', '2025-12-13 04:00:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_proyecto`
--

CREATE TABLE `equipo_proyecto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `equipo_id` bigint(20) UNSIGNED NOT NULL,
  `proyecto_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_asignacion` date NOT NULL DEFAULT '2025-12-12',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo_user`
--

CREATE TABLE `equipo_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `equipo_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rol_equipo` enum('lider','miembro') NOT NULL DEFAULT 'miembro',
  `fecha_asignacion` date NOT NULL DEFAULT '2025-12-12',
  `fecha_salida` date DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipo_user`
--

INSERT INTO `equipo_user` (`id`, `equipo_id`, `user_id`, `rol_equipo`, `fecha_asignacion`, `fecha_salida`, `activo`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 'miembro', '2025-12-12', NULL, 1, '2025-12-13 04:00:05', '2025-12-13 04:00:05'),
(3, 1, 1, 'miembro', '2025-12-28', NULL, 1, '2025-12-29 04:16:34', '2025-12-29 04:16:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_07_033053_add_role_to_users_table', 1),
(5, '2025_12_07_035847_create_perfil_empleados_table', 1),
(6, '2025_12_07_041501_create_empleados_table', 1),
(7, '2025_12_08_180529_create_user_documents_table', 1),
(8, '2025_12_08_181504_add_code_to_user_documents_table', 1),
(9, '2025_12_09_143827_add_estado_to_users_table', 1),
(10, '2025_12_09_150907_create_clientes_table', 1),
(11, '2025_12_09_150917_create_proyectos_table', 1),
(12, '2025_12_09_150923_create_tareas_table', 1),
(13, '2025_12_11_175136_create_presupuestos_table', 1),
(14, '2025_12_11_203015_create_clientes_table', 2),
(15, '2025_12_12_025245_create_cliente_proyecto_table', 3),
(16, '2025_12_12_144924_create_cotizaciones_table', 4),
(17, '2025_12_12_162353_create_cotizacion_items_table', 5),
(18, '2025_12_12_194753_create_cotizacion_proyecto_table', 6),
(19, '2025_12_12_210813_create_documentos_proyecto_table', 7),
(20, '2025_12_12_225251_create_equipos_tables', 8),
(21, '2025_12_29_000432_add_password_to_clientes_table', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_empleados`
--

CREATE TABLE `perfil_empleados` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `cargo` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `remuneracion` decimal(10,2) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `turno` varchar(255) DEFAULT NULL,
  `celular` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `carrera` varchar(255) DEFAULT NULL,
  `ciclo` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `perfil_empleados`
--

INSERT INTO `perfil_empleados` (`id`, `user_id`, `cargo`, `area`, `remuneracion`, `fecha_ingreso`, `turno`, `celular`, `direccion`, `carrera`, `ciclo`, `fecha_nacimiento`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Lima', 'Desarrollo de Software', 'Culminado', NULL, NULL, '2025-12-12 01:44:03', '2025-12-12 01:44:03'),
(2, 2, NULL, NULL, NULL, '2025-12-11', NULL, NULL, NULL, NULL, NULL, '2025-12-12', NULL, '2025-12-12 01:44:31', '2025-12-12 19:29:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proyecto_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `tipo_pago` enum('unico','mensual','bimestral','trimestral','semestral','anual') NOT NULL DEFAULT 'unico',
  `fecha_inicio` date NOT NULL DEFAULT curdate(),
  `fecha_fin` date DEFAULT NULL,
  `estado` enum('activo','finalizado','cancelado') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `presupuestos`
--

INSERT INTO `presupuestos` (`id`, `proyecto_id`, `nombre`, `precio`, `tipo_pago`, `fecha_inicio`, `fecha_fin`, `estado`, `created_at`, `updated_at`) VALUES
(2, 1, 'Hosting', 100.00, 'anual', '2025-12-28', '2026-12-28', 'activo', '2025-12-29 08:00:00', '2025-12-29 08:00:00'),
(3, 1, 'Servicio', 20.00, 'mensual', '2025-12-28', '2026-01-28', 'activo', '2025-12-29 08:00:26', '2025-12-29 08:00:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `nombre_proyecto` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `responsable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cliente_id` bigint(20) UNSIGNED DEFAULT NULL,
  `estado` enum('pendiente','en_progreso','pausado','finalizado','cancelado') NOT NULL DEFAULT 'pendiente',
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `fecha_cierre_real` date DEFAULT NULL,
  `presupuesto_asignado` decimal(12,2) DEFAULT NULL,
  `presupuesto_ejecutado` decimal(12,2) DEFAULT NULL,
  `lugar` varchar(255) DEFAULT NULL,
  `tipo_proyecto` varchar(255) DEFAULT NULL,
  `prioridad` varchar(255) DEFAULT NULL,
  `creado_por` bigint(20) UNSIGNED DEFAULT NULL,
  `actualizado_por` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id`, `codigo`, `nombre_proyecto`, `descripcion`, `responsable_id`, `cliente_id`, `estado`, `fecha_inicio`, `fecha_fin`, `fecha_cierre_real`, `presupuesto_asignado`, `presupuesto_ejecutado`, `lugar`, `tipo_proyecto`, `prioridad`, `creado_por`, `actualizado_por`, `created_at`, `updated_at`) VALUES
(1, 'PRJ-1765485943', 'SEPTHUM', '123', 1, NULL, 'pendiente', '2025-12-11', '2025-12-12', NULL, 1000.00, 120.00, 'Los Olivos', 'supervision', 'media', 1, NULL, '2025-12-12 01:45:43', '2025-12-29 08:00:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('vy54ufe33p3IDeGPJcZjMqd3ucHreM3eKPZZKY7H', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMTZsbUNxV1VQQzFhcnJ3bVh2NTRIR1BUNnh3MG1QWGpBMG04R2I2OCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm95ZWN0b3MiO3M6NToicm91dGUiO3M6MTU6InByb3llY3Rvcy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1766980503);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proyecto_id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('pendiente','en_progreso','completada') NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `proyecto_id`, `titulo`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, 'Inicio', 'Buena persona', 'completada', '2025-12-12 01:45:43', '2025-12-12 01:45:57'),
(2, 1, 'Planificación', NULL, 'pendiente', '2025-12-12 01:45:43', '2025-12-12 01:45:43'),
(3, 1, 'Ejecución', NULL, 'pendiente', '2025-12-12 01:45:43', '2025-12-12 01:45:43'),
(4, 1, 'Monitoreo y Control', NULL, 'completada', '2025-12-12 01:45:43', '2025-12-12 01:46:24'),
(5, 1, 'Cierre', NULL, 'completada', '2025-12-12 01:45:43', '2025-12-13 03:23:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rol` varchar(255) NOT NULL DEFAULT 'usuario',
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `rol`, `estado`) VALUES
(1, 'Administrador', 'crm@loudata.net.pe', NULL, '$2y$12$y59.yXfWn3dnDA//WZd8Ge42pfH01GcO2eb8Y6bojFlo6A.fv2WTW', NULL, '2025-12-11 20:43:18', '2025-12-12 01:44:03', 'administrador', 'activo'),
(2, 'Karito Juarez', 'test@example.com', NULL, '$2y$12$x/Bw9toJ0HlB6ePJpLNp3Oiv/C2xOMWV8ZLJyAYQLuSXN1VvyXc7.', NULL, '2025-12-12 01:44:31', '2025-12-12 01:44:31', 'supervisor', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_documents`
--

CREATE TABLE `user_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `uploaded_by` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_documents`
--

INSERT INTO `user_documents` (`id`, `user_id`, `name`, `code`, `file`, `date`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(1, 2, 'CERTIFICADO DE PRACTICAS', '1ZML3RL7', 'documents/Eff5pivHjK64BinQWKSBqSDcYrjOVTnGvJH9Hb1g.pdf', '2025-12-09', 'Administrador', '2025-12-12 01:44:51', '2025-12-12 01:44:51');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientes_codigo_unique` (`codigo`),
  ADD UNIQUE KEY `clientes_ruc_dni_unique` (`ruc_dni`),
  ADD KEY `clientes_creado_por_foreign` (`creado_por`),
  ADD KEY `clientes_actualizado_por_foreign` (`actualizado_por`);

--
-- Indices de la tabla `cliente_proyecto`
--
ALTER TABLE `cliente_proyecto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cliente_proyecto_cliente_id_proyecto_id_unique` (`cliente_id`,`proyecto_id`),
  ADD KEY `cliente_proyecto_proyecto_id_foreign` (`proyecto_id`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cotizaciones_codigo_unique` (`codigo`),
  ADD KEY `cotizaciones_cliente_id_foreign` (`cliente_id`);

--
-- Indices de la tabla `cotizacion_items`
--
ALTER TABLE `cotizacion_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizacion_items_cotizacion_id_foreign` (`cotizacion_id`);

--
-- Indices de la tabla `cotizacion_proyecto`
--
ALTER TABLE `cotizacion_proyecto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cotizacion_proyecto_proyecto_id_cotizacion_id_unique` (`proyecto_id`,`cotizacion_id`),
  ADD KEY `cotizacion_proyecto_cotizacion_id_foreign` (`cotizacion_id`);

--
-- Indices de la tabla `documentos_proyecto`
--
ALTER TABLE `documentos_proyecto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documentos_proyecto_proyecto_id_foreign` (`proyecto_id`),
  ADD KEY `documentos_proyecto_subido_por_foreign` (`subido_por`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `empleados_user_id_unique` (`user_id`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `equipos_codigo_unique` (`codigo`),
  ADD KEY `equipos_proyecto_id_foreign` (`proyecto_id`),
  ADD KEY `equipos_creado_por_foreign` (`creado_por`);

--
-- Indices de la tabla `equipo_proyecto`
--
ALTER TABLE `equipo_proyecto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `equipo_proyecto_equipo_id_proyecto_id_unique` (`equipo_id`,`proyecto_id`),
  ADD KEY `equipo_proyecto_proyecto_id_foreign` (`proyecto_id`);

--
-- Indices de la tabla `equipo_user`
--
ALTER TABLE `equipo_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `equipo_user_equipo_id_user_id_unique` (`equipo_id`,`user_id`),
  ADD KEY `equipo_user_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `perfil_empleados`
--
ALTER TABLE `perfil_empleados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `perfil_empleados_user_id_unique` (`user_id`);

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presupuestos_proyecto_id_foreign` (`proyecto_id`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `proyectos_codigo_unique` (`codigo`),
  ADD KEY `proyectos_responsable_id_foreign` (`responsable_id`),
  ADD KEY `proyectos_cliente_id_foreign` (`cliente_id`),
  ADD KEY `proyectos_creado_por_foreign` (`creado_por`),
  ADD KEY `proyectos_actualizado_por_foreign` (`actualizado_por`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tareas_proyecto_id_foreign` (`proyecto_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_documents_code_unique` (`code`),
  ADD KEY `user_documents_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cliente_proyecto`
--
ALTER TABLE `cliente_proyecto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cotizacion_items`
--
ALTER TABLE `cotizacion_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cotizacion_proyecto`
--
ALTER TABLE `cotizacion_proyecto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `documentos_proyecto`
--
ALTER TABLE `documentos_proyecto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `equipo_proyecto`
--
ALTER TABLE `equipo_proyecto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `equipo_user`
--
ALTER TABLE `equipo_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `perfil_empleados`
--
ALTER TABLE `perfil_empleados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_actualizado_por_foreign` FOREIGN KEY (`actualizado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `clientes_creado_por_foreign` FOREIGN KEY (`creado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `cliente_proyecto`
--
ALTER TABLE `cliente_proyecto`
  ADD CONSTRAINT `cliente_proyecto_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cliente_proyecto_proyecto_id_foreign` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD CONSTRAINT `cotizaciones_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cotizacion_items`
--
ALTER TABLE `cotizacion_items`
  ADD CONSTRAINT `cotizacion_items_cotizacion_id_foreign` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cotizacion_proyecto`
--
ALTER TABLE `cotizacion_proyecto`
  ADD CONSTRAINT `cotizacion_proyecto_cotizacion_id_foreign` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotizacion_proyecto_proyecto_id_foreign` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `documentos_proyecto`
--
ALTER TABLE `documentos_proyecto`
  ADD CONSTRAINT `documentos_proyecto_proyecto_id_foreign` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documentos_proyecto_subido_por_foreign` FOREIGN KEY (`subido_por`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `equipos_creado_por_foreign` FOREIGN KEY (`creado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `equipos_proyecto_id_foreign` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `equipo_proyecto`
--
ALTER TABLE `equipo_proyecto`
  ADD CONSTRAINT `equipo_proyecto_equipo_id_foreign` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipo_proyecto_proyecto_id_foreign` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `equipo_user`
--
ALTER TABLE `equipo_user`
  ADD CONSTRAINT `equipo_user_equipo_id_foreign` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipo_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `perfil_empleados`
--
ALTER TABLE `perfil_empleados`
  ADD CONSTRAINT `perfil_empleados_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD CONSTRAINT `presupuestos_proyecto_id_foreign` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_actualizado_por_foreign` FOREIGN KEY (`actualizado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `proyectos_creado_por_foreign` FOREIGN KEY (`creado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `proyectos_responsable_id_foreign` FOREIGN KEY (`responsable_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_proyecto_id_foreign` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `user_documents`
--
ALTER TABLE `user_documents`
  ADD CONSTRAINT `user_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
