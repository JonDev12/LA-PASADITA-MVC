

CREATE TRIGGER InsertHas
AFTER INSERT ON ordenes
FOR EACH ROW
BEGIN
    -- Insertar datos en la tabla ventas
    INSERT INTO ventas (Cantidad, Fecha, Hora, Total)  
    VALUES (NEW.Cantidad, CURRENT_DATE(), CURRENT_TIME(), NEW.Total);
    
    -- Insertar datos en la tabla ordenes_has_ventas
    INSERT INTO ordenes_has_ventas (IdOrdenes, IdVentas)
    VALUES (NEW.IdOrdenes, LAST_INSERT_ID());
END;
