<?php

	namespace X\App\Models;

	use \X\Sys\Model;

	class mGestionProductos extends Model{
		public function __construct(){
			parent::__construct();

		}

		/**
		* Este DocBlock documenta la función getProductos()
		* Recoger datos de los productos
		* @return array|null
		*/
		function getProductos(){

			//AL revisar el codigo me acuerdo que cree una vista de vistaProductos y modifico el codigo
		//	$sql= "select idProducto, nombreProducto, descripcion, precio, nombreCategoria, path, activo from vistaProductos";

			$sql="select idProducto, productos.nombre as producto, descripcion, precio, categorias.nombre as categoria, path, activo from productos
 					inner join imagenes on productos.idProducto = imagenes.productos_idProducto
 					inner join productos_has_categorias on productos.idProducto = productos_has_categorias.productos_idProducto
 					inner join categorias on productos_has_categorias.categorias_idCategoria = categorias.idCategoria
					order by idProducto";

		   $this->query($sql);
		   $res=$this->execute();
			 if($res){
		     $result=$this->resultSet(); //single()
			  } else {
					$result=null;
				}
		   return $result;
	  }

		/**
		* Este DocBlock documenta la función getCategorias()
		* Recoger datos para printar el carrito por jquery
		* @return array|null
		*/
		function getCategorias(){
		   $sql="SELECT idCategoria, nombre as nombreCategoria FROM categorias order by nombre";

		   $this->query($sql);
		   $res=$this->execute();
			 if($res){
		     $result=$this->resultSet(); //single()
			  } else {
					$result=null;
				}
		   return $result;
	  }

		/**
		* Este DocBlock documenta la función anadirProducto()
		* Esta funcion es para añadir un producto a un carrito.si no hay,
		* se crea uno automaticamente ya que asi lo decidi en un procedimiento
		* creado en la DDBB
	  * @param  [int] $idUsuario
	  * @param  [int] $idProducto
	  * @return boolean
	  */
		function anadirProducto($idUsuario,$idProducto){
				// CALL anadirProducto($idUsuario, $idProducto, email);
				//por defecto añadimos el del usuario a al pasarle null
				$sql="CALL anadirProducto(:idUsuario, :idProducto, null)";
				$this->query($sql);
				$this->bind(":idUsuario", $idUsuario);
				$this->bind(":idProducto", $idProducto);
				$res = $this->execute();

				if($res){
 		     $result=true;
 			  } else {
 					$result=false;
 				}
 		   return $result;
		}

		/**
		 * Este DocBlock documenta la función estado()
		 * Que nos sirve para cambiar el estado de nuestro producto
		 * @param  [string] $data   [Id  del producto a modificar]
		 * @param  [int] $estado [Activar desactivar producto]
		 * @return [boolean]
		 */
		function estado($data,$estado){

				if($estado == 1){
					$estado = 0;
				} else {
					$estado = 1;
				}

				$sql="UPDATE productos set activo = :estado where idProducto = :data";
				$this->query($sql);
				$this->bind(":data", $data);
				$this->bind(":estado", $estado);
				$res = $this->execute();

				if($res){
 		     $result=true;
 			  } else {
 					$result=false;
 				}
 		   return $result;
		}

		/**
		* Este DocBlock documenta la función nuevoProducto()
		* Añadir producto nuevo a la DDBB, aqui comprobamos el tipo de archivo
		* el tamaño del mismo y tambien cambiamos el nombre de como se va a guardar
		* en nuestro servidor, esto lo he pensado asi puesto que si el nombre del archivo
		* que quieres subir ya existe o es demasiado largo, rato etc... tengas la opcion de
		* renombrarlo como quieras. Se cambia auto en el path y en la img al guardarla
 	 	* @param  [string] $nombre
	  * @param  [string] $descripcion
	  * @param  [float] $precio
	  * @param  [string] $categoria
	  * @param  [string] $path
  	* @return [bollean]
	  */
		function nuevoProducto($nombre,$descripcion,$precio,$categoria,$path){

			//re-comprobamos si ya existe un producto con ese nombre
			$sql="SELECT * FROM productos WHERE nombre=:nombre";
			$this->query($sql);
			$this->bind(":nombre", $nombre);
			$this->execute();
			$resultado = $this->rowCount();

			if ($resultado == 1) {
					return FALSE;
			} else {

				//re-comprobamos si existe ya una imagen con ese path
					$sql="SELECT * FROM imagenes WHERE path=:path";
					$this->query($sql);
					$this->bind(":path", $path);
					$this->execute();
					$resultado = $this->rowCount();

					if ($resultado == 1) {
							return FALSE;
					} else {

					$sql="CALL nuevoProducto(:nombre,:descripcion,:precio,:categoria,:path)";
					$this->query($sql);
					$this->bind(":nombre", $nombre);
					$this->bind(":descripcion", $descripcion);
					$this->bind(":precio", $precio);
					$this->bind(":categoria", $categoria);
					$this->bind(":path", $path);
					$this->execute();

					return TRUE;

					}

			}
		}

		/**
		* Este DocBlock documenta la función comprobarPath()
		* Comprobamos si ya existe una imagen con esa ruta
	  * @param  [string] $path
	  * @return [boolean]
	  */
		function comprobarPath($path){

			$sql="SELECT * FROM imagenes WHERE path=:path";
			$this->query($sql);
			$this->bind(":path", $path);
			$this->execute();
			$resultado = $this->rowCount();

			if ($resultado == 1) {
					return TRUE;
			} else {
					return FALSE;
			}
		}

		/**
		* Este DocBlock documenta la función comprobarNombre()
		* Comprobamos si ya existe un producto con esa ruta
	  * @param  [string] $nombre
	  * @return [boolean]
	  */
		function comprobarNombre($nombre){

			$sql="SELECT * FROM productos WHERE nombre=:nombre";
			$this->query($sql);
			$this->bind(":nombre", $nombre);
			$this->execute();
			$resultado = $this->rowCount();

			if ($resultado == 1) {
					return TRUE;
			} else {
					return FALSE;
			}
		}

		/**
		* Este DocBlock documenta la función edit()
		* funcion que nos sirve para editar un producto
	  * @param  [int] $id
	  * @param  [string] $nombre
	  * @param  [string] $descripcion
	  * @param  [float] $precio
	  * @param  [string] $categoria
	  * @param  [int] $activo
	  * @return [boolean]
	  */
		function edit($id,$nombre,$descripcion,$precio,$categoria,$activo){

				/*$sql= "update vistaProductos set
				nombreProducto = :nombre,
				descripcion = :descripcion,
				precio = :precio,
				activo = :activo
				where idProducto = :id";*/

				$sql = "UPDATE productos set idProducto = :id, nombre = :nombre, descripcion = :descripcion,
				precio = :precio,
				activo = :activo
				where idProducto = :id";

				$this->query($sql);
				$this->bind(":id", $id);
				$this->bind(":nombre", $nombre);
				$this->bind(":descripcion", $descripcion);
				$this->bind(":precio", $precio);
				$this->bind(":activo", $activo);
				$res1 = $this->execute();

				$sql= "update productos_has_categorias as phc
				inner join productos as p on p.idProducto = phc.productos_idProducto
				set phc.categorias_idCategoria = (select idCategoria from categorias where nombre = :categoria)
				where p.idProducto = :id";

				$this->query($sql);
				$this->bind(":id", $id);
				$this->bind(":categoria", $categoria);
				$res2 = $this->execute();

				if ($res1 > 0 && $res2 > 0) {
						return TRUE;
				} else {
						return FALSE;
				}
		}



	}
