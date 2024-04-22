# --------------------------- PROCEDIMIENTO 1  ---------------------
DELIMITER //
CREATE PROCEDURE InsertDrinks(IN p_Descripcion VARCHAR(25), IN p_Cantidad INT, IN p_Cantidad_ML INT, IN p_Precio DECIMAL(5,2))
BEGIN
    DECLARE v_IdAlmacenExistente INT;
    DECLARE v_TotalExistente INT;
    
    -- Buscar si la bebida ya está en el almacén y coincide con cantidad en ML y el precio
    SELECT IdAlmacen, Total INTO v_IdAlmacenExistente, v_TotalExistente 
    FROM Almacen
    WHERE Descripcion = p_Descripcion ;
    IF v_IdAlmacenExistente IS NOT NULL THEN
        -- Si la bebida ya está en el almacén, actualizar el total
        UPDATE Almacen SET Total = p_Cantidad + v_TotalExistente, Diponibles = v_TotalExistente + p_Cantidad
        WHERE IdAlmacen = v_IdAlmacenExistente;
    ELSE
        -- Si la bebida no está en el almacén, insertarla
        INSERT INTO Almacen (Descripcion, Total, Diponibles, Defectuosos)
        VALUES (p_Descripcion, p_Cantidad, p_Cantidad, 0);
        -- Obtener el nuevo IdAlmacen
        SET v_IdAlmacenExistente = (SELECT MAX(IdAlmacen) FROM Almacen);
            -- Insertar la bebida en la tabla Bebidas
    INSERT INTO Bebidas (Descripcion, Cantidad_ML, Precio, IdAlmacen)
    VALUES (p_Descripcion, p_Cantidad_ML, p_Precio, v_IdAlmacenExistente);
    END IF;
END //
DELIMITER ;

# ------------- PROCEDIMIENTO 2
DELIMITER //
CREATE PROCEDURE InsertarIngredients(IN p_Descripcion VARCHAR(25), IN p_Cantidad INT, IN p_UMedida VARCHAR(15))
BEGIN
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
END //
DELIMITER ;
