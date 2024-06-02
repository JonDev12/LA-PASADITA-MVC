-- TODO this SQL trigger need to be tested
CREATE TRIGGER UpdateForOrder
AFTER UPDATE ON ventas
FOR EACH ROW
BEGIN
    IF NEW.Cantidad != OLD.Cantidad OR NEW.total != OLD.total THEN
        -- Actualiza el campo Cantidad en la tabla ordenes
        UPDATE ordenes 
        SET Cantidad = NEW.Cantidad
        WHERE IdOrdenes = OLD.IdOrdenes;
    END IF;
END;