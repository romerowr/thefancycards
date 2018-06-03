/*
nuevoUsuario requiere (username,password,email y rol), el ID por defecto es autonumerico y activo es TRUE
*/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `nuevoUsuario`
(IN outNombreUsuario VARCHAR(12), outPassword VARCHAR(45), outEmail VARCHAR(45), outRoles_idRol INT(2))
BEGIN
    INSERT INTO usuarios(nombreUsuario,password,email,roles_idRol) VALUES
		(outNombreUsuario,outPassword,outEmail,outRoles_idRol);
END $$
DELIMITER ;

-- fin nuevoUsuario

/*
nuevoProducto requiere (nombre,descripcion,precio  1 categoria y una imagen), 
el ID por defecto es autonumerico y activo es TRUE, la categoria tiene que ser existente,
la imagen que se pasa es un path, que se creara en ese momento
*/

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `nuevoProducto`
(IN outNombreProducto VARCHAR(45), outDescripcion VARCHAR(55), outPrecio DOUBLE,
	outNombreCategoria VARCHAR(45),
    outPath VARCHAR(255))
BEGIN
	DECLARE miIdCategoria INT;
    DECLARE lastIdProducto INT;
    select idCategoria into miIdCategoria from categorias  where nombre=outNombreCategoria LIMIT 1;
    -- comprobamos si la categoria existe
    if miIdCategoria is not null then
        -- insertamos producto nuevo
        INSERT INTO productos(nombre,descripcion,precio) VALUES
			(outNombreProducto,outDescripcion,outPrecio);
        -- recogemos la ultima id del nuevo producto    
		SELECT idProducto into lastIdProducto from productos  where nombre=outNombreProducto order by idProducto DESC LIMIT 1;
		-- insertamos la relacion entre porducto y categoria
		INSERT INTO productos_has_categorias VALUES
			(lastIdProducto,miIdCategoria);
        -- insertamos la primera imagen de nuestro producto    
		INSERT INTO imagenes(path,productos_idProducto) VALUES
			(outPath,lastIdProducto);
    end if;
END $$
DELIMITER ;

-- fin nuevoProducto

/*
anadirProducto requiere (idUsuario,idProducto,emailDestino), 
Con este procedimiento, añadimos un producto existente a un cliente existente.
Si los pedidos existentes ya estan pagados o no hay, el procedimiento creara un pedido nuevo.
*/

DROP PROCEDURE IF EXISTS `anadirProducto`;
 
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `anadirProducto`
(IN outIdUsuario INT, outIdProducto INT, outEmail VARCHAR(45))
BEGIN
	DECLARE miIdPedido VARCHAR(255);
    
    SELECT pedidos.idPedido INTO miIdPedido FROM usuarios INNER JOIN pedidos ON usuarios.idUsuario = pedidos.usuarios_idUsuario
		LEFT JOIN pagados ON pedidos.idPedido = pagados.pedidos_idPedido 
		WHERE fechaPago IS NULL AND usuarios_idUsuario = outIdUsuario LIMIT 1;
    
    -- comprobamos si hay algun pedido sin pagar
    if miIdPedido is null then
        -- creamos pedido
        INSERT INTO pedidos(usuarios_idUsuario) VALUES
			(outIdUsuario);
        -- recogemos la id del pedido , que sera la ultima creada   
		SELECT idPedido into miIdPedido from pedidos  where usuarios_idUsuario=usuarios_idUsuario order by idPedido DESC LIMIT 1;
		
    end if;
    
    -- comprobamos si nos han puesto un email de direccion,sino dejaremos el del usuario por defecto
    if outEmail is null then
        -- añadimos producto con email por defecto
        INSERT INTO pedidos_has_productos VALUES
        (miIdPedido,outIdProducto,(select email from usuarios where idUsuario = outIdUsuario));
        ELSE
        -- añadimos producto con email de destino diferente   
		INSERT INTO pedidos_has_productos VALUES
        (miIdPedido,outIdProducto,outEmail);
    end if;
    
END $$
DELIMITER ;

-- fin anadirProducto
