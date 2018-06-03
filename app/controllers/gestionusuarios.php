<?php

   namespace X\App\Controllers;

   use X\Sys\Controller;
   use X\Sys\Session;

   /**
   *  @author Alex Romero
   * Esta clase la que se encarga de la gestion de los usuarios de nuestra web
   */
   class GestionUsuarios extends Controller{


   		public function __construct($params){
        parent::__construct($params);
        $this->addData(array('page'=>'GestionUsuarios'));
   			$this->model=new \X\App\Models\mGestionUsuarios();
   			$this->view =new \X\App\Views\vGestionUsuarios($this->dataView,$this->dataTable);
      }

      function home(){

          //Cargamos los datos de todos los usuarios, para printarlos en la vista
          $data=$this->model->getUsuarios();
          $this->addData($data);
          $this->view->__construct($this->dataView,$this->dataTable);
          $this->view->show();

   		}

      /**
      * Este DocBlock documenta la función valusername()
      * Comprobacion si existe ya el usuario en la DDBB
      */
      function valusername(){

        $username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
				$res=$this->model->valusername($username);

        if($res){
           $this->ajax(array('msg'=>"Nombre de usuario en uso",
                              'class'=>"cd-error-message"));
        }else{
          //Al final decidimos que la salida cuando algo es correcto, es simplemente que
          //no salga ningun mensaje
           $this->ajax(array('msg'=>"")); //Nombre de usuario disponible
                          //,'class'=>"cd-correct-message"));
        }
      }

      /**
      * Este DocBlock documenta la función valemail()
      * Comprobacion si existe ya el email en la DDBB
      */
      function valemail(){

          $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
          $res=$this->model->valemail($email);

          if($res){
             $this->ajax(array('msg'=>"Email en uso",
                                'class'=>"cd-error-message"));
          }else{
            //Al final decidimos que la salida cuando algo es correcto, es simplemente que
            //no salga ningun mensaje
             $this->ajax(array('msg'=>""));
          }
        }

        /**
        * Este DocBlock documenta la función reg()
        * Registro del usuario ESTANDAR en la DDBB, ROL por defecto USUARIO
        * Ademas de que ya iniciamos las variables de sesion que usaremos en nuestra web
        */
        function reg(){

              $username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
              $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
              $pass=filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
              //Encripatamos el password
              $pass = md5($pass);
              $res=$this->model->reg($username,$email,$pass);

              //Si la creacion de usuario es correcta, recogeremos los datos para
              //generar nuestros datos de sesion
              if($res!=false){
									Session::set('nombreUsuario',$res['nombreUsuario']);
									Session::set('rol',$res['roles_idRol']);
									Session::set('idUsuario',$res['idUsuario']);

                  $this->ajax(array('redir'=>BARRA.'home'));

               } else {
                  $this->ajax(array('redir'=>BARRA.'error'));
               }

       }

       /**
       * Este DocBlock documenta la función log()
       * Comprobacion para logeo en la DDBB
       * Si es correcto iniciamos las variables de sesion que usaremos en nuestra web
       */
       function log(){
          if (!empty($_POST['username']) && !empty($_POST['password'])) {
              $user = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
              $pass = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
              $pass = md5($pass);
              $res = $this->model->log($user,$pass);
              if ($res!=false){
                //Recogida de variables de session
                  Session::set('nombreUsuario',$res['nombreUsuario']);
                  Session::set('rol',$res['roles_idRol']);
                  Session::set('idUsuario',$res['idUsuario']);

									$this->ajax(array('redir'=>'inSitu'));
              }else{
                  $this->ajax(array('redir'=>BARRA.'error',
                                   'msg'=>'Error de acceso!',
                                   'class'=>"cd-error-message"));
              }
          }
       }

       /**
       * Este DocBlock documenta la función logout()
       * Deslogeamos y destruimos la sesion
       */
       function logout(){
         Session::destroy();
         $this->ajax(array('redir'=>BARRA));
       }

       /**
       * Este DocBlock documenta la función adminReg()
       * Registro del usuario como ADMINISTRACION en la DDBB
       * A diferencia del registro normal, aqui podemos poner el ROL
       */
       function adminReg(){

             $rol=filter_input(INPUT_POST,'rol',FILTER_SANITIZE_NUMBER_INT);
             $username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
             $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
             $pass=filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
             $pass = md5($pass);
             $res=$this->model->adminReg($rol,$username,$email,$pass);

             //Si es correcto recargamos la pagina para que se vea añadido
             if($res!=false){
                 $this->ajax(array('redir'=>BARRA.'gestionusuarios'));
              //Si falla devolvemos a error
              } else {
                 $this->ajax(array('redir'=>BARRA.'error'));
              }

      }

      /**
      * Este DocBlock documenta la función edit()
      * esta funcion es para editar usuarios desde la gestion de usuarios
      */
      function edit(){
        $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
        $username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
        $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
        $rol=filter_input(INPUT_POST,'rol',FILTER_SANITIZE_NUMBER_INT);
        $activo=filter_input(INPUT_POST,'activo',FILTER_SANITIZE_NUMBER_INT);

        //si hay password, lo encriptamos
        if(!empty($_POST['password'])) {
          $pass=filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
          $pass = md5($pass);
        } else {
          $pass = null;
        }


        $res = $this->model->edit($id,$username,$pass,$email,$rol,$activo);

        if ($res){
            $this->ajax(array('redir'=>BARRA.'gestionusuarios','msg'=>'Usuario editado'));
        }else{
           $this->ajax(array('redir'=>'none','msg'=>'Fallo al editar usuario'));
        }
      }

      /**
      * Este DocBlock documenta la función del()
      * Borrar usuario por su ID
      */
      function del(){

            $data=filter_input(INPUT_POST,'$data',FILTER_SANITIZE_NUMBER_INT);

            $res = $this->model->del($data);
            if ($res){
                $this->ajax(array('redir'=>BARRA.'gestionusuarios','msg'=>'Usuario borrardo'));
            }else{
               $this->ajax(array('redir'=>'none','msg'=>'Fallo al borrar usuario, quizas ya tenga pedidos o sea administrador'));
            }
      }

   }
