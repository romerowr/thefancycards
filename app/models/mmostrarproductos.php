<?php

	namespace X\App\Models;

	use \X\Sys\Model;

	class mMostrarProductos extends Model{
		public function __construct(){
			parent::__construct();

		}

		/**
		* Este DocBlock documenta la función getProductos()
		* Esta funcion no ssirve para recoger todos los productos con el filtro seleccionado
		* $busqueda, puede ser null(y cargamos todo),
		* o un criterio del where(categoria o descripcion), y $columna, el campo por el cual filtrar
		* Tambien solo mostramos los productos que esten activos
	  * @param  [string|null] $columna
	  * @param  [string|null] $busqueda [string con condiciones de busqueda]
	  * @return [array|null]
	  */
		public function getProductos($columna,$busqueda){ // $busqueda, puede ser null(y cargamos todo),
		// o un criterio del where(categoria o descripcion), y $columna, el campo por el cual filtrar
		//Tambien solo mostramos los productos que esten activos

			if($columna === null || $busqueda === null){
				$where = "";
			} else if ($columna == 'productos.descripcion'){

				//EL navegador noes envia los espacios como %20, asi que los cambio a comillas
				$busqueda = str_replace("%20", ",", $busqueda);
				//var_dump($busqueda);
				//die;

				//Despues cuarteo la busqueda por COMAS y espacios, aunque no haga falta porque no llegan espacios desde URL
				$trozos = preg_split("/[\s,]+/", $busqueda);
				$busquedaCompleta = " REGEXP '";

				//Hago con el bucle la busqueda por REGEXP, ya que el LIKE se me quedaba corto pa mi busqueda
				for($i = 0; sizeof($trozos) > $i ; $i++){
					$busquedaCompleta = $busquedaCompleta.$trozos[$i]."|";
				}

				//Quitamos el iltimo | que nos sobra
				$busquedaCompleta = trim($busquedaCompleta, '|');
				//var_dump(sizeof($trozos),$busquedaCompleta);
				//die;

				//Y añadimos el trozo de where que tiene toda la busqueda
				$where = " AND (".$columna.$busquedaCompleta."' OR categorias.nombre ".$busquedaCompleta."' )";
				//var_dump($where);
				//die;
				//Dejo el antiguo where de ejemplo, que era poco potente para lo que quera hacer
				//$where = " AND (".$columna." LIKE '%".$busqueda."%' OR categorias.nombre LIKE '%".$busqueda."%' )";
			} else {
				$where = " AND (".$columna." LIKE '%".$busqueda."%')";
			}
			//var_dump($where);
			//die;

			//Este select ya esta prearao con un where de qu elos productos si o si tienen que estar activos,
			// y le añadimos el where que falta segun nuestras necesidades

			/*
			//AL revisar el codigo me acuerdo que cree una vista de vistaProductos y modifico el codigo
			$sql= "select idProducto, nombreProducto as producto, descripcion, precio, nombreCategoria as categoria, path
			from vistaProductos where activo = 1 ".$where;
			*/

			$sql="select idProducto, productos.nombre as producto, descripcion, precio, categorias.nombre as categoria, path from productos
					inner join imagenes on productos.idProducto = imagenes.productos_idProducto
					inner join productos_has_categorias on productos.idProducto = productos_has_categorias.productos_idProducto
					inner join categorias on productos_has_categorias.categorias_idCategoria = categorias.idCategoria where activo = 1 ".$where;


			$this->query($sql);

			$res=$this->execute();

			if($res){
				$result=$this->resultset();

			} else {
				$result=null;
			}
			return $result;
		}

		/**
		* Este DocBlock documenta la función rellenarCarrito()
		* Recoger datos para printar el carrito por jquery
	  * @param  [int] $idUsuario
	  * @return [array|null]            	  */
		function rellenarCarrito($idUsuario){

			$sql="select idProducto as carritoIdProducto, productos.nombre as carritoNombreProducto, precio as carritoNombrePrecio,
			 			idPedido, emailDestino from usuarios
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
		* Este DocBlock documenta la función vaciarCarrito()
		* Vacia el carrito por completo, solo necesita el idPedido
	  * @param  [int] $idPedido
	  * @return [null]
	  */
		function vaciarCarrito($idPedido){

			$sql="delete from pedidos where idPedido = :idPedido";

			$this->query($sql);
			$this->bind(":idPedido", $idPedido);
			$res=$this->execute();

			return null;
		}

		/**
		* Este DocBlock documenta la función borrarProductoCarrito()
		* Quita un unico elemento del pedido con solo pasarle el idPEdido y el IdProducto
	  * @param  [int] $idPedido
	  * @param  [int] $idProducto
	  * @return [null]
	  */
		function borrarProductoCarrito($idPedido,$idProducto){

			$sql="delete from pedidos_has_productos where pedidos_idPedido = :idPedido
			AND productos_idProducto = :idProducto";

			$this->query($sql);
			$this->bind(":idPedido", $idPedido);
			$this->bind(":idProducto", $idProducto);
			$res=$this->execute();

			return null;
		}

		/**
		* Este DocBlock documenta la función cambiarEmailEnvio()
		* Cambia el email de destinode  un unico elemento del pedido con solo pasarle el idPedido, IdProducto y email int
	  * @param  [int] $idPedido   
	  * @param  [int] $idProducto 
	  * @param  [string] $nuevoEmail 
	  * @return [null]             
	  */
		function cambiarEmailEnvio($idPedido,$idProducto,$nuevoEmail){

			$sql="UPDATE pedidos_has_productos set emailDestino = :nuevoEmail where pedidos_idPedido = :idPedido
			AND productos_idProducto = :idProducto";

			$this->query($sql);
			$this->bind(":idPedido", $idPedido);
			$this->bind(":idProducto", $idProducto);
			$this->bind(":nuevoEmail", $nuevoEmail);
			$res=$this->execute();

			return null;
		}



		//FIN DEL MODELO
	}
