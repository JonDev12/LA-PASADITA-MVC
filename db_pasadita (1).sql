-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2024 a las 04:53:07
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
-- Base de datos: `db_pasadita`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `EditDishes` (IN `NewDesc` VARCHAR(25), IN `NewCat` VARCHAR(25))   BEGIN
    DECLARE IdC INT;
    DECLARE DishID INT;
    DECLARE CurrentDesc VARCHAR(25);
    DECLARE CurrentCat INT;


SELECT idPlatillos INTO DishID
    FROM platillos
    WHERE descripcion = NewDesc;


IF DishID IS NOT NULL THEN

SELECT descripcion INTO CurrentDesc
        FROM platillos
        WHERE idPlatillos = DishID;


IF NewDesc != CurrentDesc THEN
            UPDATE platillos
            SET descripcion = NewDesc
            WHERE idPlatillos = DishID;
        END IF;


SELECT IdCategorias INTO CurrentCat
        FROM categorias_has_platillos
        WHERE IdPlatillos = DishID;


SELECT IdCategorias INTO IdC
        FROM categorias
        WHERE descripcion = NewCat;


IF IdC != CurrentCat THEN
            UPDATE categorias_has_platillos
            SET IdCategorias = IdC
            WHERE IdPlatillos = DishID;
        END IF;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarIngredients` (IN `p_Descripcion` VARCHAR(25), IN `p_Cantidad` INT, IN `p_UMedida` VARCHAR(15))   BEGIN
    DECLARE v_IdAlmacenExistente INT;
    DECLARE v_TotalExistente INT;
    
    -- Buscar si el ingrediente ya está en el almacén y coincide con cantidad en ML y el precio
    SELECT IdAlmacen, Total INTO v_IdAlmacenExistente, v_TotalExistente  FROM Almacen WHERE Descripcion = p_Descripcion ;
    
    IF v_IdAlmacenExistente IS NOT NULL THEN
        -- Si el ingrediente ya está en el almacén, actualizar el total
        UPDATE Almacen SET Total = p_Cantidad + v_TotalExistente, Diponibles = v_TotalExistente + p_Cantidad
        WHERE IdAlmacen = v_IdAlmacenExistente;
        
        UPDATE Ingredientes SET Cantidad= p_Cantidad + v_TotalExistente
        WHERE IdAlmacen = v_IdAlmacenExistente;
    ELSE
        -- Si el ingrediente no está en el almacén, insertarla
        INSERT INTO Almacen (Descripcion, Total, Diponibles, Defectuosos) VALUES (p_Descripcion, p_Cantidad, p_Cantidad, 0);
        -- Obtener el nuevo IdAlmacen
        SET v_IdAlmacenExistente = (SELECT MAX(IdAlmacen) FROM Almacen);
            -- Insertar la bebida en la tabla Ingredientes
    INSERT INTO Ingredientes (Descripcion, Cantidad, U_Medida, IdAlmacen)
    VALUES (p_Descripcion, p_Cantidad, p_UMedida, v_IdAlmacenExistente);
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertBebidas` (IN `D` VARCHAR(255), IN `C_ML` INT, IN `C` INT, IN `P` DECIMAL(10,2))   BEGIN
    DECLARE IdS INT;


SELECT IdAlmacen INTO IdS
    FROM Almacen
    WHERE descripcion = D
    LIMIT 1;

    IF IdS IS NOT NULL THEN
        INSERT INTO Bebidas (Descripcion, Cantidad_ML, Cantidad, Precio, IdAlmacen)
        VALUES (D, C_ML, C, P, IdS);
    ELSE

INSERT INTO Almacen (descripcion, total, Disponibles, Defectuosos)
        VALUES (D, C, 0, 0);


SELECT LAST_INSERT_ID() INTO IdS;


INSERT INTO Bebidas (Descripcion, Cantidad_ML, Cantidad, Precio, ImagenBebida, IdAlmacen)
        VALUES (D, C_ML, C, P, IdS);
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertIngredients` (IN `D` VARCHAR(25), IN `C` INT, IN `UM` VARCHAR(25))   BEGIN
    DECLARE IdS INT;


SELECT IdAlmacen INTO IdS
    FROM Almacen
    WHERE descripcion = D
    LIMIT 1;

    IF IdS IS NOT NULL THEN
        INSERT INTO Ingredientes (Descripcion, Cantidad, U_Medida, IdAlmacen)
        VALUES (D, C, UM, IdS);
    ELSE

INSERT INTO Almacen (descripcion, total, Disponibles, Defectuosos)
        VALUES (D, 0, 0, 0);


SELECT LAST_INSERT_ID() INTO IdS;


INSERT INTO Ingredientes (Descripcion, Cantidad, U_Medida, IdAlmacen)
        VALUES (D, C, UM, IdS);
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertOP` (IN `St` VARCHAR(20), IN `Dt` DATE, IN `Hr` TIME, IN `C` INT, IN `PL` VARCHAR(45), IN `Mt` DECIMAL(10,2))   BEGIN
    DECLARE IdPl INT;
    DECLARE IdO INT;


INSERT INTO ordenes (Estado, Fecha, Hora, Cantidad, Monto)
    VALUES (St, Dt, Hr, C, Mt);


SELECT IdPlatillos
    INTO IdPl
    FROM platillos
    WHERE Descripcion = PL;


SELECT MAX(IdOrdenes)
    INTO IdO
    FROM ordenes;


INSERT INTO platillos_has_ordenes (IdPlatillos, IdOrdenes)
    VALUES (IdPl, IdO);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertPlatillos` (IN `D` VARCHAR(25), IN `C` VARCHAR(25))   BEGIN
    DECLARE IdC INT;

    INSERT INTO platillos(descripcion, FechaCreacion)
    VALUES (D, NOW());

    SELECT IdCategorias INTO IdC FROM categorias WHERE descripcion = C;

    INSERT INTO categorias_has_platillos(IdCategorias, IdPLatillos)
    VALUES (IdC, LAST_INSERT_ID());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertSaleByOrder` (IN `ST` VARCHAR(25), IN `C` INT, IN `M` DECIMAL(10,2))   BEGIN DECLARE IDV INT;

DECLARE IdO INT;

INSERT INTO
    ordenes (Estado, Fecha, Hora, Cantidad, Monto)
VALUES
    (ST, CURRENT_DATE, CURRENT_TIME(), C, M);

SELECT
    LAST_INSERT_ID () INTO IdO
FROM
    ordenes;

INSERT INTO
    ventas (Cantidad, Fecha, Hora, Total)
VALUES
    (C, CURRENT_DATE, CURRENT_TIME(), M);

SELECT
    LAST_INSERT_ID () INTO IdV
FROM
    ventas;

INSERT INTO
    ordenes_has_ventas (IdOrdenes, IdVentas)
VALUES
    (IdO, IdV);

END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `CalculateByYear` (`yr` INT(24)) RETURNS DECIMAL(10,2) DETERMINISTIC BEGIN
    DECLARE Ret_sales DECIMAL(10, 2);

    -- Calcular la suma de las ventas para el año dado
    SELECT SUM(Total)
    INTO Ret_sales
    FROM ventas
    WHERE YEAR(fecha) = yr;

    -- Devolver el resultado, 0 si no hay ventas para ese año
    RETURN IFNULL(Ret_sales, 0);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `CalculateSalesByMonth` (`mes` INT) RETURNS DECIMAL(10,2) DETERMINISTIC BEGIN
    DECLARE Ret_sales DECIMAL(10, 2);

    -- Calcular la suma de las ventas para el mes dado
    SELECT SUM(Total)
    INTO Ret_sales
    FROM ventas
    WHERE MONTH(fecha) = mes;

    -- Devolver el resultado, 0 si no hay ventas para ese mes
    RETURN IFNULL(Ret_sales, 0);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `IdAlmacen` int(11) NOT NULL,
  `Descripcion` varchar(25) DEFAULT NULL,
  `Total` int(11) DEFAULT NULL,
  `Disponibles` int(11) DEFAULT NULL,
  `Defectuosos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`IdAlmacen`, `Descripcion`, `Total`, `Disponibles`, `Defectuosos`) VALUES
(2, 'Cebolla', 150, 120, 8),
(3, 'Carne molida', 200, 180, 10),
(4, 'Pollo', 120, 100, 7),
(5, 'Arroz', 180, 160, 6),
(6, 'Salmón', 150, 130, 3),
(7, 'Puré de papas', 120, 100, 5),
(8, 'Brócoli', 100, 90, 2),
(9, 'Coca Cola', 503, 450, 20),
(10, 'Pepsi', 450, 400, 25),
(11, 'Sprite', 400, 370, 10),
(12, 'Fanta', 326, 270, 20),
(13, 'Papas', 34, 0, 0),
(14, 'Tomate', 10, 0, 0),
(15, 'Coca Cola', 4, 0, 0);

--
-- Disparadores `almacen`
--
DELIMITER $$
CREATE TRIGGER `ActualizarAlmacen` AFTER UPDATE ON `almacen` FOR EACH ROW BEGIN
    IF NOT (OLD.Descripcion <=> NEW.Descripcion) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Almacen', 'Descripcion', OLD.Descripcion, NEW.Descripcion, NOW());
    END IF;
    IF NOT (OLD.Disponibles <=> NEW.Disponibles) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Almacen', 'Disponibles', OLD.Disponibles, NEW.Disponibles, NOW());
    END IF;
    IF NOT (OLD.Defectuosos <=> NEW.Defectuosos) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Almacen', 'Defectuosos', OLD.Defectuosos, NEW.Defectuosos, NOW());
    END IF;
    IF NOT (OLD.Total <=> NEW.Total) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Almacen', 'Total', OLD.Total, NEW.Total, NOW());
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `EliminarAlmacen` AFTER DELETE ON `almacen` FOR EACH ROW BEGIN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Eliminar', 'Almacen', '-', '-', '-', NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `InsertarAlmacen` AFTER INSERT ON `almacen` FOR EACH ROW BEGIN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1), 'Insertar', 'Almacen', '-', '-', '-', NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bebidas`
--

CREATE TABLE `bebidas` (
  `IdBebidas` int(11) NOT NULL,
  `Descripcion` varchar(25) DEFAULT NULL,
  `Cantidad_ML` int(11) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Precio` decimal(5,2) DEFAULT NULL,
  `ImagenBebida` longblob DEFAULT NULL,
  `IdAlmacen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bebidas`
--

INSERT INTO `bebidas` (`IdBebidas`, `Descripcion`, `Cantidad_ML`, `Cantidad`, `Precio`, `ImagenBebida`, `IdAlmacen`) VALUES
(5, 'Coca Cola', 500, 100, 1.50, NULL, 9),
(6, 'Coca Cola', 500, 100, 1.50, NULL, 9),
(8, 'Coca Cola', 600, 1, 17.50, NULL, 9),
(9, 'Coca Cola', 600, 1, 17.50, NULL, 9),
(10, 'Coca Cola', 600, 1, 19.90, NULL, 9),
(11, 'Fanta', 600, 1, 10.00, NULL, 12),
(12, 'Fanta', 600, 1, 10.00, NULL, 12),
(13, 'Fanta', 600, 12, 10.00, NULL, 12),
(14, 'Fanta', 600, 12, 10.00, NULL, 12);

--
-- Disparadores `bebidas`
--
DELIMITER $$
CREATE TRIGGER `ActualizarBebidas` AFTER UPDATE ON `bebidas` FOR EACH ROW BEGIN
    IF NOT (OLD.Cantidad <=> NEW.Cantidad) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Bebidas', 'Cantidad', OLD.Cantidad, NEW.Cantidad, NOW());
    END IF;
    IF NOT (OLD.Cantidad_ML <=> NEW.Cantidad_ML) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Bebidas', 'Cantidad ML', OLD.Cantidad_ML, NEW.Cantidad_ML, NOW());
    END IF;
    IF NOT (OLD.Descripcion <=> NEW.Descripcion) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Bebidas', 'Descripcion', OLD.Descripcion, NEW.Descripcion, NOW());
    END IF;
    IF NOT (OLD.Precio <=> NEW.Precio) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Bebidas', 'Precio', OLD.Precio, NEW.Precio, NOW());
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `EliminarBebida` AFTER DELETE ON `bebidas` FOR EACH ROW BEGIN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Eliminar', 'Bebidas', '-', '-', '-', NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `InsertDrinks` AFTER INSERT ON `bebidas` FOR EACH ROW BEGIN

    UPDATE Almacen SET Total = Total + NEW.Cantidad
    WHERE descripcion = NEW.Descripcion;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `InsertarBebida` AFTER INSERT ON `bebidas` FOR EACH ROW BEGIN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1), 'Insertar', 'Bebidas', '-', '-', '-', NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bebidas_has_ordenes`
--

CREATE TABLE `bebidas_has_ordenes` (
  `IdBebidas` int(11) DEFAULT NULL,
  `IdCategorias` int(11) DEFAULT NULL,
  `IdAlmacen` int(11) DEFAULT NULL,
  `IdOrdenes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bebidas_has_pedidos`
--

CREATE TABLE `bebidas_has_pedidos` (
  `IdBebidas` int(11) DEFAULT NULL,
  `IdCategorias` int(11) DEFAULT NULL,
  `IdAlmacen` int(11) DEFAULT NULL,
  `IdPedidos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `IdBitacora` int(11) NOT NULL,
  `Responsable` varchar(10) DEFAULT NULL,
  `Operacion` varchar(20) DEFAULT NULL,
  `TablaObjetivo` varchar(45) DEFAULT NULL,
  `Atributo` varchar(45) DEFAULT NULL,
  `ValorAnterior` varchar(45) DEFAULT NULL,
  `ValorNuevo` varchar(45) DEFAULT NULL,
  `FechaMovimiento` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`IdBitacora`, `Responsable`, `Operacion`, `TablaObjetivo`, `Atributo`, `ValorAnterior`, `ValorNuevo`, `FechaMovimiento`) VALUES
(5, 'root', 'Eliminar', 'Almacen', '-', '-', '-', '2024-06-10 00:58:09'),
(6, 'root', 'Eliminar', 'Almacen', '-', '-', '-', '2024-06-10 00:58:24'),
(7, 'root', 'Insertar', 'Platillos', '-', '-', '-', '2024-06-10 01:13:12'),
(8, 'root', 'Insertar', 'Platillos', '-', '-', '-', '2024-06-10 02:14:16'),
(9, 'root', 'Eliminar', 'Platillos', '-', '-', '-', '2024-06-10 02:15:10'),
(10, 'root', 'Insertar', 'Platillos', '-', '-', '-', '2024-06-10 02:16:18'),
(11, 'root', 'Eliminar', 'Platillos', '-', '-', '-', '2024-06-10 02:17:07'),
(12, 'root', 'Eliminar', 'Platillos', '-', '-', '-', '2024-06-10 02:17:14'),
(13, 'root', 'Insertar', 'Platillos', '-', '-', '-', '2024-06-10 02:18:48'),
(14, 'root', 'Insertar', 'Platillos', '-', '-', '-', '2024-06-10 02:23:34'),
(15, 'root', 'Insertar', 'Platillos', '-', '-', '-', '2024-06-10 08:32:39'),
(16, 'root', 'Actualizar', 'Almacen', 'Total', '21', '22', '2024-06-10 11:41:49'),
(17, 'root', 'Insertar', 'Ingredientes', '-', '-', '-', '2024-06-10 11:41:49'),
(18, 'root', 'Eliminar', 'Platillos', '-', '-', '-', '2024-06-10 11:48:48'),
(19, 'root', 'Actualizar', 'Almacen', 'Total', '302', '314', '2024-06-10 12:12:09'),
(20, 'root', 'Insertar', 'Bebidas', '-', '-', '-', '2024-06-10 12:12:09'),
(21, 'root', 'Insertar', 'Ordenes', '-', '-', '-', '2024-06-10 12:16:20'),
(22, 'root', 'Insertar', 'Ordenes', '-', '-', '-', '2024-06-11 11:44:47'),
(23, 'root', 'Actualizar', 'Almacen', 'Total', '22', '34', '2024-06-12 20:27:56'),
(24, 'root', 'Insertar', 'Ingredientes', '-', '-', '-', '2024-06-12 20:27:56'),
(25, 'root', 'Actualizar', 'Almacen', 'Total', '314', '326', '2024-06-12 20:51:23'),
(26, 'root', 'Insertar', 'Bebidas', '-', '-', '-', '2024-06-12 20:51:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `IdCategorias` int(11) NOT NULL,
  `Descripcion` varchar(45) DEFAULT NULL,
  `Fecha_Creacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`IdCategorias`, `Descripcion`, `Fecha_Creacion`) VALUES
(1, 'Entradas', '2024-05-10 22:12:11'),
(2, 'Platos Principales', '2024-05-10 22:12:11'),
(3, 'Postres', '2024-05-10 22:12:11'),
(4, 'Bebida', '2024-05-10 22:12:11'),
(5, 'Nueva', '2024-06-08 22:09:13'),
(7, 'Categoria 2', '2024-06-09 03:55:00'),
(8, 'Categoria 2', '2024-06-09 03:56:48');

--
-- Disparadores `categorias`
--
DELIMITER $$
CREATE TRIGGER `ActualizarCategorias` AFTER UPDATE ON `categorias` FOR EACH ROW BEGIN
    IF NOT (OLD.Descripcion <=> NEW.Descripcion) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Categorias', 'Descripcion', OLD.Descripcion, NEW.Descripcion, NOW());
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `EliminarCategorias` AFTER DELETE ON `categorias` FOR EACH ROW BEGIN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Eliminar', 'Categorias', '-', '-', '-', NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `InsertarCategorias` AFTER INSERT ON `categorias` FOR EACH ROW BEGIN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1), 'Insertar', 'Categorias', '-', '-', '-', NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_has_bebidas`
--

CREATE TABLE `categorias_has_bebidas` (
  `IdCategorias` int(11) DEFAULT NULL,
  `IdBebidas` int(11) DEFAULT NULL,
  `IdAlmacen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_has_platillos`
--

CREATE TABLE `categorias_has_platillos` (
  `IdCategorias` int(11) DEFAULT NULL,
  `IdPLatillos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias_has_platillos`
--

INSERT INTO `categorias_has_platillos` (`IdCategorias`, `IdPLatillos`) VALUES
(1, 4),
(NULL, 5),
(3, 9),
(1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE `ingredientes` (
  `IdIngredientes` int(11) NOT NULL,
  `Descripcion` varchar(45) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `U_Medida` varchar(15) DEFAULT NULL,
  `IdAlmacen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`IdIngredientes`, `Descripcion`, `Cantidad`, `U_Medida`, `IdAlmacen`) VALUES
(10, 'Papas', 10, 'Kg', 13),
(11, 'Papas', 10, 'Kg', 13),
(12, 'Papas', 10, 'Kg', 13),
(13, 'Tomate', 10, 'Kg', 14),
(15, 'Papas', 1, 'unidad', 13),
(16, 'Papas', 1, 'unidad', 13),
(17, 'Papas', 12, 'unidad', 13);

--
-- Disparadores `ingredientes`
--
DELIMITER $$
CREATE TRIGGER `ActualizarIngredientes` AFTER UPDATE ON `ingredientes` FOR EACH ROW BEGIN
    IF NOT (OLD.Cantidad <=> NEW.Cantidad) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Ingredientes', 'Cantidad', OLD.Cantidad, NEW.Cantidad, NOW());
    END IF;
    IF NOT (OLD.Descripcion <=> NEW.Descripcion) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Ingredientes', 'Descripcion', OLD.Descripcion, NEW.Descripcion, NOW());
    END IF;
    IF NOT (OLD.IdAlmacen <=> NEW.IdAlmacen) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Ingredientes', 'IdAlmacen', OLD.IdAlmacen, NEW.IdAlmacen, NOW());
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `EliminarIngredientes` AFTER DELETE ON `ingredientes` FOR EACH ROW BEGIN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Eliminar', 'Ingredientes', '-', '-', '-', NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `IngredientsAlmacenUpdate` AFTER INSERT ON `ingredientes` FOR EACH ROW BEGIN
    UPDATE Almacen SET Total = Total + NEW.Cantidad
    WHERE descripcion = NEW.Descripcion ;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `InsertarIngredientes` AFTER INSERT ON `ingredientes` FOR EACH ROW BEGIN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1), 'Insertar', 'Ingredientes', '-', '-', '-', NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `IdOrdenes` int(11) NOT NULL,
  `Estado` varchar(25) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Hora` time DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Monto` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`IdOrdenes`, `Estado`, `Fecha`, `Hora`, `Cantidad`, `Monto`) VALUES
(1, 'En espera', '2024-05-10', '10:00:00', 3, 50.00),
(2, 'En proceso', '2024-05-11', '11:30:00', 5, 75.50),
(3, 'En proceso', '2024-05-12', '12:45:00', 2, 30.25),
(4, 'Completado', '2024-05-13', '14:00:00', 4, 60.00),
(5, 'En espera', '2024-05-14', '15:20:00', 1, 15.99),
(14, 'En espera', '2024-05-24', '16:03:33', 1, 50.00),
(15, 'En espera', '2024-05-24', '16:05:36', 1, 150.00),
(16, 'En espera', '2024-05-24', '16:06:56', 1, 150.00),
(17, 'En espera', '2024-10-10', '10:00:00', 1, 100.00),
(18, 'En espera', '2024-10-10', '10:00:00', 2, 100.00),
(20, 'Activo', '2024-05-30', '12:00:00', 10, 150.00),
(23, 'En espera', '2024-06-10', '20:16:20', 1, 50.00),
(24, 'En espera', '2024-06-11', '19:44:47', 1, 50.00);

--
-- Disparadores `ordenes`
--
DELIMITER $$
CREATE TRIGGER `ActualizarOrdenes` AFTER UPDATE ON `ordenes` FOR EACH ROW BEGIN
    IF NOT (OLD.Cantidad <=> NEW.Cantidad) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Ordenes', 'Cantidad', OLD.Cantidad, NEW.Cantidad, NOW());
    END IF;
    IF NOT (OLD.Estado <=> NEW.Estado) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Ordenes', 'Estado', OLD.Estado, NEW.Estado, NOW());
    END IF;
    IF NOT (OLD.Monto <=> NEW.Monto) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Ordenes', 'Monto', OLD.Monto, NEW.Monto, NOW());
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `EliminarOrdenes` AFTER DELETE ON `ordenes` FOR EACH ROW BEGIN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Eliminar', 'Ordenes', '-', '-', '-', NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `InsertHas` AFTER INSERT ON `ordenes` FOR EACH ROW BEGIN

    DECLARE IdO INT;
    DECLARE IdV INT;
    DECLARE sum DECIMAL(10,2);

    SET IdO = NEW.IdOrdenes;
    SET sum = NEW.Cantidad * NEW.Monto;

    INSERT INTO ventas(Cantidad, Fecha, Hora, Total)
    VALUES(NEW.Cantidad, NEW.Fecha, NEW.Hora, sum);

    SET IdV = LAST_INSERT_ID();

    INSERT INTO ordenes_has_ventas(IdOrdenes, IdVentas)
    VALUES(IdO, IdV);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `InsertarOrdenes` AFTER INSERT ON `ordenes` FOR EACH ROW BEGIN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1), 'Insertar', 'Ordenes', '-', '-', '-', NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_has_ventas`
--

CREATE TABLE `ordenes_has_ventas` (
  `IdOrdenes` int(11) DEFAULT NULL,
  `IdVentas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenes_has_ventas`
--

INSERT INTO `ordenes_has_ventas` (`IdOrdenes`, `IdVentas`) VALUES
(17, 6),
(18, 7),
(20, 8),
(23, 11),
(24, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `IdPedidos` int(11) NOT NULL,
  `Estado` varchar(25) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Hora` time DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Monto` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`IdPedidos`, `Estado`, `Fecha`, `Hora`, `Cantidad`, `Monto`) VALUES
(1, 'Entregado', '2024-05-10', '14:30:00', 2, 25.99),
(2, 'Entregado', '2024-05-11', '15:45:00', 3, 35.75),
(3, 'Entregado', '2024-05-12', '12:00:00', 1, 15.50),
(4, 'En proceso', '2024-05-13', '16:00:00', 4, 45.25),
(5, 'Entregado', '2024-05-14', '18:20:00', 2, 28.99),
(6, 'En espera', '2024-06-09', '02:31:06', 1, 50.00);

--
-- Disparadores `pedidos`
--
DELIMITER $$
CREATE TRIGGER `ActualizarPedidos` AFTER UPDATE ON `pedidos` FOR EACH ROW BEGIN
    IF NOT (OLD.Cantidad <=> NEW.Cantidad) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Pedidos', 'Cantidad', OLD.Cantidad, NEW.Cantidad, NOW());
    END IF;
    IF NOT (OLD.Estado <=> NEW.Estado) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Pedidos', 'Estado', OLD.Estado, NEW.Estado, NOW());
    END IF;
    IF NOT (OLD.Monto <=> NEW.Monto) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Pedidos', 'Monto', OLD.Monto, NEW.Monto, NOW());
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `EliminarPedidos` AFTER DELETE ON `pedidos` FOR EACH ROW BEGIN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Eliminar', 'Pedidos', '-', '-', '-', NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `InsertarPedidos` AFTER INSERT ON `pedidos` FOR EACH ROW BEGIN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1), 'Insertar', 'Pedidos', '-', '-', '-', NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_has_ventas`
--

CREATE TABLE `pedidos_has_ventas` (
  `IdPedidos` int(11) DEFAULT NULL,
  `IdVentas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platillos`
--

CREATE TABLE `platillos` (
  `IdPLatillos` int(11) NOT NULL,
  `Descripcion` varchar(45) DEFAULT NULL,
  `Precio` decimal(5,2) DEFAULT NULL,
  `ImagenPlatillo` longblob DEFAULT NULL,
  `FechaCreacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `platillos`
--

INSERT INTO `platillos` (`IdPLatillos`, `Descripcion`, `Precio`, `ImagenPlatillo`, `FechaCreacion`) VALUES
(1, 'Ensalada', 8.99, NULL, '2024-06-10 00:06:14'),
(2, 'Spaghetti', 12.99, NULL, '2024-06-10 00:06:14'),
(3, 'Pollo asado', 10.99, NULL, '2024-06-10 00:06:14'),
(4, 'Tacos', NULL, NULL, '2024-06-10 00:26:45'),
(5, 'Macarrones', NULL, NULL, '2024-06-10 00:33:04'),
(9, 'Gelatina', NULL, NULL, '2024-06-10 02:18:48'),
(10, 'Tacos al pastor', NULL, NULL, '2024-06-10 02:23:34');

--
-- Disparadores `platillos`
--
DELIMITER $$
CREATE TRIGGER `ActualizarPlatillos` AFTER UPDATE ON `platillos` FOR EACH ROW BEGIN
    IF NOT (OLD.Descripcion <=> NEW.Descripcion) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Platillos', 'Descripcion', OLD.Descripcion, NEW.Descripcion, NOW());
    END IF;
    IF NOT (OLD.ImagenPlatillo <=> NEW.ImagenPlatillo) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Platillos', 'ImagenPlatillo', OLD.ImagenPlatillo, NEW.ImagenPlatillo, NOW());
    END IF;
    IF NOT (OLD.Precio <=> NEW.Precio) THEN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Actualizar', 'Platillos', 'Precio', OLD.Precio, NEW.Precio, NOW());
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `EliminarPlatillos` AFTER DELETE ON `platillos` FOR EACH ROW BEGIN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1),'Eliminar', 'Platillos', '-', '-', '-', NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `InsertarPlatillos` AFTER INSERT ON `platillos` FOR EACH ROW BEGIN
        INSERT INTO bitacora (Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento)
        VALUES (SUBSTRING_INDEX(USER(), '@', 1), 'Insertar', 'Platillos', '-', '-', '-', NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platillos_has_ingredientes`
--

CREATE TABLE `platillos_has_ingredientes` (
  `IdPLatillos` int(11) DEFAULT NULL,
  `IdCategorias` int(11) DEFAULT NULL,
  `IdIngredientes` int(11) DEFAULT NULL,
  `IdAlmacen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platillos_has_ordenes`
--

CREATE TABLE `platillos_has_ordenes` (
  `IdPLatillos` int(11) DEFAULT NULL,
  `IdCategorias` int(11) DEFAULT NULL,
  `IdOrdenes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platillos_has_pedidos`
--

CREATE TABLE `platillos_has_pedidos` (
  `IdPLatillos` int(11) DEFAULT NULL,
  `IdCategorias` int(11) DEFAULT NULL,
  `IdPedidos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `IdUsuarios` int(11) NOT NULL,
  `Foto` longblob DEFAULT NULL,
  `Tipo_Usuario` varchar(20) DEFAULT NULL,
  `Nombre` varchar(25) DEFAULT NULL,
  `ApellidoP` varchar(20) DEFAULT NULL,
  `ApellidoM` varchar(20) DEFAULT NULL,
  `Contacto` varchar(10) DEFAULT NULL,
  `Username` varchar(10) DEFAULT NULL,
  `Contrasena` varchar(10) NOT NULL,
  `Fecha_Alta` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IdUsuarios`, `Foto`, `Tipo_Usuario`, `Nombre`, `ApellidoP`, `ApellidoM`, `Contacto`, `Username`, `Contrasena`, `Fecha_Alta`) VALUES
(1, NULL, 'Administrador', 'Jonathan', 'Martinez', 'Hernandez', '4831085480', 'Jon', 'sixvegas12', '2024-05-10 00:36:47'),
(2, NULL, 'Empleado', 'Mario', 'Rojas', 'Perezs', '4831214545', 'Mar23', 'Sixvegas12', '2024-05-21 05:30:59'),
(7, NULL, 'Empleado', 'Jonathan', 'Martinez', 'Hernandez', '4831085480', 'qwerty', 'Sixvegas12', '2024-06-11 11:32:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `IdVentas` int(11) NOT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Hora` time DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`IdVentas`, `Cantidad`, `Fecha`, `Hora`, `Total`) VALUES
(1, 3, '2024-05-10', '10:00:00', 150.00),
(2, 5, '2024-05-11', '11:30:00', 100.50),
(3, 2, '2024-05-12', '12:45:00', 60.50),
(4, 4, '2024-05-13', '14:00:00', 240.00),
(5, 1, '2024-05-14', '15:20:00', 15.99),
(6, 1, '2024-10-10', '10:00:00', 100.00),
(7, 2, '2024-10-10', '10:00:00', 200.00),
(8, 10, '2024-05-30', '12:00:00', 1500.00),
(9, 10, '2024-05-30', '12:00:00', 1500.00),
(10, 1, '2024-06-09', '09:35:10', 50.00),
(11, 1, '2024-06-10', '20:16:20', 50.00),
(12, 1, '2024-06-11', '19:44:47', 50.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`IdAlmacen`);

--
-- Indices de la tabla `bebidas`
--
ALTER TABLE `bebidas`
  ADD PRIMARY KEY (`IdBebidas`),
  ADD KEY `IdAlmacen` (`IdAlmacen`);

--
-- Indices de la tabla `bebidas_has_ordenes`
--
ALTER TABLE `bebidas_has_ordenes`
  ADD KEY `IdBebidas` (`IdBebidas`),
  ADD KEY `IdCategorias` (`IdCategorias`),
  ADD KEY `IdAlmacen` (`IdAlmacen`),
  ADD KEY `IdOrdenes` (`IdOrdenes`);

--
-- Indices de la tabla `bebidas_has_pedidos`
--
ALTER TABLE `bebidas_has_pedidos`
  ADD KEY `IdBebidas` (`IdBebidas`),
  ADD KEY `IdCategorias` (`IdCategorias`),
  ADD KEY `IdAlmacen` (`IdAlmacen`),
  ADD KEY `IdPedidos` (`IdPedidos`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`IdBitacora`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`IdCategorias`);

--
-- Indices de la tabla `categorias_has_bebidas`
--
ALTER TABLE `categorias_has_bebidas`
  ADD KEY `IdCategorias` (`IdCategorias`),
  ADD KEY `IdBebidas` (`IdBebidas`),
  ADD KEY `IdAlmacen` (`IdAlmacen`);

--
-- Indices de la tabla `categorias_has_platillos`
--
ALTER TABLE `categorias_has_platillos`
  ADD KEY `IdCategorias` (`IdCategorias`),
  ADD KEY `IdPLatillos` (`IdPLatillos`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`IdIngredientes`),
  ADD KEY `IdAlmacen` (`IdAlmacen`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`IdOrdenes`);

--
-- Indices de la tabla `ordenes_has_ventas`
--
ALTER TABLE `ordenes_has_ventas`
  ADD KEY `IdOrdenes` (`IdOrdenes`),
  ADD KEY `IdVentas` (`IdVentas`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`IdPedidos`);

--
-- Indices de la tabla `pedidos_has_ventas`
--
ALTER TABLE `pedidos_has_ventas`
  ADD KEY `IdPedidos` (`IdPedidos`),
  ADD KEY `IdVentas` (`IdVentas`);

--
-- Indices de la tabla `platillos`
--
ALTER TABLE `platillos`
  ADD PRIMARY KEY (`IdPLatillos`);

--
-- Indices de la tabla `platillos_has_ingredientes`
--
ALTER TABLE `platillos_has_ingredientes`
  ADD KEY `IdPLatillos` (`IdPLatillos`),
  ADD KEY `IdCategorias` (`IdCategorias`),
  ADD KEY `IdIngredientes` (`IdIngredientes`),
  ADD KEY `IdAlmacen` (`IdAlmacen`);

--
-- Indices de la tabla `platillos_has_ordenes`
--
ALTER TABLE `platillos_has_ordenes`
  ADD KEY `IdPLatillos` (`IdPLatillos`),
  ADD KEY `IdCategorias` (`IdCategorias`),
  ADD KEY `IdOrdenes` (`IdOrdenes`);

--
-- Indices de la tabla `platillos_has_pedidos`
--
ALTER TABLE `platillos_has_pedidos`
  ADD KEY `IdPLatillos` (`IdPLatillos`),
  ADD KEY `IdCategorias` (`IdCategorias`),
  ADD KEY `IdPedidos` (`IdPedidos`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IdUsuarios`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`IdVentas`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `IdAlmacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `bebidas`
--
ALTER TABLE `bebidas`
  MODIFY `IdBebidas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `IdBitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `IdCategorias` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `IdIngredientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `IdOrdenes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `IdPedidos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `platillos`
--
ALTER TABLE `platillos`
  MODIFY `IdPLatillos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `IdUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `IdVentas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bebidas`
--
ALTER TABLE `bebidas`
  ADD CONSTRAINT `bebidas_ibfk_1` FOREIGN KEY (`IdAlmacen`) REFERENCES `almacen` (`IdAlmacen`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `bebidas_has_ordenes`
--
ALTER TABLE `bebidas_has_ordenes`
  ADD CONSTRAINT `bebidas_has_ordenes_ibfk_1` FOREIGN KEY (`IdBebidas`) REFERENCES `bebidas` (`IdBebidas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bebidas_has_ordenes_ibfk_2` FOREIGN KEY (`IdCategorias`) REFERENCES `categorias` (`IdCategorias`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bebidas_has_ordenes_ibfk_3` FOREIGN KEY (`IdAlmacen`) REFERENCES `almacen` (`IdAlmacen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bebidas_has_ordenes_ibfk_4` FOREIGN KEY (`IdOrdenes`) REFERENCES `ordenes` (`IdOrdenes`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `bebidas_has_pedidos`
--
ALTER TABLE `bebidas_has_pedidos`
  ADD CONSTRAINT `bebidas_has_pedidos_ibfk_1` FOREIGN KEY (`IdBebidas`) REFERENCES `bebidas` (`IdBebidas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bebidas_has_pedidos_ibfk_2` FOREIGN KEY (`IdCategorias`) REFERENCES `categorias` (`IdCategorias`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bebidas_has_pedidos_ibfk_3` FOREIGN KEY (`IdAlmacen`) REFERENCES `almacen` (`IdAlmacen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bebidas_has_pedidos_ibfk_4` FOREIGN KEY (`IdPedidos`) REFERENCES `pedidos` (`IdPedidos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `categorias_has_bebidas`
--
ALTER TABLE `categorias_has_bebidas`
  ADD CONSTRAINT `categorias_has_bebidas_ibfk_1` FOREIGN KEY (`IdCategorias`) REFERENCES `categorias` (`IdCategorias`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categorias_has_bebidas_ibfk_2` FOREIGN KEY (`IdBebidas`) REFERENCES `bebidas` (`IdBebidas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categorias_has_bebidas_ibfk_3` FOREIGN KEY (`IdAlmacen`) REFERENCES `almacen` (`IdAlmacen`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `categorias_has_platillos`
--
ALTER TABLE `categorias_has_platillos`
  ADD CONSTRAINT `categorias_has_platillos_ibfk_1` FOREIGN KEY (`IdCategorias`) REFERENCES `categorias` (`IdCategorias`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categorias_has_platillos_ibfk_2` FOREIGN KEY (`IdPLatillos`) REFERENCES `platillos` (`IdPLatillos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD CONSTRAINT `ingredientes_ibfk_1` FOREIGN KEY (`IdAlmacen`) REFERENCES `almacen` (`IdAlmacen`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ordenes_has_ventas`
--
ALTER TABLE `ordenes_has_ventas`
  ADD CONSTRAINT `ordenes_has_ventas_ibfk_1` FOREIGN KEY (`IdOrdenes`) REFERENCES `ordenes` (`IdOrdenes`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ordenes_has_ventas_ibfk_2` FOREIGN KEY (`IdVentas`) REFERENCES `ventas` (`IdVentas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos_has_ventas`
--
ALTER TABLE `pedidos_has_ventas`
  ADD CONSTRAINT `pedidos_has_ventas_ibfk_1` FOREIGN KEY (`IdPedidos`) REFERENCES `pedidos` (`IdPedidos`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedidos_has_ventas_ibfk_2` FOREIGN KEY (`IdVentas`) REFERENCES `ventas` (`IdVentas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `platillos_has_ingredientes`
--
ALTER TABLE `platillos_has_ingredientes`
  ADD CONSTRAINT `platillos_has_ingredientes_ibfk_1` FOREIGN KEY (`IdPLatillos`) REFERENCES `platillos` (`IdPLatillos`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `platillos_has_ingredientes_ibfk_2` FOREIGN KEY (`IdCategorias`) REFERENCES `categorias` (`IdCategorias`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `platillos_has_ingredientes_ibfk_3` FOREIGN KEY (`IdIngredientes`) REFERENCES `ingredientes` (`IdIngredientes`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `platillos_has_ingredientes_ibfk_4` FOREIGN KEY (`IdAlmacen`) REFERENCES `almacen` (`IdAlmacen`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `platillos_has_ordenes`
--
ALTER TABLE `platillos_has_ordenes`
  ADD CONSTRAINT `platillos_has_ordenes_ibfk_1` FOREIGN KEY (`IdPLatillos`) REFERENCES `platillos` (`IdPLatillos`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `platillos_has_ordenes_ibfk_2` FOREIGN KEY (`IdCategorias`) REFERENCES `categorias` (`IdCategorias`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `platillos_has_ordenes_ibfk_3` FOREIGN KEY (`IdOrdenes`) REFERENCES `ordenes` (`IdOrdenes`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `platillos_has_pedidos`
--
ALTER TABLE `platillos_has_pedidos`
  ADD CONSTRAINT `platillos_has_pedidos_ibfk_1` FOREIGN KEY (`IdPLatillos`) REFERENCES `platillos` (`IdPLatillos`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `platillos_has_pedidos_ibfk_2` FOREIGN KEY (`IdCategorias`) REFERENCES `categorias` (`IdCategorias`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `platillos_has_pedidos_ibfk_3` FOREIGN KEY (`IdPedidos`) REFERENCES `pedidos` (`IdPedidos`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
