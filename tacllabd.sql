-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 04-11-2020 a las 03:59:54
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `taclla`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_proyecto` (IN `ent_id` INT, IN `jugador` VARCHAR(50), IN `proyec` VARCHAR(50), IN `fecha` DATE, IN `cli` VARCHAR(50), IN `proyecto` VARCHAR(50), IN `predio` VARCHAR(50), IN `municipio` VARCHAR(50))  BEGIN

UPDATE proyectos SET player = jugador, pryct = proyec, fecha = fecha, cliente = cli, proyecto = proyecto, predio = predio,
municipio = municipio

where id = ent_id;

 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `asignar_tarea` (IN `usu` INT, IN `id_proyecto` INT, IN `id_tarea` INT)  BEGIN


update detalle_de_proyectos set user_id=usu

where detalle_de_proyectos.proyecto_id = id_proyecto and 

detalle_de_proyectos.tarea_id=id_tarea;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `buscar_proyecto` (IN `parametro` INT)  BEGIN

select * from proyectos where id = parametro;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cambiar_estado` (IN `estado_par` INT, IN `id_proyecto` INT, IN `id_tarea` INT)  BEGIN


update detalle_de_proyectos set estado_id=estado_par

where detalle_de_proyectos.proyecto_id = id_proyecto and 

detalle_de_proyectos.tarea_id=id_tarea;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_plantilla` (IN `id_param` INT)  DELETE FROM plantillas WHERE id = id_param$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `esta` ()  BEGIN

select distinct  p.id, dt.estado_id, u.name, es.nombre_estado

from  proyectos as p,tipo_de_proyectos as t, detalle_de_proyectos as dt, users as u, estados as es 

where t.id = p.tipo_de_proyecto_id

and p.id= dt.proyecto_id and dt.estado_id=2 and dt.estado_id=1 and dt.user_id=u.id and dt.estado_id=es.id

union 

select  distinct  p.id, dt.estado_id, u.name, es.nombre_estado

from  proyectos as p,tipo_de_proyectos as t, detalle_de_proyectos as dt, users as u, estados as es 

where t.id = p.tipo_de_proyecto_id

and p.id= dt.proyecto_id and dt.estado_id=1   and dt.user_id=u.id and dt.estado_id=es.id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_log` (IN `usuario` VARCHAR(50), IN `modificacion` VARCHAR(255))  INSERT INTO logs (fecha,hora,usuario,modificacion) 
VALUES (NOW(),NOW(),usuario,modificacion)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_plantilla` (IN `entrada1` VARCHAR(10000), IN `entrada2` VARCHAR(10000), IN `entrada3` VARCHAR(10000))  INSERT INTO plantillas (dir,nombre_plantilla,link) 
VALUES (entrada1,entrada2,entrada3)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_tabla_configuracion` (IN `parametro1` BIGINT, IN `parametro2` BIGINT, IN `parametro3` BIGINT, IN `parametro4` BIGINT)  INSERT INTO detalle_de_proyectos (proyecto_id,tarea_id,estado_id,user_id)
VALUES (parametro1,parametro2,parametro3,parametro4)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_tarea` (IN `nombre_t` VARCHAR(50), IN `tipo_id` INT)  INSERT INTO tareas (nombre_tarea,tipo_de_proyecto_id) 
VALUES (nombre_t,tipo_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_tarea_area` (IN `nam` VARCHAR(255), IN `ar_id` INT)  INSERT INTO tareas (nombre_tarea, area_id) 
VALUES (nam, ar_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertar_tipo` (IN `name_t` VARCHAR(50))  INSERT INTO tipo_de_proyectos (nombre) 
VALUES (name_t)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insetar_proyecto` (IN `jugador` VARCHAR(50), IN `pryct` VARCHAR(50), IN `fecha` DATE, IN `cliente` VARCHAR(50), IN `proyecto` VARCHAR(50), IN `predio` VARCHAR(50), IN `municipio` VARCHAR(50), IN `tipo_de_proyect_id` BIGINT)  INSERT INTO proyectos (player,pryct,fecha,cliente,proyecto,predio,municipio,tipo_de_proyecto_id) 
VALUES (jugador,pryct,fecha,cliente,proyecto,predio,municipio,tipo_de_proyect_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `listar_proyectos` ()  BEGIN

select p.id, p.player, p.pryct, p.fecha, p.cliente, p.proyecto, p.predio, p.municipio, t.nombre from proyectos as p

join tipo_de_proyectos as t where t.id = p.tipo_de_proyecto_id;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `notificacion` ()  BEGIN
select count(*) from detalle_de_proyectos as de,


proyectos as pro,
tareas as ta,
estados as es,
users as us

join areas as ar on us.area_id=ar.id
 


where de.proyecto_id=pro.id
AND us.area_id=ar.id
AND de.tarea_id=ta.id
AND de.estado_id= es.id
AND de.user_id=us.id

AND de.user_id=24



AND de.estado_id!=3

ORDER BY ta.id

;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtener_ultimo_registro` ()  BEGIN

SELECT * FROM proyectos;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prueba` ()  BEGIN


select de.id, p.nombre_proyecto, ta.tarea_id as tarea, es.nombre_estado, u.name as usuario from  detalle_de_proyectos as de

   
 inner join tipo_de_proyecto_tareas as ta on de.tipo_de_proyecto_tarea_id=ta.id
  
 inner join proyectos as p on de.proyecto_id=p.id
 
 inner join users as u on de.user_id=u.id
 
 inner join estados as es on de.estado_id=es.id

 
 where u.id=23; 


 
 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prueba_4` (IN `para` INT)  BEGIN

IF para=2 THEN  select p.id, p.player, p.pryct, p.fecha, p.cliente, p.proyecto, p.predio, p.municipio, t.nombre , u.name, dt.estado_id

from  proyectos as p,tipo_de_proyectos as t, detalle_de_proyectos as dt, users as u 

where t.id = p.tipo_de_proyecto_id

and p.id= dt.proyecto_id and dt.estado_id=2 and dt.user_id=u.id;

    ELSEIF para=1 THEN select p.id, p.player, p.pryct, p.fecha, p.cliente, p.proyecto, p.predio, p.municipio, t.nombre , u.name, dt.estado_id

from  proyectos as p,tipo_de_proyectos as t, detalle_de_proyectos as dt, users as u 

where t.id = p.tipo_de_proyecto_id

and p.id= dt.proyecto_id and dt.estado_id=1 and dt.user_id=u.id and u.name!='default';

    ELSE IF  para=3 THEN  select p.id, p.player, p.pryct, p.fecha, p.cliente, p.proyecto, p.predio, p.municipio, t.nombre , u.name, dt.estado_id

from  proyectos as p,tipo_de_proyectos as t, detalle_de_proyectos as dt, users as u 

where t.id = p.tipo_de_proyecto_id

and p.id= dt.proyecto_id and dt.estado_id=3 and dt.user_id=u.id;
    
END IF; END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tareas_por_proyecto` (IN `proyecto_id` INT, IN `user_id` INT)  BEGIN
select pro.id as "proyecto_id", ta.id, pro.proyecto, ta.nombre_tarea,ar.nombre_area, es.nombre_estado, us.name from detalle_de_proyectos as de,


proyectos as pro,
tareas as ta,
estados as es,
users as us

join areas as ar on us.area_id=ar.id
 


where de.proyecto_id=pro.id
AND us.area_id=ar.id
AND de.tarea_id=ta.id
AND de.estado_id= es.id
AND de.user_id=us.id


AND de.proyecto_id=proyecto_id
AND de.user_id=user_id

ORDER BY ta.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tareas_por_proyecto2` (IN `Parametro_id` INT)  BEGIN
select pro.id as "proyecto_id", ta.id, pro.proyecto, ta.nombre_tarea,ar.nombre_area, es.nombre_estado, us.name from detalle_de_proyectos as de,


proyectos as pro,
tareas as ta,
estados as es,
users as us

join areas as ar on us.area_id=ar.id



where de.proyecto_id=pro.id
AND us.area_id=ar.id
AND de.tarea_id=ta.id
AND de.estado_id= es.id
AND de.user_id=us.id



AND de.proyecto_id=parametro_id

ORDER BY ta.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tareas_por_proyecto3` (IN `parametro` INT)  BEGIN


select pro.id as "proyecto_id", ta.id, pro.proyecto, ta.nombre_tarea, ar.nombre_area, es.nombre_estado, us.name from detalle_de_proyectos as de,

proyectos as pro,
estados as es,
users as us,
tareas as ta


join areas as ar on ta.area_id=ar.id
join tipo_de_proyectos as ti on ta.tipo_de_proyecto_id=ti.id


where de.proyecto_id=pro.id
AND de.estado_id=es.id
AND de.tarea_id=ta.id
AND de.user_id=us.id
AND de.proyecto_id=parametro

ORDER BY ta.id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tare_a` (IN `parametro_id` INT)  BEGIN

select t.nombre_tarea, a.nombre_area, ti.nombre from tareas as t

join areas as a on t.area_id=a.id
join tipo_de_proyectos as ti on t.tipo_de_proyecto_id=ti.id


where ti.id=parametro_id;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tipos_de_proyectos` ()  BEGIN

select * from tipo_de_proyectos;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `traer_areas` ()  BEGIN
select * from areas;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `traer_nombre_tareas` ()  BEGIN

select DISTINCT t.nombre_tarea, t.area_id from tareas as t;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `traer_plantillas` ()  BEGIN

select * from plantillas;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `traer_tareas` (IN `tipo_id` INT)  BEGIN

select t.id, t.nombre_tarea from tareas as t where t.tipo_de_proyecto_id = tipo_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `traer_tipo` ()  BEGIN

select * from tipo_de_proyectos;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id`, `nombre_area`, `created_at`, `updated_at`) VALUES
(1, 'comercial', '2020-10-19 03:51:33', '2020-10-19 03:51:34'),
(2, 'administrativa', '2020-10-19 03:51:40', '2020-10-19 03:51:41'),
(3, 'operaciones', '2020-10-19 03:52:04', '2020-10-19 03:52:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_de_proyectos`
--

CREATE TABLE `detalle_de_proyectos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `proyecto_id` bigint(20) UNSIGNED NOT NULL,
  `tarea_id` bigint(20) UNSIGNED NOT NULL,
  `estado_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_de_proyectos`
--

INSERT INTO `detalle_de_proyectos` (`id`, `proyecto_id`, `tarea_id`, `estado_id`, `user_id`, `created_at`, `updated_at`) VALUES
(279, 59, 1, 3, 25, NULL, NULL),
(280, 59, 2, 1, 25, NULL, NULL),
(281, 59, 3, 1, 24, NULL, NULL),
(282, 59, 4, 1, 23, NULL, NULL),
(283, 59, 5, 1, 24, NULL, NULL),
(284, 59, 6, 1, 25, NULL, NULL),
(285, 59, 7, 1, 25, NULL, NULL),
(286, 59, 8, 1, 25, NULL, NULL),
(287, 59, 9, 1, 25, NULL, NULL),
(288, 59, 10, 1, 25, NULL, NULL),
(289, 59, 11, 1, 25, NULL, NULL),
(290, 59, 12, 1, 25, NULL, NULL),
(291, 59, 13, 1, 25, NULL, NULL),
(292, 59, 14, 1, 25, NULL, NULL),
(293, 59, 15, 1, 25, NULL, NULL),
(294, 59, 16, 1, 25, NULL, NULL),
(295, 59, 17, 1, 25, NULL, NULL),
(296, 59, 18, 1, 25, NULL, NULL),
(297, 59, 19, 1, 25, NULL, NULL),
(298, 59, 20, 1, 25, NULL, NULL),
(299, 60, 65, 2, 21, NULL, NULL),
(300, 60, 66, 1, 21, NULL, NULL),
(301, 60, 67, 1, 25, NULL, NULL),
(302, 60, 68, 1, 21, NULL, NULL),
(303, 60, 69, 1, 21, NULL, NULL),
(304, 60, 70, 1, 21, NULL, NULL),
(305, 60, 71, 1, 21, NULL, NULL),
(306, 60, 72, 1, 21, NULL, NULL),
(307, 60, 73, 1, 21, NULL, NULL),
(308, 60, 74, 1, 21, NULL, NULL),
(309, 60, 75, 1, 21, NULL, NULL),
(310, 60, 76, 1, 21, NULL, NULL),
(311, 60, 77, 1, 21, NULL, NULL),
(312, 60, 78, 1, 21, NULL, NULL),
(313, 60, 79, 1, 21, NULL, NULL),
(314, 60, 80, 1, 21, NULL, NULL),
(315, 60, 81, 1, 21, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `nombre_estado`, `created_at`, `updated_at`) VALUES
(1, 'programado', NULL, NULL),
(2, 'proceso', NULL, NULL),
(3, 'finalizado', '2020-10-19 22:55:23', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `usuario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modificacion` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `logs`
--

INSERT INTO `logs` (`id`, `fecha`, `hora`, `usuario`, `modificacion`, `created_at`, `updated_at`) VALUES
(3, '2020-11-03', '17:00:21', 'Ariel', 'Actualizó un estado a programado', NULL, NULL),
(4, '2020-11-03', '17:02:26', 'Ariel', 'Actualizó un estado a finalizado', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(16, '2014_10_12_000000_create_users_table', 1),
(17, '2014_10_12_100000_create_password_resets_table', 1),
(18, '2019_08_19_000000_create_failed_jobs_table', 1),
(19, '2020_10_05_193630_create_type_of_projects_table', 1),
(20, '2020_10_06_000623_create_permission_tables', 1),
(34, '2014_09_15_000000_create_areas_table', 2),
(35, '2020_10_15_032813_create_estados_table', 2),
(36, '2020_10_15_033020_create_tareas_table', 2),
(37, '2020_10_15_033043_create_tipo_de_proyectos_table', 2),
(38, '2020_10_15_033110_create_proyectos_table', 2),
(39, '2020_10_15_033141_create_tipo_de_proyecto_tareas_table', 2),
(40, '2020_10_15_033220_create_detalle_de_proyectos_table', 2),
(46, '2014_09_18_174719_create_areas_table', 3),
(47, '2020_10_18_174533_create_estados_table', 3),
(48, '2020_10_18_174747_create_plantillas_table', 3),
(49, '2020_10_18_175011_create_logs_table', 3),
(50, '2020_10_18_175103_create_tipo_de_proyectos_table', 3),
(51, '2020_10_18_175140_create_proyectos_table', 3),
(52, '2020_10_18_175159_create_tareas_table', 3),
(53, '2020_10_18_175231_create_detalle_de_proyectos_table', 3),
(54, '2020_10_27_044513_create_logs_table', 4),
(55, '2020_10_29_021130_create_notifications_table', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(37, 'App\\User', 21),
(39, 'App\\User', 23),
(39, 'App\\User', 24),
(39, 'App\\User', 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(9, 'create permission', 'web', '2020-10-06 06:23:02', '2020-10-06 06:23:02'),
(10, 'read permissions', 'web', '2020-10-06 06:23:02', '2020-10-06 06:23:02'),
(11, 'update permission', 'web', '2020-10-06 06:23:02', '2020-10-06 06:23:02'),
(12, 'delete permission', 'web', '2020-10-06 06:23:02', '2020-10-06 06:23:02'),
(13, 'crear-usuario', 'web', '2020-10-07 21:29:09', '2020-10-07 21:29:09'),
(14, 'leer-usuarios', 'web', '2020-10-07 21:29:33', '2020-10-07 21:29:33'),
(15, 'actualizar-usuario', 'web', '2020-10-07 21:29:48', '2020-10-07 21:29:48'),
(16, 'eliminar-usuario', 'web', '2020-10-07 21:30:00', '2020-10-07 21:30:00'),
(17, 'crear-role', 'web', '2020-10-08 04:03:37', '2020-10-08 04:03:37'),
(18, 'leer-roles', 'web', '2020-10-08 04:03:50', '2020-10-08 04:03:50'),
(19, 'actualizar-role', 'web', '2020-10-08 04:04:03', '2020-10-08 04:04:03'),
(20, 'eliminar-role', 'web', '2020-10-08 04:04:10', '2020-10-08 04:04:10'),
(21, 'crear-proyecto', 'web', '2020-10-10 21:59:39', '2020-10-10 21:59:39'),
(22, 'editar-proyecto', 'web', '2020-10-10 22:01:02', '2020-10-10 22:01:02'),
(23, 'eliminar-proyecto', 'web', '2020-10-10 22:01:44', '2020-10-10 22:01:44'),
(24, 'ver-proyecto', 'web', '2020-10-10 22:01:51', '2020-10-10 22:01:51'),
(25, 'crear-tareas', 'web', '2020-10-11 02:20:08', '2020-10-11 02:20:08'),
(26, 'eliminar-tareas', 'web', '2020-10-11 02:20:36', '2020-10-11 02:20:36'),
(27, 'actualizar-tareas', 'web', '2020-10-11 02:20:45', '2020-10-11 02:20:45'),
(28, 'ver-tareas', 'web', '2020-10-11 02:20:53', '2020-10-11 02:20:53'),
(29, 'ver-log', 'web', '2020-10-11 02:36:22', '2020-10-11 02:36:22'),
(30, 'bajar-formatos', 'web', '2020-10-11 02:37:00', '2020-10-11 02:37:00'),
(31, 'actualizar-estado', 'web', '2020-10-22 23:27:53', '2020-10-22 23:27:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantillas`
--

CREATE TABLE `plantillas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_plantilla` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(10000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `plantillas`
--

INSERT INTO `plantillas` (`id`, `dir`, `nombre_plantilla`, `link`, `created_at`, `updated_at`) VALUES
(3, 'cotizacion.png', 'Plantilla de cotización', 'https://www.dropbox.com/home/5_SistemaTP2021/PlantillasParaDescargar/1_PlantillasAreaComercial?preview=MODELO2+++20123101_Cotizacion_Cliente_Proyecto.xlsx', NULL, NULL),
(5, 'presentacion.png', 'presentacion VV', 'https://www.dropbox.com/home/5_SistemaTP2021/PlantillasParaDescargar/1_PlantillasAreaComercial?preview=200903_Presentaci%C3%B3n_VV.pptx', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `player` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pryct` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `cliente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proyecto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `predio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `municipio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_de_proyecto_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id`, `player`, `pryct`, `fecha`, `cliente`, `proyecto`, `predio`, `municipio`, `tipo_de_proyecto_id`, `created_at`, `updated_at`) VALUES
(59, 'ESTEBAN BETÍN', '500', '2020-10-26', 'alejandro', 'linderos', 'cañahuate', 'chinú', 1, NULL, NULL),
(60, 'Santiago', '600', '2020-10-27', 'José', 'linderos2', 'carbonero', 'chinú', 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(37, 'SPR.TMG', 'web', '2020-10-10 22:04:48', '2020-10-10 22:04:48'),
(39, 'editor', 'web', '2020-10-11 02:38:26', '2020-10-11 02:38:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(9, 37),
(10, 37),
(11, 37),
(12, 37),
(13, 37),
(14, 37),
(15, 37),
(16, 37),
(17, 37),
(18, 37),
(19, 37),
(20, 37),
(21, 37),
(22, 37),
(23, 37),
(24, 37),
(25, 37),
(26, 37),
(27, 37),
(28, 37),
(29, 37),
(30, 37),
(31, 37),
(14, 39),
(18, 39),
(21, 39),
(22, 39),
(23, 39),
(24, 39),
(26, 39),
(28, 39),
(29, 39),
(31, 39);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_tarea` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_de_proyecto_id` bigint(20) UNSIGNED DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `nombre_tarea`, `tipo_de_proyecto_id`, `area_id`, `created_at`, `updated_at`) VALUES
(1, 'apertura', 1, 1, NULL, NULL),
(2, 'anticipo', 1, 2, NULL, NULL),
(3, 'oi', 1, 2, NULL, NULL),
(4, 'asignacion lider', 1, 3, NULL, NULL),
(5, 'plan operativo', 1, 3, NULL, NULL),
(6, 'control de gastos', 1, 3, NULL, NULL),
(7, 'trabajos de campo', 1, 3, NULL, NULL),
(8, 'informe de campo', 1, 3, NULL, NULL),
(9, 'backUp datos de campo', 1, 3, NULL, NULL),
(10, 'amarre geodesico', 1, 3, NULL, NULL),
(11, 'transferencia de archivos', 1, 3, NULL, NULL),
(12, 'fotogrametria', 1, 3, NULL, NULL),
(13, 'transf raster', 1, 3, NULL, NULL),
(14, 'gis', 1, 3, NULL, NULL),
(15, 'autocat', 1, 3, NULL, NULL),
(16, 'backUp', 1, 3, NULL, NULL),
(17, 'entrega', 1, 3, NULL, NULL),
(18, 'fac', 1, 2, NULL, NULL),
(19, 'pago', 1, 2, NULL, NULL),
(20, 'cierre', 1, 1, NULL, NULL),
(65, 'apertura', 4, 1, NULL, NULL),
(66, 'anticipo', 4, 2, NULL, NULL),
(67, 'oi', 4, 2, NULL, NULL),
(68, 'asignacion lider', 4, 3, NULL, NULL),
(69, 'plan operativo', 4, 3, NULL, NULL),
(70, 'control de gastos', 4, 3, NULL, NULL),
(71, 'fecha de campo', 4, 3, NULL, NULL),
(72, 'trabajos de campo', 4, 3, NULL, NULL),
(73, 'informe de campo', 4, 3, NULL, NULL),
(74, 'backUp', 4, 3, NULL, NULL),
(75, 'transferencia de archivos', 4, 3, NULL, NULL),
(76, 'montaje', 4, 3, NULL, NULL),
(77, 'upload', 4, 3, NULL, NULL),
(78, 'entrega', 4, 3, NULL, NULL),
(79, 'fac', 4, 2, NULL, NULL),
(80, 'pago', 4, 2, NULL, NULL),
(81, 'cierre', 4, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_de_proyectos`
--

CREATE TABLE `tipo_de_proyectos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_de_proyectos`
--

INSERT INTO `tipo_de_proyectos` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'fotogrametria', '2020-10-19 15:36:08', '2020-10-19 15:36:09'),
(4, 'Tour Virtual', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `area_id`) VALUES
(21, 'Ariel', 'ariel@taclla.com', NULL, '$2y$10$FpdE2l39bysN2VdIAv59AusU4w.pQfcPn9XSGvrzFuOiBWRK.U/nC', NULL, '2020-10-10 22:15:27', '2020-10-11 03:49:56', 1),
(23, 'editor', 'editor@gmail.com', NULL, '$2y$10$FbHw15gog84S/hUFTmloOe/KiCw4ZRSEw5Z9RxwqK7CQNMU0LmLIK', NULL, '2020-10-11 02:41:20', '2020-10-11 02:41:20', 3),
(24, 'ESTEBAN BETÍN', 'estebanbetinalvarez@gmail.com', NULL, '$2y$10$3xjEEIe0jnlu2gmifuooiusOIWlpqgI2OGmOY9SFi6UPN4K/OSBpm', NULL, '2020-10-21 10:24:43', '2020-10-29 11:55:50', 3),
(25, 'default', 'default@gmail.com', NULL, '$2y$10$4glugs./zrn7PVQLFExci.S.wXJaCqXEL0MaFF3YtFsBD3Rfi2yFC', NULL, '2020-10-31 09:07:39', '2020-10-31 09:07:39', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_de_proyectos`
--
ALTER TABLE `detalle_de_proyectos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_de_proyectos_proyecto_id_foreign` (`proyecto_id`),
  ADD KEY `detalle_de_proyectos_tarea_id_foreign` (`tarea_id`),
  ADD KEY `detalle_de_proyectos_estado_id_foreign` (`estado_id`),
  ADD KEY `detalle_de_proyectos_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plantillas`
--
ALTER TABLE `plantillas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proyectos_tipo_de_proyecto_id_foreign` (`tipo_de_proyecto_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tareas_tipo_de_proyecto_id_foreign` (`tipo_de_proyecto_id`),
  ADD KEY `FK_tareas_areas` (`area_id`);

--
-- Indices de la tabla `tipo_de_proyectos`
--
ALTER TABLE `tipo_de_proyectos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `FK_users_areas` (`area_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `detalle_de_proyectos`
--
ALTER TABLE `detalle_de_proyectos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `plantillas`
--
ALTER TABLE `plantillas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT de la tabla `tipo_de_proyectos`
--
ALTER TABLE `tipo_de_proyectos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_de_proyectos`
--
ALTER TABLE `detalle_de_proyectos`
  ADD CONSTRAINT `detalle_de_proyectos_estado_id_foreign` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`),
  ADD CONSTRAINT `detalle_de_proyectos_proyecto_id_foreign` FOREIGN KEY (`proyecto_id`) REFERENCES `proyectos` (`id`),
  ADD CONSTRAINT `detalle_de_proyectos_tarea_id_foreign` FOREIGN KEY (`tarea_id`) REFERENCES `tareas` (`id`),
  ADD CONSTRAINT `detalle_de_proyectos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_tipo_de_proyecto_id_foreign` FOREIGN KEY (`tipo_de_proyecto_id`) REFERENCES `tipo_de_proyectos` (`id`);

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `FK_tareas_areas` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `tareas_tipo_de_proyecto_id_foreign` FOREIGN KEY (`tipo_de_proyecto_id`) REFERENCES `tipo_de_proyectos` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_areas` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
