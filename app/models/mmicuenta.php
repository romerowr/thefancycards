<?php

	namespace X\App\Models;

	use \X\Sys\Model;

	class mMicuenta extends Model{
		public function __construct(){
			parent::__construct();

		}

		/**
		* Este DocBlock documenta la función getPerfil()
		* Recoge el perfil de un usuario por su IdUsuario
	  * @param  [int] $idUsuario
	  * @return [array|null]
	  */
		function getPerfil($idUsuario){

			 $sql="select perfiles.nombre as nombre, apellido1, apellido2, dni, direccion, telefono, poblaciones_idPoblaciones,
			  provincias_idProvincia, poblaciones.nombre as poblaNombre, provincias.nombre as proviNombre
			 from perfiles inner join poblaciones on perfiles.poblaciones_idPoblaciones = poblaciones.idPoblacion
			 inner join provincias on poblaciones.provincias_idProvincia = provincias.codigoProvincia
			 where usuarios_idUsuario = :idUsuario";
		   $this->query($sql);
			 $this->bind(":idUsuario", $idUsuario);
		   $res=$this->execute();

			 if($res){
		     $result=$this->resultSet();
			  } else {
					$result=null;
				}
		   return $result;
	  }

		/**
		* Este DocBlock documenta la función getProvincias()
		* Recoge los datos para printar el provincias por jquery
	  * @return [array|null]
	  */
		function getProvincias(){
		   $sql="SELECT * FROM provincias order by nombre asc";

		   $this->query($sql);
		   $res=$this->execute();
			 if($res){
		     $result=$this->resultSet();
			  } else {
					$result=null;
				}
		   return $result;
	  }

		/**
		* Este DocBlock documenta la función getPoblaciones()
		* Recoge los datos para printar el poblaciones por jquery,
		* ya filtramos para mostrar solo las poblaciones de una provincia
		* en concreto
	  * @param  [int] $idProvincia
	  * @return [array|null]
	  */
		function getPoblaciones($idProvincia){
		   $sql="SELECT idPoblacion, nombre FROM poblaciones where provincias_idProvincia=:idProvincia order by nombre asc";

		   $this->query($sql);
			 $this->bind(":idProvincia", $idProvincia);

		   $res=$this->execute();

			 if($res){
		     $result=$this->resultSet();
			  } else {
					$result=null;
				}
		   return $result;
	  }

		/**
		* Este DocBlock documenta la función editarPerfil()
		* Sireve para editar un usuario por completo, recive
		* los datos desde un formulario y los cambia en la DDBB
	  * @param  [int] $idUsuario
	  * @param  [string] $nombre
	  * @param  [string] $apellido1
	  * @param  [string] $apellido2
	  * @param  [string] $dni
	  * @param  [string] $direccion
	  * @param  [int] $telefono
	  * @param  [int] $cargaPoblaciones
	  * @return [boolean]
	  */
		function editarPerfil($idUsuario,$nombre,$apellido1,$apellido2,$dni,$direccion,$telefono,$cargaPoblaciones){

			//re-comprobamos si ya existe un producto con ese nombre
			$sql="SELECT * FROM perfiles WHERE usuarios_idUsuario=:idUsuario";
			$this->query($sql);
			$this->bind(":idUsuario", $idUsuario);
			$this->execute();
			$resultado = $this->rowCount();

			if ($resultado == 1) {
					//como ya tiene perfil, lo editamos
					$sql="UPDATE perfiles
							set nombre = :nombre,
							apellido1 = :apellido1,
							apellido2 = :apellido2,
							dni = :dni,
							direccion = :direccion,
							telefono = :telefono,
							poblaciones_idPoblaciones = :poblacion
							where usuarios_idUsuario = :idUsuario";

							$this->query($sql);

							$this->bind(":idUsuario", $idUsuario);
							$this->bind(":nombre", $nombre);
							$this->bind(":apellido1", $apellido1);
							$this->bind(":apellido2", $apellido2);
							$this->bind(":dni", $dni);
							$this->bind(":direccion", $direccion);
							$this->bind(":telefono", $telefono);
							$this->bind(":poblacion", $cargaPoblaciones);

							$resultado = $this->execute();

							if ($resultado > 0) {
									return TRUE;
							} else {
									return FALSE;
							}
			} else {
					//Sino no tiene, perfil le añadimos uno
					$sql="INSERT INTO perfiles (usuarios_idUsuario, nombre, apellido1, apellido2,
						dni, direccion, telefono,poblaciones_idPoblaciones)
						VALUES (:idUsuario, :nombre, :apellido1, :apellido2, :dni,
						:direccion, :telefono, :poblacion)";

					$this->query($sql);

					$this->bind(":idUsuario", $idUsuario);
					$this->bind(":nombre", $nombre);
					$this->bind(":apellido1", $apellido1);
					$this->bind(":apellido2", $apellido2);
					$this->bind(":dni", $dni);
					$this->bind(":direccion", $direccion);
					$this->bind(":telefono", $telefono);
					$this->bind(":poblacion", $cargaPoblaciones);

					$resultado = $this->execute();

					if ($resultado > 0) {
							return TRUE;
					} else {
							return FALSE;
					}

			}
		}

		/**
		* Este DocBlock documenta la función getPedidoPendiente()
		* Recoger pedido pendiente del usuario, mediante su idUsuario
	  * @param  [int] $idUsuario
	  * @return [array|null]
	  */
		function getPedidoPendiente($idUsuario){

			$sql="select idProducto as carritoIdProducto, productos.nombre as carritoNombreProducto, precio as carritoNombrePrecio,
			 idPedido, emailDestino, fechaPago from usuarios
						inner join pedidos on usuarios.idUsuario = pedidos.usuarios_idUsuario
						inner join pedidos_has_productos on pedidos.idPedido = pedidos_has_productos.pedidos_idPedido
						inner join productos on pedidos_has_productos.productos_idProducto = productos.idProducto
						left join pagados on pedidos.idPedido = pagados.pedidos_idPedido
						where fechaPago is null AND usuarios_idUsuario = :idUsuario" ;

			$this->query($sql);
			$this->bind(":idUsuario", $idUsuario);
			$res=$this->execute();

			if($res){
				$result=$this->resultset();
			} else {
				$result=null;
			}
			return $result;

		}

		/**
		* Este DocBlock documenta la función getPedidosPagados()
		* Recoger pedidos pagados del usuario, mediante su idUsuario
	  * @param  [int] $idUsuario
	  * @return [array|null
	  */
		function getPedidosPagados($idUsuario){

			$sql="select idProducto as carritoIdProducto, productos.nombre as carritoNombreProducto, precio as carritoNombrePrecio,
			 pedidos.idPedido AS idPedido, emailDestino, DATE_FORMAT(fechaPago,'%d-%m-%Y') as fechaPago, precioFinal, metodosDePago.nombre AS pagoNombre2 from usuarios
						inner join pedidos on usuarios.idUsuario = pedidos.usuarios_idUsuario
						inner join pedidos_has_productos on pedidos.idPedido = pedidos_has_productos.pedidos_idPedido
						inner join productos on pedidos_has_productos.productos_idProducto = productos.idProducto
						left join pagados on pedidos.idPedido = pagados.pedidos_idPedido
						inner join metodosDePago on pagados.metodosDePago_idMetodosDePago = metodosDePago.idMetodosDePago
						where fechaPago is not null AND usuarios_idUsuario = :idUsuario
						order by idPedido desc" ;

			$this->query($sql);
			$this->bind(":idUsuario", $idUsuario);
			$res=$this->execute();

			if($res){
				$result=$this->resultset();
			} else {
				$result=null;
			}
			return $result;

		}

		/**
		* Este DocBlock documenta la función pagarPedido()
		* Efectuamos el pago, mediante formulario
	  * @param  [int] $pedidoNumero [id del pedido]
	  * @param  [float] $precioTotal  
	  * @param  [int] $pago         [id del metod de pago]
	  * @return [boolean]               [description]
	  */
		function pagarPedido($pedidoNumero,$precioTotal,$pago){

			$sql="insert into pagados(pedidos_idPedido,descuento,precioFinal,metodosDePago_idMetodosDePago)
			 values (:pedidoNumero,0,:precioTotal,:pago)";

			$this->query($sql);
			$this->bind(":pedidoNumero", $pedidoNumero);
			$this->bind(":precioTotal", $precioTotal);
			$this->bind(":pago", $pago);
			$res=$this->execute();

			if($res == 1){
				$result = true;
			} else {
				$result = false;
			}
			return $result;

		}









	}
