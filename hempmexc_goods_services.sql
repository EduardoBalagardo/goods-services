-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-06-2019 a las 02:26:21
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `hempmexc_goods_services`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_categorias_productos`
--

CREATE TABLE IF NOT EXISTS `cat_categorias_productos` (
`cat_id` int(11) NOT NULL,
  `cat_clave` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cat_descripcion` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cat_estatus` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cat_categorias_productos`
--

INSERT INTO `cat_categorias_productos` (`cat_id`, `cat_clave`, `cat_descripcion`, `cat_estatus`) VALUES
(1, '00001', 'Productos de Limpieza', 1),
(2, '00002', 'Productos de Papeleria', 1),
(3, '00003', 'Productos Domesticos', 1),
(4, '00004', 'Articulos de Computadora', 1),
(5, '00005', 'Productos de Jardineria', 1),
(6, '00006', 'Articulos de Oficina', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_centro_costos`
--

CREATE TABLE IF NOT EXISTS `cat_centro_costos` (
`cec_id` int(11) NOT NULL,
  `cec_clave` int(11) NOT NULL,
  `cec_descripcion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cec_status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cat_centro_costos`
--

INSERT INTO `cat_centro_costos` (`cec_id`, `cec_clave`, `cec_descripcion`, `cec_status`) VALUES
(1, 1, 'CDMX', 1),
(2, 2, 'QUERETARO', 1),
(3, 3, 'GUADALAJARA', 1),
(4, 4, 'SAN LUIS POTOSI', 1),
(5, 5, 'CHIAPAS', 1),
(6, 6, 'GUERRERO', 1),
(7, 7, 'VERACRUZ', 1),
(8, 8, 'CAMPECHE', 1),
(9, 9, 'OAXACA', 1),
(10, 10, 'CHIAPAS', 1),
(11, 11, 'TAMAULIPAS', 1),
(12, 12, 'SINALOA', 1),
(13, 13, 'BCS', 1),
(14, 14, 'CHIHUAHUA', 1),
(15, 15, 'TLAXCALA', 1),
(16, 16, 'NUEVO LEON', 1),
(17, 17, 'COAHUILA', 1),
(18, 18, 'SONORA', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_empleados`
--

CREATE TABLE IF NOT EXISTS `cat_empleados` (
`emp_id` int(11) NOT NULL,
  `emp_clave` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `emp_fullname` varchar(420) COLLATE utf8_unicode_ci NOT NULL,
  `emp_mail` varchar(320) COLLATE utf8_unicode_ci NOT NULL,
  `emp_telefono` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `emp_user` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `emp_pass` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `emp_cec_id` int(11) NOT NULL,
  `emp_id_puesto` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cat_empleados`
--

INSERT INTO `cat_empleados` (`emp_id`, `emp_clave`, `emp_fullname`, `emp_mail`, `emp_telefono`, `emp_user`, `emp_pass`, `emp_cec_id`, `emp_id_puesto`) VALUES
(1, '0001', 'Administrador', 'admin@educando.com.mx', '2147483647', 'admin', '900150983cd24fb0d6963f7d28e17f72', 0, 0),
(2, '0002', 'Halfter Mijares Javier                                                                                                                             ', 'half.mijares@educando.com.mx', '2156897856', 'half', '202cb962ac59075b964b07152d234b70', 1, 6),
(3, '0003', 'Leopoldo Leal del Valle', 'leopolgo.leal@educando.com.mx', '5573086144', 'leo', '202cb962ac59075b964b07152d234b70', 3, 5),
(4, '0004', 'Fabrizio Luna Cobian', 'fabrizio.luna@educando.com.mx', '6645788977', 'fab', '202cb962ac59075b964b07152d234b70', 2, 7),
(5, '0005', 'Alejandra Araceli Barela Del Valle', 'ale@educando.com.mx', '5588965878', 'ale', 'c4ca4238a0b923820dcc509a6f75849b', 1, 29),
(6, '0006', 'Maria Jose Paniagua Ronquillo', 'marijo@educando.com.mx', '6689778877', 'mari', 'c4ca4238a0b923820dcc509a6f75849b', 1, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_estatus`
--

CREATE TABLE IF NOT EXISTS `cat_estatus` (
`est_id` int(11) NOT NULL,
  `est_descripcion` varchar(250) NOT NULL,
  `est_estatus` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cat_estatus`
--

INSERT INTO `cat_estatus` (`est_id`, `est_descripcion`, `est_estatus`) VALUES
(1, 'Abierta', 1),
(2, 'Aprobación Jefe de Área', 1),
(3, 'Aproacion Director Finanzas', 1),
(4, 'Requisicion', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_productos`
--

CREATE TABLE IF NOT EXISTS `cat_productos` (
`pro_id` int(11) NOT NULL,
  `pro_cat_id` int(11) NOT NULL,
  `pro_prv_id` int(11) NOT NULL,
  `pro_uds_id` int(11) NOT NULL,
  `pro_clave` varchar(50) NOT NULL,
  `pro_cantidad` int(11) NOT NULL,
  `pro_precio_unitario` float NOT NULL,
  `pro_precio_total` float NOT NULL,
  `pro_descripcion` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cat_productos`
--

INSERT INTO `cat_productos` (`pro_id`, `pro_cat_id`, `pro_prv_id`, `pro_uds_id`, `pro_clave`, `pro_cantidad`, `pro_precio_unitario`, `pro_precio_total`, `pro_descripcion`) VALUES
(1, 1, 1, 1, '00001', 100, 15, 1500, 'Escoba Cepillo Rigida Nacional'),
(2, 1, 1, 1, '00002', 200, 20, 4000, 'Trapo de Cocina Towell Azul'),
(3, 1, 1, 1, '00003', 10, 250, 2500, 'Recogedor con Pala Lees Chico'),
(4, 1, 1, 1, '00004', 20, 119, 2380, 'JALADOR NOVICA MAXIMA ADHERENCIA Novica Jalador Maxima'),
(5, 1, 1, 1, '00005', 10, 348, 3480, 'Barredora de Empuje Dirt Devil Mecanica'),
(6, 1, 1, 2, '00006', 100, 50, 5000, 'Jabon Generico en Polvo'),
(7, 2, 2, 1, '00007', 1000, 1.5, 1500, 'Lapiz '),
(8, 2, 2, 1, '00008', 1000, 5, 5000, 'Pluma de punto Fino'),
(9, 2, 2, 1, '00009', 1000, 1.5, 1500, 'Sacaputas '),
(10, 2, 2, 1, '00010', 1000, 10, 10000, 'Goma individual'),
(11, 2, 2, 1, '00011', 50, 25, 1250, 'Cuaderno de Cuadro'),
(12, 2, 2, 1, '00012', 50, 25, 1250, 'Cuaderno de Rayas'),
(13, 2, 2, 1, '00013', 50, 5, 250, ' Pluma de Punto Fino '),
(14, 2, 2, 1, '00014', 100, 10, 1000, ' Pluma de Gel ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_profile_user`
--

CREATE TABLE IF NOT EXISTS `cat_profile_user` (
`usr_id` int(11) NOT NULL,
  `usr_clave` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `usr_descripcion` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `usr_status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cat_profile_user`
--

INSERT INTO `cat_profile_user` (`usr_id`, `usr_clave`, `usr_descripcion`, `usr_status`) VALUES
(1, '001', 'Super User', 1),
(2, '002', 'Direccion', 1),
(3, '003', 'Gerente', 1),
(4, '004', 'Jefe de Area', 1),
(5, '005', 'Operador Clase A', 1),
(6, '006', 'Operador Clase B', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_proveedores`
--

CREATE TABLE IF NOT EXISTS `cat_proveedores` (
`prv_id` int(11) NOT NULL,
  `prv_nombre` varchar(250) NOT NULL,
  `prv_giro` varchar(250) NOT NULL,
  `prv_direccion` varchar(250) NOT NULL,
  `prv_telefono` varchar(50) NOT NULL,
  `prv_mail` varchar(320) NOT NULL,
  `prv_rfc` varchar(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cat_proveedores`
--

INSERT INTO `cat_proveedores` (`prv_id`, `prv_nombre`, `prv_giro`, `prv_direccion`, `prv_telefono`, `prv_mail`, `prv_rfc`) VALUES
(1, 'SISTEMAS CORPORATIVOS DE LIMPIEZA\r\nY MANTENIMIENTO INDUSTRIAL S.A. DE\r\nC.V.', 'Servicio de limpieza y mantenimiento\r\nindustria', 'CARRETERA TENANGO S/N, TETEPETLA AYAPANGO, ESTADO DE MÉXICO ', '5979821059', 'contacto@siscorpo.com', 'SIST891261GF'),
(2, 'GRUPO ALDIMEX S.A. DE C.V.', 'Equipo de computo , consumibles,\r\npapeleria y articulos de oficina\r\nmobiliario,iluminacion led para oficinas y\r\nandadores, publicidad impresa', 'Asociación Nacional de Industriales del Estado de México\r\nIndustrial Cuamatla\r\n54730 Cuautitlán Izcalli, Méx.', '7222731444 ', 'ventas@aldimex.com.mx', 'GRCN9876FGH'),
(3, 'COMERCIALIZADORA Y FIADORA DE\r\nARTICULOS MEXIQUENSES S.A. DE C.V', 'Comercializadora de electrodomesticos y\r\nlinea blanca', 'Asociación Nacional de Industriales del Estado de México 34, Industrial Cuamatla, 54730 Cuautitlán Izcalli, Méx.', '55 5872 8782', 'ventas2@fiadora.com.mx', 'MRTD76543WW'),
(4, 'INFORMATION TECNLOGY BUSSINES\r\nMEXICO S.A. DE C.V.', 'Comercializacion de equipo de\r\ncomputo,impresoras, accesorios, muebles,\r\nconmutadores, equipo de video, equipos\r\nperifericos, etc.', 'Sevilla 40, Juárez, 06600 Ciudad de México, CDMX', '5 5081 4600', 'cecilia.lopez@itb.com.mx', 'ITBM2006ED'),
(5, 'SERVICIO DE JARDINERIA Y VIVERO XOCHIMILCO', 'Diseño e instalación de fuentes y espejos de agua\r\nMantenimiento de áreas verdes', 'Cuauhtémoc 23, Niños Héroes, 06010 Ciudad de México, CDMX', '01 55 3617 1946', 'josejuan@jardin.com.mx', 'JARD8899HG'),
(6, 'WOODS MUEBLES PARA OFICINA Y HOGAR', 'Muebleria', 'Perif. Blvd. Manuel Ávila Camacho 245, San Francisco Cuautlalpan, 53569 Naucalpan de Juárez, Méx.', '55 5357 0689', 'ventas@woods.com', 'WMPF0077JU');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_puestos`
--

CREATE TABLE IF NOT EXISTS `cat_puestos` (
  `pto_id` int(11) NOT NULL,
  `pto_clave` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pto_descripcion` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `pto_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cat_puestos`
--

INSERT INTO `cat_puestos` (`pto_id`, `pto_clave`, `pto_descripcion`, `pto_status`) VALUES
(1, '001', 'Alta Direccion ', 1),
(2, '002', 'Gerencia de Compras', 1),
(3, '003', 'Gerencia de Almacen', 1),
(4, '004', 'Gerencia de Inventarios', 1),
(5, '005', 'Gerencia Comecial', 1),
(6, '006', 'Asistente Administrativo', 1),
(7, '007', 'Asistente Financiero', 1),
(8, '008', 'Jefe De Almacen', 1),
(9, '009', 'Jefe de Control de Inventarios', 1),
(10, '010', 'Jefe de Ventas', 1),
(11, '011', 'Jefe de Area', 1),
(12, '012', 'Subdireccion', 1),
(13, '013', 'Jefe de Compras', 1),
(14, '014', 'Asistente de Compras', 1),
(15, '015', 'Auxiliar de Almacen', 1),
(16, '016', 'Almacenista', 1),
(17, '017', 'Auxiliar de Inventarios', 1),
(18, '018', 'Vendedor 1', 1),
(19, '019', 'Vendedor 2', 1),
(20, '020', 'Jefe de Sistemas', 1),
(21, '021', 'Auxiliar de Sistemas', 1),
(22, '022', 'Jefe de Recursos HUmanos', 1),
(23, '023', 'Montacarguista', 1),
(24, '024', 'Ayudante General', 1),
(25, '025', 'Facturista', 1),
(26, '026', 'Auxiliar de Almacen', 1),
(28, '028', 'Despachador de Inventario', 1),
(29, '029', 'Director Financiero', 1),
(30, '030', 'Director Comercial', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_rubro_presupuestal`
--

CREATE TABLE IF NOT EXISTS `cat_rubro_presupuestal` (
`rup_id` int(11) NOT NULL,
  `rup_clave` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `rup_descripcion` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cat_rubro_presupuestal`
--

INSERT INTO `cat_rubro_presupuestal` (`rup_id`, `rup_clave`, `rup_descripcion`) VALUES
(1, '0001', 'Ingresos'),
(2, '0002', 'Ingresos Corrientes'),
(3, '0003', 'No Tributarios'),
(4, '0004', 'Rentas Contractuales'),
(5, '0005', 'Arrendamientos'),
(6, '0006', 'Recursos de Capital'),
(7, '0007', 'Otros Ingresos'),
(8, '0008', 'Otros Recursos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_unidad_medida`
--

CREATE TABLE IF NOT EXISTS `cat_unidad_medida` (
  `uds_id` int(11) NOT NULL,
  `uds_clave` varchar(50) NOT NULL,
  `uds_descripcion` varchar(250) NOT NULL,
  `uds_estatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cat_unidad_medida`
--

INSERT INTO `cat_unidad_medida` (`uds_id`, `uds_clave`, `uds_descripcion`, `uds_estatus`) VALUES
(1, '001', 'Unidad', 1),
(2, '002', 'Kilogramo', 1),
(3, '003', 'Litro', 1),
(4, '003', 'Pieza', 1),
(5, '005', 'Metros', 1),
(6, '006', 'Contenedor', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entries_storages`
--

CREATE TABLE IF NOT EXISTS `entries_storages` (
`ent_id` int(11) NOT NULL,
  `ent_fecha` datetime NOT NULL,
  `ent_factura` varchar(50) NOT NULL,
  `ent_prv_id` int(11) NOT NULL,
  `ent_cantidad` int(11) NOT NULL,
  `ent_total` float NOT NULL,
  `ent_estatus` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entries_storages`
--

INSERT INTO `entries_storages` (`ent_id`, `ent_fecha`, `ent_factura`, `ent_prv_id`, `ent_cantidad`, `ent_total`, `ent_estatus`) VALUES
(1, '2019-06-27 09:12:03', 'FA00001002', 1, 30, 4652, 1),
(2, '2019-06-28 02:25:25', 'FA00003001', 2, 200, 2407, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entries_storages_detail`
--

CREATE TABLE IF NOT EXISTS `entries_storages_detail` (
`end_id` int(11) NOT NULL,
  `end_ent_id` int(11) NOT NULL,
  `end_pro_id` int(11) NOT NULL,
  `end_nombre_bien` varchar(250) NOT NULL,
  `end_stock` int(11) NOT NULL,
  `end_estatus` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entries_storages_detail`
--

INSERT INTO `entries_storages_detail` (`end_id`, `end_ent_id`, `end_pro_id`, `end_nombre_bien`, `end_stock`, `end_estatus`) VALUES
(1, 1, 1, 'Escoba Cepillo Rigida Nacional', 5, 1),
(2, 1, 2, 'Trapo de Cocina Towell Azul', 5, 1),
(3, 1, 3, 'Recogedor con Pala Lees Chico', 5, 1),
(4, 1, 4, 'JALADOR NOVICA MAXIMA ADHERENCIA Novica Jalador Maxima', 5, 1),
(5, 1, 5, 'Barredora de Empuje Dirt Devil Mecanica', 5, 1),
(6, 1, 6, 'Jabon Generico en Polvo', 5, 1),
(7, 2, 7, 'Lapiz ', 50, 1),
(8, 2, 8, 'Pluma de punto Fino', 50, 1),
(9, 2, 10, 'Goma individual', 50, 1),
(10, 2, 11, 'Cuaderno de Cuadro', 50, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase_order`
--

CREATE TABLE IF NOT EXISTS `purchase_order` (
`ord_id` int(11) NOT NULL,
  `cec_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `rup_id` int(11) NOT NULL,
  `prv_id` int(11) NOT NULL,
  `ord_estatus` int(11) NOT NULL,
  `ord_fecha` datetime NOT NULL,
  `ord_responsable` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `ord_proyecto` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `ord_clave` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ord_detalle` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `ord_factura` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `purchase_order`
--

INSERT INTO `purchase_order` (`ord_id`, `cec_id`, `emp_id`, `rup_id`, `prv_id`, `ord_estatus`, `ord_fecha`, `ord_responsable`, `ord_proyecto`, `ord_clave`, `ord_detalle`, `ord_factura`) VALUES
(1, 2, 4, 5, 1, 3, '2019-06-27 08:16:11', 'Fabrizio Luna Cobian', 'PROYECTO CANNABIS SALUD 2019', '0004', 'PAGO A 12 MESES SIN INTERESES', '@@@@'),
(2, 2, 4, 2, 2, 1, '2019-06-27 08:17:01', 'Fabrizio Luna Cobian', 'PROYECTO CANNAFEST 2019', '0004', 'PAGO A 18 MESES SIN INTERESES', '@@@@'),
(3, 1, 2, 2, 2, 3, '2019-06-27 08:18:02', 'Halfter Mijares Javier                                                                                                                             ', 'PROYECTO LIMPIANDO MEXICO 2019', '0002', 'PAGO A 8 MESES', '@@@@'),
(4, 1, 2, 5, 2, 1, '2019-06-27 08:18:46', 'Halfter Mijares Javier                                                                                                                             ', 'PROYECTO SAVE MEX ALL STAND ALONE', '0002', 'PAGO A 8 MESES SIN INTERESES DESPUES DE ENTREGA', '@@@@');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase_order_contractual`
--

CREATE TABLE IF NOT EXISTS `purchase_order_contractual` (
`orc_id` int(11) NOT NULL,
  `orc_nit` varchar(50) NOT NULL,
  `orc_factura` varchar(50) NOT NULL,
  `orc_prv_id` int(11) NOT NULL,
  `ord_emp_id` int(11) NOT NULL,
  `orc_fecha_order` datetime DEFAULT NULL,
  `orc_fecha_entrega` datetime DEFAULT NULL,
  `orc_monto_total` int(11) NOT NULL,
  `orc_cantidad_total` int(11) NOT NULL,
  `orc_estatus` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `purchase_order_contractual`
--

INSERT INTO `purchase_order_contractual` (`orc_id`, `orc_nit`, `orc_factura`, `orc_prv_id`, `ord_emp_id`, `orc_fecha_order`, `orc_fecha_entrega`, `orc_monto_total`, `orc_cantidad_total`, `orc_estatus`) VALUES
(1, '0200-0381-0538-G', 'FA00001002', 1, 4, '2019-06-27 08:20:15', '2019-06-27 09:12:03', 4652, 30, 2),
(2, '0283-0640-0310-D', 'FA00003001', 2, 2, '2019-06-27 08:20:15', '2019-06-28 02:25:25', 2407, 200, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase_order_contractual_detail`
--

CREATE TABLE IF NOT EXISTS `purchase_order_contractual_detail` (
`ocd_id` int(11) NOT NULL,
  `ocd_orc_id` int(11) NOT NULL,
  `ocd_pro_id` int(11) NOT NULL,
  `ocd_descripcion` varchar(250) NOT NULL,
  `ocd_cantidad` int(11) NOT NULL,
  `ocd_total` float NOT NULL,
  `ocd_estatus` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `purchase_order_contractual_detail`
--

INSERT INTO `purchase_order_contractual_detail` (`ocd_id`, `ocd_orc_id`, `ocd_pro_id`, `ocd_descripcion`, `ocd_cantidad`, `ocd_total`, `ocd_estatus`) VALUES
(1, 1, 1, 'Escoba Cepillo Rigida Nacional', 5, 75, 1),
(2, 1, 2, 'Trapo de Cocina Towell Azul', 5, 100, 1),
(3, 1, 3, 'Recogedor con Pala Lees Chico', 5, 1250, 1),
(4, 1, 4, 'JALADOR NOVICA MAXIMA ADHERENCIA Novica Jalador Maxima', 5, 595, 1),
(5, 1, 5, 'Barredora de Empuje Dirt Devil Mecanica', 5, 1740, 1),
(6, 1, 6, 'Jabon Generico en Polvo', 5, 250, 1),
(7, 2, 7, 'Lapiz ', 50, 75, 1),
(8, 2, 8, 'Pluma de punto Fino', 50, 250, 1),
(9, 2, 10, 'Goma individual', 50, 500, 1),
(10, 2, 11, 'Cuaderno de Cuadro', 50, 1250, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase_order_detail`
--

CREATE TABLE IF NOT EXISTS `purchase_order_detail` (
`prd_id` int(11) NOT NULL,
  `prd_ord_id` int(11) NOT NULL,
  `prd_pro_descripcion` varchar(250) NOT NULL,
  `prd_cantidad` int(11) NOT NULL,
  `prd_pro_id` int(11) NOT NULL,
  `prd_uds_id` int(11) NOT NULL,
  `prd_pro_precio_unitario` float NOT NULL,
  `prd_pro_precio_total` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `purchase_order_detail`
--

INSERT INTO `purchase_order_detail` (`prd_id`, `prd_ord_id`, `prd_pro_descripcion`, `prd_cantidad`, `prd_pro_id`, `prd_uds_id`, `prd_pro_precio_unitario`, `prd_pro_precio_total`) VALUES
(1, 1, 'Escoba Cepillo Rigida Nacional', 5, 1, 1, 15, 75),
(2, 1, 'Trapo de Cocina Towell Azul', 5, 2, 1, 20, 100),
(3, 1, 'Recogedor con Pala Lees Chico', 5, 3, 1, 250, 1250),
(4, 1, 'JALADOR NOVICA MAXIMA ADHERENCIA Novica Jalador Maxima', 5, 4, 1, 119, 595),
(5, 1, 'Barredora de Empuje Dirt Devil Mecanica', 5, 5, 1, 348, 1740),
(6, 1, 'Jabon Generico en Polvo', 5, 6, 2, 50, 250),
(7, 2, 'Lapiz ', 100, 7, 1, 1.5, 150),
(8, 2, 'Pluma de punto Fino', 100, 8, 1, 5, 500),
(9, 2, 'Sacaputas ', 100, 9, 1, 1.5, 150),
(10, 2, 'Goma individual', 100, 10, 1, 10, 1000),
(11, 2, 'Cuaderno de Cuadro', 100, 11, 1, 25, 2500),
(12, 3, 'Lapiz ', 50, 7, 1, 1.5, 75),
(13, 3, 'Pluma de punto Fino', 50, 8, 1, 5, 250),
(14, 3, 'Goma individual', 50, 10, 1, 10, 500),
(15, 3, 'Cuaderno de Cuadro', 50, 11, 1, 25, 1250),
(16, 4, 'Lapiz ', 10, 7, 1, 1.5, 15),
(17, 4, 'Pluma de punto Fino', 10, 8, 1, 5, 50),
(18, 4, 'Sacaputas ', 15, 9, 1, 1.5, 22.5),
(19, 4, 'Goma individual', 15, 10, 1, 10, 150),
(20, 4, 'Cuaderno de Cuadro', 15, 11, 1, 25, 375),
(21, 4, 'Cuaderno de Rayas', 15, 12, 1, 25, 375),
(22, 4, ' Pluma de Punto Fino ', 15, 13, 1, 5, 75),
(23, 4, ' Pluma de Gel ', 15, 14, 1, 10, 150);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cat_categorias_productos`
--
ALTER TABLE `cat_categorias_productos`
 ADD PRIMARY KEY (`cat_id`);

--
-- Indices de la tabla `cat_centro_costos`
--
ALTER TABLE `cat_centro_costos`
 ADD PRIMARY KEY (`cec_id`);

--
-- Indices de la tabla `cat_empleados`
--
ALTER TABLE `cat_empleados`
 ADD PRIMARY KEY (`emp_id`);

--
-- Indices de la tabla `cat_estatus`
--
ALTER TABLE `cat_estatus`
 ADD PRIMARY KEY (`est_id`);

--
-- Indices de la tabla `cat_productos`
--
ALTER TABLE `cat_productos`
 ADD PRIMARY KEY (`pro_id`);

--
-- Indices de la tabla `cat_profile_user`
--
ALTER TABLE `cat_profile_user`
 ADD PRIMARY KEY (`usr_id`);

--
-- Indices de la tabla `cat_proveedores`
--
ALTER TABLE `cat_proveedores`
 ADD PRIMARY KEY (`prv_id`);

--
-- Indices de la tabla `cat_rubro_presupuestal`
--
ALTER TABLE `cat_rubro_presupuestal`
 ADD PRIMARY KEY (`rup_id`);

--
-- Indices de la tabla `entries_storages`
--
ALTER TABLE `entries_storages`
 ADD PRIMARY KEY (`ent_id`);

--
-- Indices de la tabla `entries_storages_detail`
--
ALTER TABLE `entries_storages_detail`
 ADD PRIMARY KEY (`end_id`);

--
-- Indices de la tabla `purchase_order`
--
ALTER TABLE `purchase_order`
 ADD PRIMARY KEY (`ord_id`);

--
-- Indices de la tabla `purchase_order_contractual`
--
ALTER TABLE `purchase_order_contractual`
 ADD PRIMARY KEY (`orc_id`);

--
-- Indices de la tabla `purchase_order_contractual_detail`
--
ALTER TABLE `purchase_order_contractual_detail`
 ADD PRIMARY KEY (`ocd_id`);

--
-- Indices de la tabla `purchase_order_detail`
--
ALTER TABLE `purchase_order_detail`
 ADD PRIMARY KEY (`prd_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cat_categorias_productos`
--
ALTER TABLE `cat_categorias_productos`
MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `cat_centro_costos`
--
ALTER TABLE `cat_centro_costos`
MODIFY `cec_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `cat_empleados`
--
ALTER TABLE `cat_empleados`
MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `cat_estatus`
--
ALTER TABLE `cat_estatus`
MODIFY `est_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `cat_productos`
--
ALTER TABLE `cat_productos`
MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `cat_profile_user`
--
ALTER TABLE `cat_profile_user`
MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `cat_proveedores`
--
ALTER TABLE `cat_proveedores`
MODIFY `prv_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `cat_rubro_presupuestal`
--
ALTER TABLE `cat_rubro_presupuestal`
MODIFY `rup_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `entries_storages`
--
ALTER TABLE `entries_storages`
MODIFY `ent_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `entries_storages_detail`
--
ALTER TABLE `entries_storages_detail`
MODIFY `end_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `purchase_order`
--
ALTER TABLE `purchase_order`
MODIFY `ord_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `purchase_order_contractual`
--
ALTER TABLE `purchase_order_contractual`
MODIFY `orc_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `purchase_order_contractual_detail`
--
ALTER TABLE `purchase_order_contractual_detail`
MODIFY `ocd_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `purchase_order_detail`
--
ALTER TABLE `purchase_order_detail`
MODIFY `prd_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
