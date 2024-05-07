CREATE PROCEDURE InsertSaleByOrder (IN ST VARCHAR(25), IN C INT, IN M DECIMAL(10, 2)) BEGIN DECLARE IDV INT;

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

END;