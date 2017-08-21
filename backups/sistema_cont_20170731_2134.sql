-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 31-07-2017 a las 19:33:25
-- Versión del servidor: 5.6.35-cll-lve
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sistema_cont`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE IF NOT EXISTS `cuentas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` text NOT NULL,
  `grupo` text NOT NULL,
  `nombre_cta` text NOT NULL,
  `tipo` text NOT NULL,
  `moneda` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `CODIGO_CTA` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=233 ;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`id`, `codigo`, `grupo`, `nombre_cta`, `tipo`, `moneda`) VALUES
(29, '110102', 'ACTIVO', 'BANCOS MONEDA NACIONAL', 'C', 'BS'),
(13, '1', 'ACTIVO', 'ACTIVO', 'G', 'BS'),
(18, '1101', 'ACTIVO', 'DISPONIBLE', 'T', 'BS'),
(24, '110101', 'ACTIVO', 'CAJA', 'C', 'BS'),
(17, '11', 'ACTIVO', 'ACTIVO CORRIENTE', 'R', 'BS'),
(28, '1101010003', 'ACTIVO', 'CAJA CHICA', 'S', 'BS'),
(26, '1101010001', 'ACTIVO', 'CAJA M/N', 'S', 'BS'),
(27, '1101010002', 'ACTIVO', 'CAJA M/E', 'S', '$US'),
(30, '1101020001', 'ACTIVO', 'BANCO UNION 1-16273950 M/N', 'S', 'BS'),
(31, '1101020002', 'ACTIVO', 'BANCO FIE 4000-1385862 M/N', 'S', 'BS'),
(32, '1101020003', 'ACTIVO', 'BANCO ECONOMICO 2051-604364 M/N', 'S', 'BS'),
(33, '110103', 'ACTIVO', 'BANCOS MONEDA EXTRANJERA', 'C', ''),
(34, '1101030001', 'ACTIVO', 'BANCO UNION 2-19488473 M/E', 'S', '$US'),
(35, '1102', 'ACTIVO', 'EXIGIBLE', 'T', 'BS'),
(36, '110201', 'ACTIVO', 'CUENTAS A COBRAR M/N', 'C', 'BS'),
(37, '1102010001', 'ACTIVO', 'CUENTAS A COBRAR M/N', 'S', 'BS'),
(38, '1102020001', 'ACTIVO', 'CUENTAS POR COBRAR M/E', 'S', '$US'),
(39, '110202', 'ACTIVO', 'CUENTAS POR COBRAR M/E', 'C', '$US'),
(40, '110205', 'ACTIVO', 'ENTREGA FONDOS A RENDIR', 'C', 'BS'),
(41, '1102050001', 'ACTIVO', 'ENTREGA FONDOS A RENDIR M/N', 'S', 'BS'),
(42, '110209', 'ACTIVO', 'ANTICIPOS AL PERSONAL', 'C', 'BS'),
(43, '1102090001', 'ACTIVO', 'ANTICIPO  AL PERSONAL', 'S', 'BS'),
(44, '110210', 'ACTIVO', 'ANTICIPO A CUENTA UTILIDADES SOCIOS', 'C', 'BS'),
(45, '110211', 'ACTIVO', 'PRESTAMOS A SOCIOS', 'C', 'BS'),
(46, '110212', 'ACTIVO', 'PRESTAMOS AL PERSONAL', 'C', 'BS'),
(47, '1102120001', 'ACTIVO', 'PRESTAMOS AL PERSONAL', 'S', 'BS'),
(48, '110213', 'ACTIVO', 'PRESTAMOS VARIOS', 'C', 'BS'),
(49, '110220', 'ACTIVO', 'IMPUESTO IVA CREDITO FISCAL', 'C', 'BS'),
(50, '1102200001', 'ACTIVO', 'IMPUESTO IVA CREDITO FISCAL', 'S', 'BS'),
(51, '1102200002', 'ACTIVO', 'CREDITO FISCAL-IVA POR RECUPERAR', 'S', 'BS'),
(52, '110221', 'ACTIVO', 'IMPUESTO A LAS UTILIDADES', 'C', 'BS'),
(53, '1102210001', 'ACTIVO', 'I.U.E. POR COMPENSAR', 'S', 'BS'),
(54, '1103', 'ACTIVO', 'INVENTARIOS', 'T', 'BS'),
(55, '110301', 'ACTIVO', 'INVENTARIO DE MERCADERIAS', 'C', 'BS'),
(56, '1103010001', 'ACTIVO', 'INVENTARIO DE MERCADERIAS', 'S', 'BS'),
(57, '1105000000', 'ACTIVO', 'MERCADERIAS EN TRANSITO', 'T', 'BS'),
(58, '110501', 'ACTIVO', 'MERCADERIAS EN TRANSITO', 'C', 'BS'),
(59, '1105010001', 'ACTIVO', 'MERCADERIAS EN TRANSITO', 'S', 'BS'),
(60, '12', 'ACTIVO', 'ACTIVO NO CORRIENTE', 'R', 'BS'),
(61, '1201', 'ACTIVO', 'INVERSIONES', 'T', 'BS'),
(62, '120101', 'ACTIVO', 'INVERSIONES', 'C', 'BS'),
(63, '1202', 'ACTIVO', 'ACTIVO FIJO', 'T', 'BS'),
(64, '120201', 'ACTIVO', 'TERRENOS', 'C', 'BS'),
(65, '1202010001', 'ACTIVO', 'TERRENOS', 'S', 'BS'),
(66, '120202', 'ACTIVO', 'EDIFICIOS Y CONSTRUCCIONES', 'C', 'BS'),
(67, '1202020001', 'ACTIVO', 'EDIFICIOS Y CONSTRUCCIONES', 'S', 'BS'),
(68, '120203', 'ACTIVO', 'DEP. ACUM. EDIFICIOS Y CONSTRUCCIONES', 'C', 'BS'),
(69, '1202030001', 'ACTIVO', 'DEP. ACUM. EDIFICIOS Y CONSTRUCCIONES', 'S', 'BS'),
(70, '120204', 'ACTIVO', 'MUEBLES Y ENSERES', 'C', 'BS'),
(71, '1202040001', 'ACTIVO', 'MUEBLES Y ENSERES', 'S', 'BS'),
(72, '120205', 'ACTIVO', 'DEP. ACUM. MUEBLES Y ENSERES', 'C', 'BS'),
(73, '1202050001', 'ACTIVO', 'DEP. ACUM. MUEBLES Y ENSERES', 'S', 'BS'),
(74, '120206', 'ACTIVO', 'MAQUINARIA Y EQUIPO', 'C', 'BS'),
(75, '1202060001', 'ACTIVO', 'MAQUINARIA Y EQUIPO', 'S', 'BS'),
(76, '120207', 'ACTIVO', 'DEP. ACUM. MAQUINARIA Y EQUIPO', 'C', 'BS'),
(77, '1202070001', 'ACTIVO', 'DEP. ACUM. MAQUINARIA Y EQUIPO', 'S', 'BS'),
(78, '120208', 'ACTIVO', 'VEHICULOS', 'C', 'BS'),
(79, '1202080001', 'ACTIVO', 'VEHICULOS', 'S', 'BS'),
(80, '120209', 'ACTIVO', 'DEP. ACUM. VEHICULOS', 'C', 'BS'),
(81, '1202090001', 'ACTIVO', 'DEP. ACUM. VEHICULOS', 'S', 'BS'),
(82, '120210', 'ACTIVO', 'HERRAMIENTAS', 'C', 'BS'),
(83, '1202100001', 'ACTIVO', 'HERRAMIENTAS', 'S', 'BS'),
(84, '120211', 'ACTIVO', 'DEP. ACUM. HERRAMIENTAS', 'C', 'BS'),
(85, '1202110001', 'ACTIVO', 'DEP. ACUM. HERRAMIENTAS', 'S', 'BS'),
(86, '120212', 'ACTIVO', 'EQUIPOS DE COMPUTACION', 'C', 'BS'),
(87, '1202120001', 'ACTIVO', 'EQUIPOS DE COMPUTACION', 'S', 'BS'),
(88, '120213', 'ACTIVO', 'DEP. ACUM. EQUIPOS DE COMPUTACION', 'C', 'BS'),
(89, '1202130001', 'ACTIVO', 'DEP. ACUM. EQUIPOS DE COMPUTACION', 'S', 'BS'),
(90, '1203', 'ACTIVO', 'ACTIVO DIFERIDO', 'T', 'BS'),
(91, '120301', 'ACTIVO', 'GASTOS PAGADOS POR ADELANTADO', 'C', 'BS'),
(92, '1203010001', 'ACTIVO', 'GASTOS PAGADOS POR ADELANTADO', 'S', 'BS'),
(93, '120302', 'ACTIVO', 'GASTOS DE ORGANIZACION', 'C', 'BS'),
(94, '1203020001', 'ACTIVO', 'GASTOS DE ORGANIZACION', 'S', 'BS'),
(95, '2', 'PASIVO', 'PASIVO', 'G', 'BS'),
(96, '21', 'PASIVO', 'PASIVO CORRIENTE', 'R', 'BS'),
(97, '2101', 'PASIVO', 'PASIVO EXIGIBLE', 'T', 'BS'),
(98, '210101', 'PASIVO', 'CUENTAS POR PAGAR M/N', 'C', 'BS'),
(99, '2101010001', 'PASIVO', 'CUENTAS POR PAGAR M/N', 'S', 'BS'),
(100, '210102', 'PASIVO', 'CUENTAS POR PAGAR M/E', 'C', '$US'),
(101, '2101020001', 'PASIVO', 'CUENTAS POR PAGAR M/E', 'S', '$US'),
(102, '210103', 'PASIVO', 'PROVEEDORES EXTERIOR POR PAGAR', 'C', 'BS'),
(103, '2101030001', 'PASIVO', 'PROVEEDORES POR PAGAR M/E', 'S', '$US'),
(104, '210104', 'PASIVO', 'PROVEEDORES LOCALES POR PAGAR', 'C', 'BS'),
(105, '2101040001', 'PASIVO', 'CALANCHA Y RAMIREZ SRL', 'S', 'BS'),
(106, '210106', 'PASIVO', 'SUELDOS Y SALARIOS POR PAGAR', 'C', 'BS'),
(107, '2101060001', 'PASIVO', 'SUELDOS Y SALARIOS POR PAGAR', 'S', 'BS'),
(108, '210107', 'PASIVO', 'AGUINALDOS POR PAGAR', 'C', 'BS'),
(109, '2101070001', 'PASIVO', 'AGUINALDOS POR PAGAR', 'S', 'BS'),
(110, '210108', 'PASIVO', 'BENEFICIOS SOCIALES Y OTROS POR PAGAR', 'C', 'BS'),
(111, '2101080001', 'PASIVO', 'BENEFICIOS SOCIALES Y OTROS POR PAGAR', 'S', 'BS'),
(112, '210110', 'PASIVO', 'HONORARIOS PROFESIONALES POR PAGAR', 'C', 'BS'),
(113, '2101100001', 'PASIVO', 'HONORARIOS PROFESIONALES POR PAGAR', 'S', 'BS'),
(114, '210120', 'PASIVO', 'IMPUESTO IVA DEBITO FISCAL', 'C', 'BS'),
(115, '2101200001', 'PASIVO', 'IMPUESTO IVA DEBITO FISCAL', 'S', 'BS'),
(116, '210121', 'PASIVO', 'IMPUESTO A LAS UTILIDADES', 'C', 'BS'),
(117, '2101210001', 'PASIVO', 'I.U.E. POR PAGAR', 'S', 'BS'),
(118, '210125', 'PASIVO', 'IMPUESTOS Y PATENTES POR PAGAR', 'C', 'BS'),
(121, '2101250001', 'PASIVO', 'IMPUESTO A LAS TRANSACCIONES POR PAGAR', 'S', 'BS'),
(122, '2101250002', 'PASIVO', 'IMPUESTO REGIMEN COMPLEMENTARIO RC-IVA', 'S', 'BS'),
(123, '2101250003', 'PASIVO', 'I.U.E. RETENCIONES POR PAGAR (SERVICIOS)', 'S', 'BS'),
(124, '2101250004', 'PASIVO', 'I.T. RETENCIONES POR PAGAR (SERVICIOS)', 'S', 'BS'),
(125, '2101250005', 'PASIVO', 'I.U.E. RETENCIONES POR PAGAR (COMPRAS)', 'S', 'BS'),
(126, '2101250006', 'PASIVO', 'I.T. RETENCIONES POR PAGAR (COMPRAS)', 'S', 'BS'),
(127, '2101250007', 'PASIVO', 'IMPUESTOS SOBRE INMUEBLES POR PAGAR', 'S', 'BS'),
(128, '2101250008', 'PASIVO', 'PATENTES MUNICIPALES POR PAGAR', 'S', 'BS'),
(129, '210126', 'PASIVO', 'CARGAS SOCIALES POR PAGAR', 'C', 'BS'),
(130, '2101260001', 'PASIVO', 'CAJA PETROLERA DE SALUD', 'S', 'BS'),
(131, '2101260002', 'PASIVO', 'A.F.P. FUTURO DE BOLIVIA', 'S', 'BS'),
(132, '2101260003', 'PASIVO', 'A.F.P. BBV PREVISION', 'S', 'BS'),
(133, '2101260006', 'PASIVO', 'FONVIS', 'S', 'BS'),
(134, '2101260010', 'PASIVO', 'OTRAS CARGAS SOCIALES POR PAGAR', 'S', 'BS'),
(135, '22', 'PASIVO', 'PASIVO NO CORRIENTE', 'R', 'BS'),
(136, '2201', 'PASIVO', 'PASIVO EXIGIBLE A LARGO PLAZO', 'T', 'BS'),
(137, '220101', 'PASIVO', 'OBLIGACIONES FINANCIERAS', 'C', 'BS'),
(138, '2201010001', 'PASIVO', 'PRESTAMOS HIPOTECARIOS', 'S', 'BS'),
(139, '2201010002', 'PASIVO', 'PRESTAMOS DOCUMENTARIOS', 'S', 'BS'),
(140, '2210', 'PASIVO', 'PREVISIONES Y PROVISIONES', 'T', 'BS'),
(141, '221001', 'PASIVO', 'PREVISIONES Y PROVISIONES', 'C', 'BS'),
(142, '2210010001', 'PASIVO', 'PREVISION BENEFICIOS SOCIALES', 'S', 'BS'),
(146, '2210010002', 'PASIVO', 'PROVISION AGUINALDOS', 'S', 'BS'),
(147, '3', 'PATRIMONIO', 'PATRIMONIO', 'G', 'BS'),
(148, '31', 'PATRIMONIO', 'PATRIMONIO', 'R', 'BS'),
(149, '3101', 'PATRIMONIO', 'PATRIMONIO', 'T', 'BS'),
(150, '310101', 'PATRIMONIO', 'CAPITAL SOCIAL', 'C', 'BS'),
(151, '3101010001', 'PATRIMONIO', 'CAPITAL', 'S', 'BS'),
(152, '310102', 'PATRIMONIO', 'APORTES POR CAPITALIZAR', 'C', 'BS'),
(153, '310103', 'PATRIMONIO', 'AJUSTE DE CAPITAL', 'C', 'BS'),
(154, '3101030001', 'PATRIMONIO', 'AJUSTE DE CAPITAL', 'S', 'BS'),
(155, '3102', 'PATRIMONIO', 'RESERVAS', 'T', 'BS'),
(156, '310201', 'PATRIMONIO', 'RESERVA LEGAL', 'C', 'BS'),
(157, '3102010001', 'PATRIMONIO', 'RESERVA LEGAL', 'S', 'BS'),
(158, '310202', 'PATRIMONIO', 'RESERVA PARA REVALUO ACTIVO FIJO', 'C', 'BS'),
(159, '3102020001', 'PATRIMONIO', 'RESERVA PARA REVALUO ACTIVO FIJO', 'S', 'BS'),
(160, '310203', 'PATRIMONIO', 'AJUSTE DE RESERVAS PATRIMONIALES', 'C', 'BS'),
(161, '3102030001', 'PATRIMONIO', 'AJUSTE DE RESERVAS PATRIMONIALES', 'S', 'BS'),
(162, '3103', 'PATRIMONIO', 'AJUSTES AL PATRIMONIO', 'T', 'BS'),
(163, '310301', 'PATRIMONIO', 'AJUSTE GLOBAL DEL PATRIMONIO', 'C', 'BS'),
(164, '3103010001', 'PATRIMONIO', 'AJUSTE GLOBAL DEL PATRIMONIO', 'S', 'BS'),
(165, '3104', 'PATRIMONIO', 'RESULTADOS', 'T', 'BS'),
(166, '310401', 'PATRIMONIO', 'RESULTADOS ACUMULADOS', 'C', 'BS'),
(178, '3104010001', 'PATRIMONIO', 'RESULTADOS ACUMULADOS', 'S', 'BS'),
(179, '310402', 'PATRIMONIO', 'RESULTADOS DEL EJERCICIO', 'C', 'BS'),
(180, '3104020001', 'PATRIMONIO', 'RESULTADOS DEL EJERCICIO', 'S', 'BS'),
(181, '4', 'INGRESO', 'INGRESOS', 'G', 'BS'),
(182, '41', 'INGRESO', 'INGRESOS', 'R', 'BS'),
(183, '4101', 'INGRESO', 'INGRESOS OPERATIVOS', 'T', 'BS'),
(184, '410101', 'INGRESO', 'VENTAS Y/O SERVICIOS', 'C', 'BS'),
(185, '4101010001', 'INGRESO', 'VENTAS Y/O SERVICIOS', 'S', 'BS'),
(186, '4102', 'INGRESO', 'INGRESOS NO OPERATIVOS', 'T', 'BS'),
(188, '4102010001', 'INGRESO', 'OTROS INGRESOS', 'S', 'BS'),
(187, '410201', 'INGRESO', 'OTROS INGRESOS', 'C', 'BS'),
(189, '4103', 'INGRESO', 'PRODUCTOS FINANCIEROS', 'T', 'BS'),
(190, '410301', 'INGRESO', 'PRODUCTOS FINANCIEROS', 'C', 'BS'),
(191, '4103010001', 'INGRESO', 'INTERESES GANADOS', 'S', 'BS'),
(192, '4110', 'INGRESO', 'INGRESOS NO MONETARIOS', 'T', 'BS'),
(193, '411001', 'INGRESO', 'INGRESOS NO MONETARIOS', 'C', 'BS'),
(194, '4110010001', 'INGRESO', 'AJUSTE POR INFLACION Y TENENCIA DE BIENES', 'S', 'BS'),
(195, '4110010002', 'INGRESO', 'AJUSTE DIFERENCIA DE CAMBIO', 'S', 'BS'),
(196, '4110010003', 'INGRESO', 'MANTENIMIENTO DE VALOR', 'S', 'BS'),
(197, '5', 'EGRESO', 'EGRESOS', 'G', 'BS'),
(198, '51', 'EGRESO', 'GASTOS OPERATIVOS', 'R', 'BS'),
(199, '5101', 'EGRESO', 'COSTOS DE VENTAS', 'T', 'BS'),
(200, '510101', 'EGRESO', 'COSTOS DE VENTAS Y/O SERVICIOS', 'C', 'BS'),
(201, '5101010001', 'EGRESO', 'COSTOS DE VENTAS Y/O SERVICIOS', 'S', 'BS'),
(202, '5101010002', 'EGRESO', 'GASTOS PORTUARIOS-ASPB', 'S', 'BS'),
(203, '5102', 'EGRESO', 'GASTOS ADMINISTRATIVOS', 'T', 'BS'),
(204, '510201', 'EGRESO', 'REMUNERACIONES', 'C', 'BS'),
(205, '5102010001', 'EGRESO', 'SUELDOS Y SALARIOS', 'S', 'BS'),
(206, '5102010002', 'EGRESO', 'AGUINALDOS', 'S', 'BS'),
(207, '5102010003', 'EGRESO', 'BENEFICIOS SOCIALES', 'S', 'BS'),
(208, '5102010004', 'EGRESO', 'DESAHUCIOS', 'S', 'BS'),
(209, '5102010005', 'EGRESO', 'PRIMAS Y BONOS VARIOS', 'S', 'BS'),
(210, '5102010006', 'EGRESO', 'VACACIONES', 'S', 'BS'),
(211, '5102010007', 'EGRESO', 'HONORARIOS PROFESIONALES', 'S', 'BS'),
(212, '510202', 'EGRESO', 'IMPUESTOS, PATENTES Y CARGAS SOCIALES', 'C', 'BS'),
(213, '5102020001', 'EGRESO', 'IMPUESTO A LAS UTILIDADES', 'S', 'BS'),
(214, '5102020002', 'EGRESO', 'IMPUESTO A LAS TRANSACCIONES', 'S', 'BS'),
(215, '5102020003', 'EGRESO', 'IMPUESTO A LAS TRANSFERENCIAS', 'S', 'BS'),
(216, '5102020006', 'EGRESO', 'MULTAS E INTERESES SOBRE IMPUESTOS', 'S', 'BS'),
(217, '5102020010', 'EGRESO', 'PATENTES MUNICIPALES', 'S', 'BS'),
(218, '5102020020', 'EGRESO', 'CARGAS SOCIALES', 'S', 'BS'),
(219, '510203', 'EGRESO', 'ALQUILERES Y MANTENIMIENTOS', 'C', 'BS'),
(220, '5102030001', 'EGRESO', 'ALQUILER DE OFICINAS', 'S', 'BS'),
(221, '5102030002', 'EGRESO', 'ALQUILER DE VEHICULOS', 'S', 'BS'),
(222, '5102030010', 'EGRESO', 'MANTENIMIENTO DE OFICINAS', 'S', 'BS'),
(223, '5102030011', 'EGRESO', 'MANTENIMIENTO DE VEHICULOS', 'S', 'BS'),
(224, '510204', 'EGRESO', 'SERVICIOS BASICOS', 'C', 'BS'),
(225, '5102040001', 'EGRESO', 'SERVICIO DE ENERGIA ELECTRICA', 'S', 'BS'),
(226, '5102040002', 'EGRESO', 'SERVICIO DE AGUA', 'S', 'BS'),
(227, '5102040003', 'EGRESO', 'SERVICIO DE CORREO Y COURIER', 'S', 'BS'),
(228, '5102040004', 'EGRESO', 'SERVICIO DE INTERNET', 'S', 'BS'),
(229, '5102040005', 'EGRESO', 'SERVICIO DE LIMPIEZA', 'S', 'BS'),
(230, '5102040006', 'EGRESO', 'SERVICIO DE REFRIGERIO', 'S', 'BS'),
(231, '5102040007', 'EGRESO', 'SERVICIO DE SEGURIDAD', 'S', 'BS'),
(232, '5102040008', 'EGRESO', 'SERVICIO DE TELEFONIA - COTEL', 'S', 'BS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE IF NOT EXISTS `detalle_factura` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo_prod` text NOT NULL,
  `descripcion` text NOT NULL,
  `precio_unit` double NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dosificacion`
--

CREATE TABLE IF NOT EXISTS `dosificacion` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ntramite` text NOT NULL,
  `nautorizacion` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `llave` text NOT NULL,
  `fecha_fin` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE IF NOT EXISTS `facturas` (
  `codigo_fac` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nfactura` int(11) NOT NULL,
  `nit` text NOT NULL,
  `nombre` text NOT NULL,
  `fecha` date NOT NULL,
  `totalp` double NOT NULL,
  `descuento` double NOT NULL,
  `totalf` double NOT NULL,
  `codigo_ctrl` text NOT NULL,
  `estado` text NOT NULL,
  `id_dosificacion` bigint(20) NOT NULL,
  PRIMARY KEY (`codigo_fac`),
  UNIQUE KEY `codigo_fac` (`codigo_fac`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operacion`
--

CREATE TABLE IF NOT EXISTS `operacion` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cod_cuenta` text NOT NULL,
  `debeb` double NOT NULL,
  `haberb` double NOT NULL,
  `debed` double NOT NULL,
  `haberd` double NOT NULL,
  `id_transaccion` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operacion_a`
--

CREATE TABLE IF NOT EXISTS `operacion_a` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cod_cuenta` text NOT NULL,
  `debeb` double NOT NULL,
  `haberb` double NOT NULL,
  `debed` double NOT NULL,
  `haberd` double NOT NULL,
  `id_transaccion` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `codigo_prod` text NOT NULL,
  `producto` text NOT NULL,
  `marca` text NOT NULL,
  `medida` text NOT NULL,
  `modelo` text NOT NULL,
  `descripcion` text NOT NULL,
  `precio1` double NOT NULL,
  `precio2` double NOT NULL,
  `precio3` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_trans`
--

CREATE TABLE IF NOT EXISTS `tipo_trans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_transaccion` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tipo_trans`
--

INSERT INTO `tipo_trans` (`id`, `tipo_transaccion`) VALUES
(1, 'INGRESO'),
(2, 'EGRESO'),
(3, 'DIARIO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE IF NOT EXISTS `transacciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nro_comprobante` int(11) NOT NULL,
  `nro_tipo_comprobante` int(11) NOT NULL,
  `fk_tipo_transaccion` bigint(20) NOT NULL,
  `fecha` date NOT NULL,
  `tipo_cambio` double NOT NULL,
  `ca` char(1) NOT NULL,
  `glosa` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_cont`
--

CREATE TABLE IF NOT EXISTS `usuario_cont` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NOMBRE` text CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `CI` text NOT NULL,
  `CEL` text NOT NULL,
  `USUARIO` text CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `PASS` text NOT NULL,
  `TIPO` int(1) NOT NULL,
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `ID_2` (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `usuario_cont`
--

INSERT INTO `usuario_cont` (`ID`, `NOMBRE`, `CI`, `CEL`, `USUARIO`, `PASS`, `TIPO`) VALUES
(1, 'JAVIER IVAN CAMPUZANO', '3469942', '77217086', 'JICC', '7171', 1),
(17, 'NANCY QUISPE', '6097088', '76563272', 'QNANCY', '1234', 1),
(18, 'MONICA LUNA', '', '69860703', 'LMONICA', '4321', 0),
(19, 'SAUL QUIROGA', '', '77711582', 'SQUIROGA', '1234', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
