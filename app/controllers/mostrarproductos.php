<?php

   namespace X\App\Controllers;

   use X\Sys\Controller;
   use X\Sys\Session;

   /**
   *  @author Alex Romero
   * Esta clase la que se encargada de mostrar los productos de nuestra web
   * Sireve tanto para mostrar todos, como para filtrar por categoria o por buscador
   */
   class MostrarProductos extends Controller{


   		public function __construct($params){
   			parent::__construct($params);
            $this->addData(array(
               'page'=>'MostrarProductos'));
   			$this->model=new \X\App\Models\mMostrarProductos();
   			$this->view =new \X\App\Views\vMostrarProductos($this->dataView,$this->dataTable);
      }

      /**
      * Este DocBlock documenta la función home()
      * Lo he hecho diferente a los otros home, para que de inicio aunque no tenga parametros llame a mostrar,
      * ya quemostrar tambien la lamaos directametne pasando parametros por URL y decidimos si usar buscada por nombre,
      * o por nombre o descripcion
      */
   		function home(){
        //La accion por defecto, llama a la funcion mostrar,para que haga la consulta en la DDBB y recogamos los datos necesarios
        //para mostar el contenido
        $this->mostrar();

   		}

      /**
      * Este DocBlock documenta la función mostrar()
      * funcion que recibe parametros tanto para buscar por categoria o descipcion, y despues de hacer
      * las comprobaciones llama a la vstale pasa los datos y la vista printalo que se le pasa.
      */
      function mostrar(){

        //comprobamos si pasamos parametros para su filtrage, dependiendo hacemos una cosa u otra
        if(isset($this->params['categoria'])) {
            $busqueda = $this->params['categoria'];
            $columna = 'categorias.nombre';
            //Mirar porque devuelve mal la Ñ aqui, volver a probar con UTF-8, etc...Desde PHP, DDBB y HTML.
            $this->addData(array(
               'categoria'=>$busqueda));

        } else if (isset($this->params['busqueda'])){
            //$busqueda = filter_input(INPUT_POST, "busqueda", FILTER_SANITIZE_STRING);

            $busqueda = $this->params['busqueda'];
            $columna = 'productos.descripcion';

        } else {
          //si no hay ni categoria ni busqueda, no se pasa nada y se muestran todos los porductos
            $busqueda = null;
            $columna = null;
        }

        //$busqueda = isset($this->params['categoria']) ? $this->params['categoria'] : null;

          $data=$this->model->getProductos($columna,$busqueda);

          $this->addData($data);
          //Añadimos a nuestra vista los datos devueltos por getProductos, para usarlos en el template
          $this->view->__construct($this->dataView,$this->dataTable);

          $this->view->show();
      }

      /**
      * Este DocBlock documenta la función rellenarCarrito()
      * Recoger datos para printar el carrito por jquery
      */
      function rellenarCarrito(){
          if(!empty(Session::get('idUsuario'))){

              $idUsuario = Session::get('idUsuario');
              $data=$this->model->rellenarCarrito($idUsuario);

              if($data){
                  $this->ajax($data);
              }else{
                  return null;
              }

          } else {
              return false;
          }
      }

      /**
      * Este DocBlock documenta la función vaciarCarrito()
      * Vacia el carrito por completo, solo necesita el idPedido
      */
      function vaciarCarrito(){

              $idPedido = filter_input(INPUT_POST, "idPedido", FILTER_SANITIZE_NUMBER_INT);

              $data=$this->model->vaciarCarrito($idPedido);

              return $data;
      }

      /**
      * Este DocBlock documenta la función borrarProductoCarrito()
      * Quita un unico elemento del pedido con solo pasarle el idPEdido y el IdProducto
      */
      function borrarProductoCarrito(){

              $idPedido = filter_input(INPUT_POST, "idPedido", FILTER_SANITIZE_NUMBER_INT);
              $idProducto = filter_input(INPUT_POST, "idProducto", FILTER_SANITIZE_NUMBER_INT);

              $data=$this->model->borrarProductoCarrito($idPedido,$idProducto);

              return $data;
      }

      /**
      * Este DocBlock documenta la función cambiarEmailEnvio()
      * Cambia el email de destinode  un unico elemento del pedido con solo pasarle el idPedido, IdProducto y email
      */
      function cambiarEmailEnvio(){

              $idPedido = filter_input(INPUT_POST, "idPedido", FILTER_SANITIZE_NUMBER_INT);
              $idProducto = filter_input(INPUT_POST, "idProducto", FILTER_SANITIZE_NUMBER_INT);
              $nuevoEmail = filter_input(INPUT_POST, "nuevoEmail", FILTER_SANITIZE_EMAIL);

              $data=$this->model->cambiarEmailEnvio($idPedido,$idProducto,$nuevoEmail);

              return $data;
      }



   }
