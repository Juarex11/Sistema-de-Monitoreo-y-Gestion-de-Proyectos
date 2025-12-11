-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2025 a las 00:09:30
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
-- Base de datos: `sistema_monitoreo`
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

INSERT INTO `clientes` (`id`, `codigo`, `tipo_cliente`, `nombre_comercial`, `razon_social`, `ruc_dni`, `representante`, `telefono`, `telefono_alt`, `email`, `email_alt`, `direccion`, `ciudad`, `pais`, `actividad`, `estado_cliente`, `creado_por`, `actualizado_por`, `created_at`, `updated_at`) VALUES
(2, 'CLI-0001', 'empresa', 'TIENDA PRUEBAS', 'TIENDA PRUEBA', '7526262', 'Raaa', '981031226', '981031226', 'crm@loudata.net.pe', 'crm@loudata.net.pe', 'Lima', 'Lima', 'Perú', 'Pescado', 'activo', 1, 1, '2025-12-12 02:04:46', '2025-12-12 02:18:49'),
(3, 'CLI-0003', 'persona', 'Milenco Diaz', 'TIENDA PRUEBA', '22313123123', 'Raaa', '981031226', '981031226', 'crm@loudata.net.pe', 'crmaa@loudata.net.pe', 'Lima', 'Lima', 'Perú', 'Pescado', 'activo', 1, 1, '2025-12-12 02:19:20', '2025-12-12 03:05:50');

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
(14, '2025_12_11_203015_create_clientes_table', 2);

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
(2, 2, NULL, NULL, NULL, '2025-12-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-12 01:44:31', '2025-12-12 01:44:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proyecto_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `presupuestos`
--

INSERT INTO `presupuestos` (`id`, `proyecto_id`, `nombre`, `precio`, `created_at`, `updated_at`) VALUES
(1, 1, 'Supervisor', 10.00, '2025-12-12 01:46:07', '2025-12-12 01:46:07');

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
(1, 'PRJ-1765485943', 'SEPTHUM', '123', 1, NULL, 'pendiente', '2025-12-11', '2025-12-12', NULL, 1000.00, 10.00, 'Los Olivos', 'supervision', 'media', 1, NULL, '2025-12-12 01:45:43', '2025-12-12 01:46:07');

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
('2QY4b5PvAzxNqE0kBZkcXaRZXfSdURwEkuYRpffR', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaXhWbFlLS1NicXowc1M5RjhBMnc0Mm8zV0x4UWJPM3JVMzF3WWFkRSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvcHJveWVjdG9zLzEvZGF0YSI7czo1OiJyb3V0ZSI7czoxNDoicHJveWVjdG9zLmRhdGEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1765492153);

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
(5, 1, 'Cierre', NULL, 'pendiente', '2025-12-12 01:45:43', '2025-12-12 01:45:43');

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
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `empleados_user_id_unique` (`user_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `perfil_empleados`
--
ALTER TABLE `perfil_empleados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
