<?php

   namespace X\App\Controllers;

   use X\Sys\Controller;
   use X\Sys\Session;

   /**
   *  @author Alex Romero
   * Esta clase la que se encarga de la gestion de los productos de nuestra web
   */
   class GestionProductos extends Controller{

   		public function __construct($params){
   			parent::__construct($params);
            $this->addData(array(
               'page'=>'GestionProductos'));
   			$this->model=new \X\App\Models\mGestionProductos();
   			$this->view =new \X\App\Views\vGestionProductos($this->dataView,$this->dataTable);


                }


   		function home(){

                    //Cargamos los daos de todos los productos, para printarlos en la vista
                    $data=$this->model->getProductos();
                    $this->addData($data);
                    $this->view->__construct($this->dataView,$this->dataTable);
                    $this->view->show();

   		}

      /**
      * Este DocBlock documenta la función anadirProducto()
      * Esta funcion es para añadir un producto a un carrito.si no hay,
      * se crea uno automaticamente ya que asi lo decidi en un procedimiento
      * creado en la DDBB
      */
      function anadirProducto(){

          //Comprobamos si el usuario esta registrado para añadir un producto a su carrito
          if(!empty(Session::get('idUsuario'))){

          $idUsuario = Session::get('idUsuario');
          $idProducto = filter_input(INPUT_POST,'idProducto',FILTER_SANITIZE_NUMBER_INT);
  				$res=$this->model->anadirProducto($idUsuario,$idProducto);

          if($res){
             $this->ajax(array('msg'=>"bien"));
          }else{
             $this->ajax(array('msg'=>"Error al añadir el producto"));
          }

        } else {
            $this->ajax(array('msg'=>"Necesitas estar registrado para añadir productos al carrito"));
        }

      }

      /**
      * Este DocBlock documenta la función estado()
      * Activa o desactiva un producto con un simple click
      */
      function estado(){

            $data=filter_input(INPUT_POST,'$data',FILTER_SANITIZE_NUMBER_INT);
            $estado=filter_input(INPUT_POST,'$estado',FILTER_SANITIZE_NUMBER_INT);

            $res = $this->model->estado($data,$estado);
            if ($res){
                $this->ajax(array('redir'=>BARRA.'gestionproductos','msg'=>'Producto modificado'));
            }else{
               $this->ajax(array('redir'=>'none','msg'=>'Fallo al modificar el producto'));
            }
      }

      /**
      * Este DocBlock documenta la función getCategorias()
      * Recoger datos para printar el carrito por jquery
      */
      function getCategorias(){

            $data=$this->model->getCategorias();

            if($data){
                  $this->ajax($data);
             }else{
                  return null;
              }
      }

      /**
      * Este DocBlock documenta la función nuevoProducto()
      * Añadir producto nuevo a la DDBB, aqui comprobamos el tipo de archivo
      * el tamaño del mismo y tambien cambiamos el nombre de como se va a guardar
      * en nuestro servidor, esto lo he pensado asi puesto que si el nombre del archivo
      * que quieres subir ya existe o es demasiado largo, rato etc... tengas la opcion de
      * renombrarlo como quieras. Se cambia auto en el path y en la img al guardarla
      */
      function nuevoProducto() {
           //Recogemos el archivo enviado por el formulario
           $archivo = $_FILES['archivo']['name'];
           //Si el archivo contiene algo y es diferente de vacio
           if (isset($archivo) && $archivo != "") {
              //Obtenemos algunos datos necesarios sobre el archivo
              $tipo = $_FILES['archivo']['type'];
              $tamano = $_FILES['archivo']['size'];
              $temp = $_FILES['archivo']['tmp_name'];
              //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño max 250kb
             if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2500000))) {

               //mensaje de OK
               echo '<script type="text/javascript">
               alert("Error tamaño archivo o extension permitida");
               window.location.href="'.BARRA.'gestionproductos";
               </script>';

             }
             else {

                $imagen=filter_input(INPUT_POST,'imagen',FILTER_SANITIZE_STRING);
                $extension = explode("/", $tipo);
                $path = 'productos/'.$imagen.'.'.$extension[1]; //creamos el path completo dela img, que es el mismo que se usara en la DDBB

                $nombre=filter_input(INPUT_POST,'nombre',FILTER_SANITIZE_STRING);

                //comprobamos si ya existe esa imagen y producto en la DDBB
                $resPath=$this->model->comprobarPath($path);
                $resNombre=$this->model->comprobarNombre($nombre);

                //Se intenta subir al servidor, y si se sube se insertan los datos en la DDBB
                if(!$resPath && !$resNombre) {

                    if (move_uploaded_file($temp, $path)) {
                        //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                        chmod($path, 0777);

                        $descripcion=filter_input(INPUT_POST,'descripcion',FILTER_SANITIZE_STRING);
                        $precio=filter_input(INPUT_POST,'precio',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
                        $categoria=filter_input(INPUT_POST,'categoria',FILTER_SANITIZE_STRING);

                          //CALL nuevoProducto('bodas1','Ideal para invitar a tu boda a los familiares',1.26,'bodas','productos/imagen1.jpg');
                        $res=$this->model->nuevoProducto($nombre,$descripcion,$precio,$categoria,$path);

                        if($res){
                          //mensaje de OK
                          echo '<script type="text/javascript">
                          alert("Insertado Correctamente");
                          window.location.href="'.BARRA.'gestionproductos";
                          </script>';
                        } else {
                          //Mensaje de error por ya existir el nombre de ese producto
                          echo '<script type="text/javascript">
                          alert("Ya existe un producto con ese nombre");
                          window.location.href="'.BARRA.'gestionproductos";
                          </script>';
                        }

                    } else {
                       //Si no se ha podido subir la imagen, mostramos un mensaje de error
                       echo '<script type="text/javascript">
                       alert("Error al subir el archivo");
                       window.location.href="'.BARRA.'gestionproductos";
                       </script>';
                    }
                } else {

                  //Mensaje de error por ya existir la ruta de destino
                  echo '<script type="text/javascript">
                  alert("Ya existe imagen o producto con ese nombre");
                  window.location.href="'.BARRA.'gestionproductos";
                  </script>';

                }
              }
           }

     }

     /**
     * Este DocBlock documenta la función edit()
     * funcion que nos sirve para editar un producto
     */
     function edit(){

       /*id=92
       nombre=Movil
       descripcion=Subido%20desde%20movil
       precio=2.49
       categoria=amor
       path=productos%2FMovil.png
       activo=1
       categoriaAntigua=trabajo*/

       $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
       $nombre=filter_input(INPUT_POST,'nombre',FILTER_SANITIZE_STRING);
       $descripcion=filter_input(INPUT_POST,'descripcion',FILTER_SANITIZE_STRING);
       $precio=filter_input(INPUT_POST,'precio',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
       $categoria=filter_input(INPUT_POST,'categoria',FILTER_SANITIZE_STRING);
       $activo=filter_input(INPUT_POST,'activo',FILTER_SANITIZE_NUMBER_INT);



       $res = $this->model->edit($id,$nombre,$descripcion,$precio,$categoria,$activo);

       if ($res){
           $this->ajax(array('redir'=>BARRA.'gestionproductos','msg'=>'Producto editado'));
       }else{
          $this->ajax(array('redir'=>'none','msg'=>'Fallo al editar producto'));
       }
     }


   }
