<?php

   namespace X\App\Controllers;

   use X\Sys\Controller;
   use X\Sys\Session;

   /**
   *  @author Alex Romero
   * Esta clase la que se encarga de mostrar el perfil del usuario
   * y la de la visualizacion de los pedidos a la vez que pagar el pedido pendiente
   */
   class MiCuenta extends Controller{


   		public function __construct($params){
   			parent::__construct($params);
            $this->addData(array(
               'page'=>'MiCuenta'));
   			$this->model=new \X\App\Models\mMiCuenta();
   			$this->view =new \X\App\Views\vMiCuenta($this->dataView,$this->dataTable);


                }


   		function home(){

        if(!empty(Session::get('idUsuario'))){

            $idUsuario = Session::get('idUsuario');

            //Aqui enviamos al template los datos de perfil del usuario si tiene
            $data=$this->model->getPerfil($idUsuario);
            $this->addData($data);

        }

        $this->view->__construct($this->dataView,$this->dataTable);
        $this->view->show();

   		}

      /**
      * Este DocBlock documenta la función getProvincias()
      * Recoge los datos para printar el provincias por jquery
      */
      function getProvincias(){

            $data=$this->model->getProvincias();

            if($data){
                  $this->ajax($data);
             }else{
                  return null;
            }
      }

      /**
      * Este DocBlock documenta la función getPoblaciones()
      * Recoge los datos para printar el poblaciones por jquery,
      * ya filtramos para mostrar solo las poblaciones de una provincia
      * en concreto
      */
      function getPoblaciones(){

            $idProvincia=filter_input(INPUT_POST,'$idProvincia',FILTER_SANITIZE_NUMBER_INT);

            $data=$this->model->getPoblaciones($idProvincia);

            if($data){
                  $this->ajax($data);
             }else{
                  return null;
            }
      }

      /**
      * Este DocBlock documenta la función editarPerfil()
      * Sireve para editar un usuario por completo, recive
      * los datos desde un formulario y los cambia en la DDBB
      */
      function editarPerfil(){

        if(!empty(Session::get('idUsuario'))){

            $idUsuario = Session::get('idUsuario');

            $nombre=filter_input(INPUT_POST,'nombre',FILTER_SANITIZE_STRING);
            $apellido1=filter_input(INPUT_POST,'apellido1',FILTER_SANITIZE_STRING);
            $apellido2=filter_input(INPUT_POST,'apellido2',FILTER_SANITIZE_STRING);
            $dni=filter_input(INPUT_POST,'dni',FILTER_SANITIZE_STRING);
            $direccion=filter_input(INPUT_POST,'direccion',FILTER_SANITIZE_STRING);
            $telefono=filter_input(INPUT_POST,'telefono',FILTER_SANITIZE_NUMBER_INT);
            $cargaPoblaciones=filter_input(INPUT_POST,'cargaPoblaciones',FILTER_SANITIZE_NUMBER_INT);

            $res = $this->model->editarPerfil($idUsuario,$nombre,$apellido1,$apellido2,$dni,$direccion,$telefono,$cargaPoblaciones);

            if ($res){
                $this->ajax(array('redir'=>BARRA.'micuenta','msg'=>'Perfil editado'));
            }else{
               $this->ajax(array('redir'=>'none','msg'=>'Fallo al editar perfil'));
            }

        }

      }

      /**
      * Este DocBlock documenta la función getPedidoPendiente()
      * Recoger pedido pendiente del usuario, mediante su idUsuario
      */
      function getPedidoPendiente(){
          if(!empty(Session::get('idUsuario'))){

              $idUsuario = Session::get('idUsuario');
              $data=$this->model->getPedidoPendiente($idUsuario);

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
      * Este DocBlock documenta la función getPedidosPagados()
      * Recoger pedidos pagados del usuario, mediante su idUsuario
      */
      function getPedidosPagados(){
          if(!empty(Session::get('idUsuario'))){

              $idUsuario = Session::get('idUsuario');
              $data=$this->model->getPedidosPagados($idUsuario);

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
      * Este DocBlock documenta la función pagarPedido()
      * Efectuamos el pago, mediante formulario
      */
      function pagarPedido(){
        $pedidoNumero=filter_input(INPUT_POST,'pedidoNumero',FILTER_SANITIZE_NUMBER_INT);
        $precioTotal=filter_input(INPUT_POST,'precioTotal',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        $pago=filter_input(INPUT_POST,'pago',FILTER_SANITIZE_NUMBER_INT);

        $data = $this->model->pagarPedido($pedidoNumero,$precioTotal,$pago);

        if($data){
          echo '<script type="text/javascript">
          alert("Pedido pagado sactisfactoriamente");
          window.location.href="'.BARRA.'micuenta";
          </script>';
          //header ("Location: ".BARRA."micuenta");
        } else {
          echo '<script type="text/javascript">
          alert("Error al pagar el pedido");
          window.location.href="'.BARRA.'micuenta";
          </script>';
          //header ("Location: ".BARRA."micuenta");
        }

      }


   }
