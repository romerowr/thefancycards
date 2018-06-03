/*
CREATE TABLE IF NOT EXISTS usuarios (
  idUsuario INT(5) NOT NULL AUTO_INCREMENT,
  nombreUsuario VARCHAR(12) NOT NULL,
  password VARCHAR(45) NOT NULL,
  email VARCHAR(45) NOT NULL,
  activo BOOLEAN DEFAULT TRUE NOT NULL,
  roles_idRol INT(2) NOT NULL,
  */
/*INSERT INTO usuarios(nombreUsuario,password,email,roles_idRol) VALUES
 ('toni','password','toni@email.com',1);*/
 
# CALL nuevoUsuario('alex','passworddd','alex@email.es',1);
 
SELECT * FROM categorias;
 -- nuevoProducto requiere (nombre,descripcion,precio  1 categoria y una imagen)
CALL nuevoProducto('bodas1','Ideal para invitar a tu boda a los familiares',1.26,'bodas','/ruta/imagen1.jpg');
CALL nuevoProducto('bodas2','Ideal para invitar a tu boda a los amigos',1.48,'bodas','/ruta/imagen2.jpg');
CALL nuevoProducto('amor1','Ideal para sorprender a tu pareja',1.26,'amor','/ruta/imagen3.jpg');
CALL nuevoProducto('amor2','Ideal para sorprender a tu pareja',2.26,'amor','/ruta/imagen3.jpg');

select * from productos inner join imagenes on productos.idProducto = imagenes.productos_idProducto 
inner join productos_has_categorias on productos.idProducto = productos_has_categorias.productos_idProducto
inner join categorias on productos_has_categorias.categorias_idCategoria = categorias.idCategoria;

insert into pedidos (usuarios_idUsuario) values (1);
insert into pagados (pedidos_idPedido,descuento,precioFinal,metodosDePago_idMetodosDePago) values
	(1,2,3233,1);

select pedidos.idPedido from usuarios inner join pedidos on usuarios.idUsuario = pedidos.usuarios_idUsuario
left join pagados on pedidos.idPedido = pagados.pedidos_idPedido 
where fechaPago is null AND usuarios_idUsuario = 1 ;

CALL anadirProducto(2,1,'toni@edede.ed');
CALL anadirProducto(2,2,null);
CALL anadirProducto(2,3,'toni@edede.ed');
CALL anadirProducto(2,4,'toni@edede.ed');

delete from pedidos where idPedido = 7;

delete from pedidos_has_productos where pedidos_idPedido = 6;

select pedidos.idPedido,productos.nombre, pedidos_has_productos.emailDestino from usuarios inner join pedidos on usuarios.idUsuario = pedidos.usuarios_idUsuario
inner join pedidos_has_productos on pedidos.idPedido = pedidos_has_productos.pedidos_idPedido
inner join productos on pedidos_has_productos.productos_idProducto = productos.idProducto;


select pedidos_idPedido from pedidos left join pagados on pedidos.idPedido = pagados.pedidos_idPedido 
where pedidos_idPedido = 2;



