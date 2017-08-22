-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 21-08-2017 a las 21:17:25
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
-- Estructura de tabla para la tabla `1operaciones`
--

CREATE TABLE IF NOT EXISTS `1operaciones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_cuenta` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debe` double DEFAULT NULL,
  `haber` double DEFAULT NULL,
  `fk_transaccion` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=46 ;

--
-- Volcado de datos para la tabla `1operaciones`
--

INSERT INTO `1operaciones` (`id`, `fk_cuenta`, `descripcion`, `debe`, `haber`, `fk_transaccion`) VALUES
(19, '92', NULL, 26964.07, 0, 12),
(20, '30', NULL, 0, 26964.07, 12),
(21, '41', NULL, 28054.7, 0, 13),
(22, '30', NULL, 0, 28054.7, 13),
(23, '280', NULL, 633.56, 0, 14),
(24, '30', NULL, 0, 633.56, 14),
(25, '121', NULL, 3960, 0, 15),
(26, '30', NULL, 0, 3960, 15),
(27, '41', NULL, 4788.6, 0, 16),
(28, '30', NULL, 0, 4788.6, 16),
(29, '211', NULL, 50000, 0, 17),
(30, '31', NULL, 0, 45000, 17),
(31, '32', NULL, 0, 5000, 17),
(32, '92', NULL, 500, 0, 18),
(33, '30', NULL, 0, 500, 18),
(34, '59', NULL, 25543.2, 0, 19),
(35, '269', NULL, 857.5, 0, 19),
(36, '275', NULL, 50.45, 0, 19),
(37, '215', NULL, 66.15, 0, 19),
(38, '32', NULL, 0, 26451.15, 19),
(39, '32', NULL, 0, 66.15, 19),
(40, '59', NULL, 22355.66, 0, 20),
(41, '269', NULL, 857.5, 0, 20),
(42, '275', NULL, 45.87, 0, 20),
(43, '215', NULL, 58.13, 0, 20),
(44, '32', NULL, 0, 23259.03, 20),
(45, '32', NULL, 0, 58.13, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `1transacciones`
--

CREATE TABLE IF NOT EXISTS `1transacciones` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Volcado de datos para la tabla `1transacciones`
--

INSERT INTO `1transacciones` (`id`, `nro_comprobante`, `nro_tipo_comprobante`, `fk_tipo_transaccion`, `fecha`, `tipo_cambio`, `ca`, `glosa`) VALUES
(13, 3, 1, 2, '2017-01-17', 0, '', 'CANCELACION A CUENTA(SUELDOS Y HONORARIOS DIC/16) CHEQUE 503'),
(12, 2, 1, 2, '2017-01-12', 0, '', 'CANCELACION A CUENTA(AGENCIA ADUANERA CALANCHA Y RAMIREZ, DESADUANIZACION E-8), CHEQUE 500'),
(11, 11, 1, 1, '2017-01-09', 0, '', 'CANCELACION A CUENTA(SERVICIOS TELEFONICOS FIJO-MOVIL NOV/16) CHEQUE 499'),
(14, 4, 1, 2, '2017-01-17', 0, '', 'DHL, CANCELACION FACT 1266 SERVICIO COURIER DIC/16, CHEQUE 505'),
(15, 5, 1, 2, '2017-01-24', 0, '', 'SIN, CANCELACION IMPUESTO I.T.F. F-400 DIC/16, CHEQUE 512'),
(16, 6, 1, 2, '2017-01-26', 0, '', 'CANCELACION A CUENTA(AFP TLC-SND Y CPS TLC NOV-DIC/16), CHEQUE 516'),
(17, 7, 1, 2, '2017-01-25', 0, '', 'JUANN AYOROA, CANCELACION HONORARIOS DIC/16 OP 19 ENERO'),
(18, 8, 1, 2, '2017-01-26', 0, '', 'LADISLAO FRANCO, A CUENTA ELABORA ROPA DE TRABAJO , CHEQUE 517'),
(19, 9, 1, 2, '2017-01-31', 0, '', 'LICHUANG, 1ER ENVIO GIRO COMPRA LLANTAS 11 ENE'),
(20, 10, 1, 2, '2017-01-31', 0, '', 'LINGLONG, 2DO ENVIO GIRO COMPRA LLANTAS 27 ENE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nit` text NOT NULL,
  `razon_social` text NOT NULL,
  `direccion` text NOT NULL,
  `fono` text NOT NULL,
  `nombre_contacto` text NOT NULL,
  `cel` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nit`, `razon_social`, `direccion`, `fono`, `nombre_contacto`, `cel`) VALUES
(1, '346942010', 'Campuzano', 'Av. Burgaleta', '2335566', 'Javier', '77217086'),
(2, '', '', '', '', 'ANGEL PAREDES', ''),
(3, '', '', '', '', 'ALICIA BARRERA', ''),
(4, '', '', '', '', 'MARIO APULACA', ''),
(5, '', '', '', '', 'GENARO POCOMA', ''),
(6, '', '', '', '', 'KATERIN PINTO', ''),
(7, '', '', '', '', 'MAGDALENA RODRIGUEZ', ''),
(8, '', '', '', '', 'DANIEL RIOS', ''),
(9, '', '', '', '', 'EZEQUIEL CADENA', ''),
(10, '', '', '', '', 'MAXIMA POMA', ''),
(11, '', '', '', '', 'FREDDY VARGAS', ''),
(12, '', '', '', '', 'ALICIA BARRERA', ''),
(13, '', '', '', '', 'PEDRO CADENA', ''),
(14, '', '', '', '', 'DEYSI ARTEAGA', ''),
(15, '', '', '', '', 'ELVIS CHAMBI', ''),
(16, '', '', '', '', 'NORA BARRERA', ''),
(17, '', '', '', '', 'MARI CARMEN AYOROA', ''),
(18, '', '', '', '', 'MIRIAM POCOMA', ''),
(19, '', '', '', '', 'JUAN COPA', ''),
(20, '', '', '', '', 'SIND AEROPUERTO', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE IF NOT EXISTS `compras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fechac` date NOT NULL,
  `proveedor` text NOT NULL,
  `descuento` double NOT NULL,
  `a_cuenta` double NOT NULL,
  `saldo` double NOT NULL,
  `observaciones` text NOT NULL,
  `tipo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE IF NOT EXISTS `cuentas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(15) NOT NULL,
  `grupo` text NOT NULL,
  `nombre_cta` text NOT NULL,
  `tipo` text NOT NULL,
  `moneda` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `CODIGO_CTA` (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=287 ;

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
(232, '5102040008', 'EGRESO', 'SERVICIO DE TELEFONIA - COTEL', 'S', 'BS'),
(233, '510205', 'EGRESO', 'MATERIALES, SUMINISTROS Y OTROS', 'C', 'BS'),
(234, '5102050001', 'EGRESO', 'MATERIAL DE ESCRITORIO Y OFICINA', 'S', 'BS'),
(235, '5102050002', 'EGRESO', 'FOTOCOPÍAS, FORMULARIOS Y FOTOGRAFIAS', 'S', 'BS'),
(236, '5102050010', 'EGRESO', 'COMBUSTIBLES', 'S', 'BS'),
(237, '5102050011', 'EGRESO', 'MOVILIDADES', 'S', 'BS'),
(238, '510206', 'EGRESO', 'SEGUROS Y REASEGUROS', 'C', 'BS'),
(239, '5102060001', 'INGRESO', 'SEGURO DE BIENES INMUEBLES', 'S', 'BS'),
(240, '5102060002', 'EGRESO', 'SEGURO DE VEHICULOS', 'S', 'BS'),
(241, '5102060003', 'EGRESO', 'SEGURO DE BIENES MUEBLES', 'S', 'BS'),
(242, '5102060004', 'INGRESO', 'SEGURO DE PERSONAS', 'S', 'BS'),
(243, '5102060005', 'EGRESO', 'SEGURO CONTRA TODO RIESGO', 'S', 'BS'),
(244, '5102060006', 'INGRESO', 'SEGURO TRANSPORTE', 'S', 'BS'),
(245, '510207', 'EGRESO', 'VIAJES, HOSPEDAJES Y VIATICOS', 'C', 'BS'),
(246, '5102070001', 'EGRESO', 'TRANSPORTE AEREO', 'S', 'BS'),
(247, '5102070002', 'EGRESO', 'TRANSPORTE TERRESTRE', 'S', 'BS'),
(248, '5102070003', 'EGRESO', 'HOTELES Y HOSPEDAJES', 'S', 'BS'),
(249, '5102070004', 'EGRESO', 'VIATICOS', 'S', 'BS'),
(250, '510215', 'EGRESO', 'DEPRECIACION ACTIVOS FIJOS', 'C', 'BS'),
(251, '5102150001', 'EGRESO', 'DEPRECIACION EDIFICIOS Y CONSTRUCCIONES', 'S', 'BS'),
(252, '5102150002', 'EGRESO', 'DEPRECIACION MUEBLES Y ENSERES', 'S', 'BS'),
(253, '5102150003', 'EGRESO', 'DEPRECIACION MAQUINARIA Y EQUIPO', 'S', 'BS'),
(254, '5102150004', 'EGRESO', 'DEPRECIACION VEHICULOS', 'S', 'BS'),
(255, '5102150005', 'EGRESO', 'DEPRECIACION HERRAMIENETAS', 'S', 'BS'),
(256, '5102150006', 'EGRESO', 'DEPRECIACION EQUIPOS DE COMPUTACION', 'S', 'BS'),
(257, '510220', 'INGRESO', 'GASTOS VARIOS', 'C', 'BS'),
(258, '5102200001', 'EGRESO', 'TRAMITES LEGALES', 'S', 'BS'),
(259, '5102200002', 'EGRESO', 'GASTOS PERSONALES DE SOCIOS', 'S', 'BS'),
(280, '2101010009', 'PASIVO', 'OTRAS CUENTAS POR PAGAR', 'S', 'BS'),
(261, '5102200010', 'EGRESO', 'PERDIDA EN VENTA DE ACTIVOS FIJOS', 'S', 'BS'),
(262, '5102200100', 'EGRESO', 'OTROS GASTOS VARIOS', 'S', 'BS'),
(263, '5103', 'EGRESO', 'GASTOS DE VENTA', 'T', 'BS'),
(264, '510301', 'INGRESO', 'GASTOS DE VENTA', 'C', 'BS'),
(265, '5103010001', 'EGRESO', 'GASTOS DE VENTA', 'S', 'BS'),
(266, '5103010011', 'EGRESO', 'PUBLICIDAD Y SUSCRIPCIONES', 'S', 'BS'),
(267, '5104', 'EGRESO', 'GASTOS FINANCIEROS', 'T', 'BS'),
(268, '510401', 'EGRESO', 'GASTOS FINANCIEROS', 'C', 'BS'),
(269, '5104010001', 'EGRESO', 'INTERESES Y COMISIONES BANCARIAS', 'S', 'BS'),
(270, '5104010002', 'EGRESO', 'INTERESES Y COMISIONES SOBRE PRESTAMOS', 'S', 'BS'),
(271, '5104010010', 'EGRESO', 'IMPUESTO A LAS TRANSACCIONES FINANCIERAS', 'S', 'BS'),
(272, '5110', 'EGRESO', 'GASTOS NO MONETARIOS', 'T', 'BS'),
(273, '511001', 'EGRESO', 'GASTOS NO MONETARIOS', 'C', 'BS'),
(274, '5110010001', 'EGRESO', 'AJUSTE POR INFLACION Y TENENCIA DE BIENES', 'S', 'BS'),
(275, '5110010002', 'EGRESO', 'AJUSTE DIFERENCIA DE CAMBIO', 'S', 'BS'),
(276, '5110010003', 'INGRESO', 'MANTENIMIENTO DE VALOR', 'S', 'BS'),
(277, '5505', 'EGRESO', 'GANACIAS Y PERDIDAS', 'T', 'BS'),
(278, '550501', 'EGRESO', 'GANACIAS Y PERDIDAS', 'C', 'BS'),
(279, '5505010001', 'EGRESO', 'GANACIAS Y PERDIDAS', 'S', 'BS'),
(281, '1101030002', 'ACTIVO', 'BANCO UNION SQ 2-22713213', 'S', '$US'),
(282, '2101220001', 'PASIVO', 'INGRESOS PERCIBIDOS POR ADELANTADO', 'S', 'BS'),
(283, '3101020001', 'PATRIMONIO', 'APORTES POR CAPITALIZAR', 'S', 'BS'),
(284, '1102010002', 'ACTIVO', 'PACIFIC TELECOM BOLIVIA S.A.', 'S', 'BS'),
(285, '1102010003', 'ACTIVO', 'CLAY PACIFIC S.R.L.', 'S', 'BS'),
(286, '2101010002', 'PASIVO', 'TELCORP COMUNICACIONES S.A.', 'S', 'BS');

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
-- Estructura de tabla para la tabla `operaciones`
--

CREATE TABLE IF NOT EXISTS `operaciones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_cuenta` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debe` double DEFAULT NULL,
  `haber` double DEFAULT NULL,
  `fk_transaccion` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=59 ;

--
-- Volcado de datos para la tabla `operaciones`
--

INSERT INTO `operaciones` (`id`, `fk_cuenta`, `descripcion`, `debe`, `haber`, `fk_transaccion`) VALUES
(50, '282', NULL, 0, 535920, 21),
(51, '121', NULL, 0, 3960, 21),
(52, '131', NULL, 0, 720.42, 21),
(53, '132', NULL, 0, 2161.28, 21),
(54, '133', NULL, 0, 330.86, 21),
(55, '151', NULL, 0, 10000, 21),
(56, '154', NULL, 0, 1952.52, 21),
(57, '164', NULL, 0, 12.15, 21),
(58, '178', NULL, 0, 14820.97, 21);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo_prod`, `producto`, `marca`, `medida`, `modelo`, `descripcion`, `precio1`, `precio2`, `precio3`) VALUES
(11, '111', 'LLANTA', 'LENSTON', '155R12', 'ELEPHANT L220', 'RADIAL', 0, 0, 0),
(12, '112', 'LLANTA', 'LENSTON', '165R13', 'ELEPHANT L220', 'RADIAL', 0, 0, 0),
(13, '113', 'LLANTA', 'LENSTON', '175/70R13', 'EAGLE L100', 'RADIAL', 0, 0, 0),
(14, '114', 'LLANTA', 'LENSTON', '175/70R14', 'ELEPHANT L200', 'RADIAL', 0, 0, 0),
(15, '115', 'LLANTA', 'LENSTON', '185/60R14', 'EAGLE L100', 'RADIAL', 0, 0, 0),
(16, '116', 'LLANTA', 'LENSTON', '185/65R14', 'EAGLE L100', 'RADIAL', 0, 0, 0),
(17, '117', 'LLANTA', 'LENSTON', '185/70R14', 'EAGLE100', 'RADIAL', 0, 0, 0),
(18, '118', 'LLANTA', 'LENSTON', '185R14C', 'ELEPHANT L200', 'RADIAL', 0, 0, 0),
(19, '119', 'LLANTA', 'LENSTON', '195/65R15', 'EAGLEL 100', 'RADIAL', 0, 0, 0),
(20, '1110', 'LLANTA', 'LENSTON', '195/70R15', 'ELEPHANT L200', 'RADIAL', 0, 0, 0),
(21, '1111', 'LLANTA', 'LENSTON', '195R14C', 'ELEPHANT L200', 'RADIAL', 0, 0, 0),
(22, '1112', 'LLANTA', 'LENSTON', '195R15C', 'ELEPHANT L200', 'RADIAL', 0, 0, 0),
(23, '121', 'LLANTA', 'LING LONG', '175/70R13', 'LL700', 'RADIAL', 0, 0, 0),
(24, '122', 'LLANTA', 'LING LONG', '185/70R13', 'LL700', 'RADIAL', 0, 0, 0),
(25, '123', 'LLANTA', 'LING LONG', '185/70R14', 'CROSS WIND', 'RADIAL', 0, 0, 0),
(26, '124', 'LLANTA', 'LING LONG', '185/70R14', 'LL700', 'RADIAL', 0, 0, 0),
(27, '125', 'LLANTA', 'LING LONG', '185R14', 'LMC5', 'RADIAL', 0, 0, 0),
(28, '126', 'LLANTA', 'LING LONG', '185R14', 'R620', 'RADIAL', 0, 0, 0),
(29, '127', 'LLANTA', 'LING LONG', '185R14C', 'GREEN MAX', 'RADIAL', 0, 0, 0),
(30, '128', 'LLANTA', 'LING LONG', '195/70R15', 'LMB3', 'RADIAL', 0, 0, 0),
(31, '129', 'LLANTA', 'LING LONG', '195R14', 'LMC5', 'RADIAL', 0, 0, 0),
(32, '1210', 'LLANTA', 'LING LONG', '195R15C', 'LMC5', 'RADIAL', 0, 0, 0),
(33, '1211', 'LLANTA', 'LING LONG', '195R15C', 'R 666', 'RADIAL', 0, 0, 0),
(34, '1212', 'LLANTA', 'LING LONG', '245/70R16', 'A/T', 'RADIAL', 0, 0, 0),
(35, '1213', 'LLANTA', 'LING LONG', '255/70R16', 'MT', 'RADIAL', 0, 0, 0),
(36, '1214', 'LLANTA', 'LING LONG', '265/70R17', 'MT', 'RADIAL', 0, 0, 0),
(37, '1215', 'LLANTA', 'LING LONG', '265/70R17', 'A/T', 'RADIAL', 0, 0, 0),
(38, '1216', 'LLANTA', 'LING LONG', '31X10.50R15', 'A/T', 'RADIAL', 0, 0, 0),
(39, '1217', 'LLANTA', 'LING LONG', '600-13', 'LL15', 'CONVENCIONAL', 0, 0, 0),
(40, '1218', 'LLANTA', 'LING LONG', '600-14', 'LL17', 'CONVENCIONAL', 0, 0, 0),
(41, '1219', 'LLANTA', 'LING LONG', '600-14', 'LL15', 'CONVENCIONAL', 0, 0, 0),
(42, '1220', 'LLANTA', 'LING LONG', '650-15', 'LL9', 'CONVENCIONAL', 0, 0, 0),
(43, '1221', 'LLANTA', 'LING LONG', '9.5R17.5', 'D960', 'RADIAL', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nit` text NOT NULL,
  `razon_social` text NOT NULL,
  `direccion` text NOT NULL,
  `fono` text NOT NULL,
  `nombre_contacto` text NOT NULL,
  `cel` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Volcado de datos para la tabla `transacciones`
--

INSERT INTO `transacciones` (`id`, `nro_comprobante`, `nro_tipo_comprobante`, `fk_tipo_transaccion`, `fecha`, `tipo_cambio`, `ca`, `glosa`) VALUES
(21, 7, 1, 3, '2017-01-01', 0, '', 'ASIENTO DE APERTURA AL 01-01-2017 AL T/C 6.9600');

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
