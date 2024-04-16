CREATE DATABASE IF NOT EXISTS DB_PASADITA;
USE DB_PASADITA;

CREATE TABLE Categorias (
    IdCategorias INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Descripcion VARCHAR(45),
    Fecha_Creacion DATETIME
);

CREATE TABLE Categorias_has_Bebidas (
    IdCategorias INT, 
    IdBebidas INT,
    IdAlmacen INT, -- Coma agregada
    FOREIGN KEY (IdCategorias) REFERENCES Categorias(IdCategorias) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdBebidas) REFERENCES Bebidas(IdBebidas) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdAlmacen) REFERENCES Almacen(IdAlmacen) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Bebidas (
    IdBebidas INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Descripcion VARCHAR(25),
    Cantidad_ML INT, 
    Precio DECIMAL(5,2),
    ImagenBebida LONGBLOB,
    IdAlmacen INT,
    FOREIGN KEY(IdAlmacen) REFERENCES Almacen(IdAlmacen) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Bebidas_has_Ordenes (
    IdBebidas INT, 
    IdCategorias INT, 
    IdAlmacen INT, 
    IdOrdenes INT, 
    FOREIGN KEY (IdBebidas) REFERENCES Bebidas(IdBebidas) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdCategorias) REFERENCES Categorias(IdCategorias) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdAlmacen) REFERENCES Almacen(IdAlmacen) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdOrdenes) REFERENCES Ordenes(IdOrdenes) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Bebidas_has_Pedidos (
    IdBebidas INT, 
    IdCategorias INT, 
    IdAlmacen INT, 
    IdPedidos INT, 
    FOREIGN KEY (IdBebidas) REFERENCES Bebidas(IdBebidas) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdCategorias) REFERENCES Categorias(IdCategorias) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdAlmacen) REFERENCES Almacen(IdAlmacen) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdPedidos) REFERENCES Pedidos(IdPedidos) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Ordenes (
    IdOrdenes INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    Estado VARCHAR(25), 
    Fecha DATE, 
    Hora TIME,
    Cantidad INT, 
    Monto DECIMAL(10,2)
);

CREATE TABLE Pedidos (
    IdPedidos INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    Estado VARCHAR(25), 
    Fecha DATE, 
    Hora TIME,
    Cantidad INT, 
    Monto DECIMAL(10,2)
);

CREATE TABLE Platillos_has_Pedidos (
    IdPLatillos INT,
    IdCategorias INT, 
    IdPedidos INT, 
    FOREIGN KEY (IdPLatillos) REFERENCES Platillos(IdPLatillos) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdCategorias) REFERENCES Categorias(IdCategorias) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdPedidos) REFERENCES Pedidos(IdPedidos) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Platillos_has_Ordenes (
    IdPLatillos INT,
    IdCategorias INT, 
    IdOrdenes INT, 
    FOREIGN KEY (IdPLatillos) REFERENCES Platillos(IdPLatillos) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdCategorias) REFERENCES Categorias(IdCategorias) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdOrdenes) REFERENCES Ordenes(IdOrdenes) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Platillos (
    IdPLatillos INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    Descripcion VARCHAR(45), 
    Precio DECIMAL(5,2), 
    ImagenPlatillo LONGBLOB, -- Coma agregada
    IdCategorias INT,
    FOREIGN KEY (IdCategorias) REFERENCES Categorias(IdCategorias) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Platillos_has_Ingredientes (
    IdPLatillos INT, 
    IdCategorias INT, 
    IdIngredientes INT, 
    IdAlmacen INT,
    FOREIGN KEY (IdPLatillos) REFERENCES Platillos(IdPLatillos) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdCategorias) REFERENCES Categorias(IdCategorias) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdIngredientes) REFERENCES Ingredientes(IdIngredientes) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (IdAlmacen) REFERENCES Almacen(IdAlmacen) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Ingredientes (
    IdIngredientes INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    Descripcion VARCHAR(45),
    Cantidad INT, 
    U_Medida VARCHAR(15),
    IdAlmacen INT,
    FOREIGN KEY (IdAlmacen) REFERENCES Almacen(IdAlmacen) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Almacen (
    IdAlmacen INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Descripcion VARCHAR(25),
    Total INT, 
    Diponibles INT, 
    Defectuosos INT
);

CREATE TABLE Ordenes_has_Ventas (
    IdOrdenes INT,
    IdVentas INT,
    FOREIGN KEY(IdOrdenes) REFERENCES Ordenes(IdOrdenes) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(IdVentas) REFERENCES Ventas(IdVentas) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Pedidos_has_Ventas (
    IdPedidos INT,
    IdVentas INT,
    FOREIGN KEY(IdPedidos) REFERENCES Pedidos(IdPedidos) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(IdVentas) REFERENCES Ventas(IdVentas) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Ventas (
    IdVentas INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Cantidad INT, 
    Fecha DATE, 
    Hora TIME, 
    Total DECIMAL(10,2)
);

CREATE TABLE Usuarios (
    IdUsuarios INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    Foto LONGBLOB, -- Coma agregada
    Tipo_Usuario VARCHAR(20),
    Nombre VARCHAR(25),
    ApellidoP VARCHAR(20),
    ApellidoM VARCHAR(20),
    Contacto VARCHAR(10),
    Username VARCHAR(10), 
    Contraseña VARCHAR(10)
);
