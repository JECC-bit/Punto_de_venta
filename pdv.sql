-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2024 a las 03:10:13
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pdv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id_articulo` varchar(10) NOT NULL,
  `nombre_articulo` varchar(50) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `cant_max_stock` int(10) NOT NULL,
  `cant_min_stock` int(10) NOT NULL,
  `precio_provee` varchar(10) NOT NULL,
  `precio_public` varchar(10) NOT NULL,
  `iva` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id_articulo`, `nombre_articulo`, `descripcion`, `categoria`, `cant_max_stock`, `cant_min_stock`, `precio_provee`, `precio_public`, `iva`) VALUES
('A01', 'Leche Monarca', 'Leche entera 1L', 'Lacteos', 10, 2, '$10', '$15', '%0.16'),
('A02', 'Pan Integral', 'Pan integral 500g', 'Panadería', 15, 3, '$8', '$12', '%0.16'),
('A03', 'Manzanas Gala', 'Manzanas frescas (1 kg)', 'Frutas', 20, 5, '$12', '$18', '%0.16'),
('A04', 'Pasta Penne', 'Pasta Penne (500g)', 'Pastas', 8, 2, '$5', '$9', '%0.16'),
('A05', 'Aceite de Oliva Extra Virgen', 'Aceite de oliva extra virgen (250ml)', 'Aceites', 25, 6, '$15', '$25', '%0.16'),
('A06', 'Yogur Natural', 'Yogur natural 250g', 'Lácteos', 12, 3, '$6', '$10', '%0.16'),
('A07', 'Huevos Frescos', 'Huevos frescos (docena)', 'Huevos', 30, 10, '$18', '$24', '%0.16'),
('A08', 'Cerveza Artesanal IPA', 'Cerveza IPA (355ml)', 'Bebidas Alcohólicas', 24, 6, '$20', '$30', '%0.16'),
('A09', 'Sopa de Tomate en Lata', 'Sopa de tomate en lata (400g)', 'Conservas', 18, 4, '$7', '$12', '%0.16'),
('A10', 'Cepillo de Dientes', 'Cepillo de dientes suave', 'Higiene Personal', 50, 10, '$2', '$3.5', '%0.16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` varchar(10) NOT NULL,
  `nombre_cliente` varchar(50) NOT NULL,
  `telefono_cliente` text NOT NULL,
  `direccion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `telefono_cliente`, `direccion`) VALUES
('C01', 'Juan Pérez', '2147483647', 'Pablo Silva Garcia #340, CP 28000'),
('C02', 'Alfredo Jimenez', '2147483647', 'Pablo Silva Garcia #30, CP 28000'),
('C03', 'Francisco Avalos', '2147483647', 'Gardenias #88, CP 28010'),
('C04', 'Sofia Martínez', '2147483647', 'Magnolias #50, CP 28100'),
('C05', 'Jesus Ceballos', '2147483647', 'Benito juarez #560, CP 28970'),
('C06', 'Karen Aguilar', '2147483647', 'Leando valle #66, CP 28089'),
('C07', 'Alba Lopez', '3121708033', 'Allende #340, CP 28000'),
('C08', 'Ramiro Nuñez', '2147483647', 'Pablo Silva Garcia #340, CP 28000'),
('C09', 'Cristian Sanchez', '2147483647', 'Mariano Arista #3, CP 28900'),
('C10', 'Ramon Ceballos', '2147483647', 'Aldama #567, CP 28000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` varchar(10) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `correo` varchar(70) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `rol` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `nombre_usuario`, `correo`, `usuario`, `contrasena`, `rol`) VALUES
('U01', 'Moises Alejandro Ruiz Hernandez', 'hernandez@gmail.com', 'mhernadez', 'contrasena', 'Admin'),
('U02', 'Ana Maria Rodriguez', 'ana.rodriguez@gmail.com', 'arodriguez', 'contrasena', 'Usuario'),
('U03', 'Carlos Alberto Gomez', 'carlos.gomez@gmail.com', 'cgomez', 'contrasena', 'Admin'),
('U04', 'Laura Sofia Ramirez', 'laura.ramirez@gmail.com', 'lramirez', 'contrasena', 'Usuario'),
('U05', 'Juan Manuel Torres', 'juan.torres@gmail.com', 'jtorres', 'contrasena', 'Admin'),
('U06', 'Marina Alejandra Lopez', 'marina.lopez@gmail.com', 'mlopez', 'contrasena', 'Usuario'),
('U07', 'Roberto Carlos Sanchez', 'roberto.sanchez@gmail.com', 'rsanchez', 'contrasena', 'Admin'),
('U08', 'Fernanda Gabriela Martinez', 'fernanda.martinez@gmail.com', 'fmartinez', 'contrasena', 'Usuario'),
('U09', 'Ricardo Andres Mendez', 'ricardo.mendez@gmail.com', 'rmendez', 'contrasena', 'Admin'),
('U10', 'Camila Alejandra Herrera', 'camila.herrera@gmail.com', 'cherrera', 'contrasena', 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` varchar(10) NOT NULL,
  `id_articulo` varchar(10) NOT NULL,
  `cantidad_venta` float NOT NULL,
  `fecha_venta` date NOT NULL,
  `metodo_pago` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_articulo`, `cantidad_venta`, `fecha_venta`, `metodo_pago`) VALUES
('V01', 'A02', 2, '2023-01-12', 'Efectivo'),
('V02', 'A03', 3, '2023-01-12', 'T.C./T.D.'),
('V03', 'A04', 1, '2023-01-13', 'Transferencia'),
('V04', 'A05', 4, '2023-01-13', 'Efectivo'),
('V05', 'A06', 2, '2023-01-14', 'T.C./T.D.'),
('V06', 'A07', 5, '2023-01-14', 'Transferencia'),
('V07', 'A08', 1, '2023-01-14', 'Efectivo'),
('V08', 'A09', 3, '2023-01-15', 'T.C./T.D.'),
('V09', 'A10', 2, '2023-01-15', 'Transferencia'),
('V10', 'A01', 4, '2023-01-15', 'Efectivo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id_articulo`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_articulo` (`id_articulo`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_articulo`) REFERENCES `articulos` (`Id_articulo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
