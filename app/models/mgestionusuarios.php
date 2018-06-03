<?php

	namespace X\App\Models;

	use \X\Sys\Model;

	class mGestionUsuarios extends Model{
		public function __construct(){
			parent::__construct();

		}

		/**
		* Este DocBlock documenta la función valusername()
		* Comprobacion si existe ya el usuario en la DDBB
	  * @param  [string] $em [Nombre del usuario a buscar]
	  * @return [boolean]
	  */
    function valusername($em){

        $this->query("SELECT * FROM usuarios WHERE nombreUsuario=:username");
        $this->bind(":username",$em);
        $this->execute();
        $res=$this->rowCount();

        if($res==1){
              return true;
        }else{
              return false;
        }
    }

		/**
		* Este DocBlock documenta la función valemail()
		* Comprobacion si existe ya el email en la DDBB
	  * @param  [string] $em [Email a comprobar]
	  * @return [boolean]
	  */
    function valemail($em){

        $this->query("SELECT * FROM usuarios WHERE email=:email");
        $this->bind(":email",$em);
        $this->execute();
        $res=$this->rowCount();
        if($res==1){
              return true;
        }else{
              return false;
        }
    }

		/**
		* Este DocBlock documenta la función reg()
		* Registro del usuario ESTANDAR en la DDBB, ROL por defecto USUARIO
		* Ademas de que ya iniciamos las variables de sesion que usaremos en nuestra web
	  * @param  [string] $username
	  * @param  [string] $email
	  * @param  [string] $pass
	  * @return [array|false]
	  */
		function reg($username,$email,$pass){
			//Llamamos al procedimiento creado previamente en la DDBB
			//usuarios(nombreUsuario,password,email,roles_idRol) rol 3, es usuario normal
				$sql="CALL nuevoUsuario(:username, :pass, :email, 3)";
				$this->query($sql);
				$this->bind(":username", $username);
				$this->bind(":pass", $pass);
				$this->bind(":email", $email);
				$this->execute();
				//Y ahora comprobamos si se a creado correctamente
				$sql="SELECT * FROM usuarios WHERE nombreUsuario=:user and password=:pass";
				$this->query($sql);
				$this->bind(":user", $username);
				$this->bind(":pass", $pass);
				$this->execute();
				$resultado = $this->rowCount();
				//Si se crea correctamente, enviamos los datos de nuestro nuevo usuario
				if ($resultado == 1) {
						return $this->single();
				} else {
						return FALSE;
				}
		}

		/**
		* Este DocBlock documenta la función log()
		* Comprobacion para logeo en la DDBB
		* Si es correcto iniciamos las variables de sesion que usaremos en nuestra web
	  * @param  [string] $user
	  * @param  [string] $pass
	  * @return [array|false]
	  */
		function log($user,$pass){
				$sql="SELECT * FROM usuarios WHERE nombreUsuario=:user and password=:pass and activo = 1";
				$this->query($sql);
				$this->bind(":user", $user);
				$this->bind(":pass", $pass);
				$this->execute();
				$resultado = $this->rowCount();
				if ($resultado == 1) {
						return $this->single();
				} else {
						return FALSE;
				}
		}

		/**
		* Este DocBlock documenta la función getUsuarios()
		* Recogemos los datos de todos nuestros usuarios de la DDBB
	  * @return [array|null]
	  */
		function getUsuarios(){
		   $sql="SELECT * FROM usuarios";
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
		* Este DocBlock documenta la función adminReg()
		* Registro del usuario como ADMINISTRACION en la DDBB
		* A diferencia del registro normal, aqui podemos poner el ROL
	  * @param  [int] $rol
	  * @param  [string] $username
	  * @param  [string] $email
	  * @param  [string] $pass
	  * @return [boolean]
	  */
		function adminReg($rol,$username,$email,$pass){
				//Llamamos al procedimiento creado previamente en la DDBB
				$sql="CALL nuevoUsuario(:username, :pass, :email, :rol)";
				$this->query($sql);
				$this->bind(":username", $username);
				$this->bind(":pass", $pass);
				$this->bind(":email", $email);
				$this->bind(":rol", $rol);
				$resultado = $this->execute();

				/*
				//Y ahora comprobamos si se a creado correctamente
				$sql="SELECT * FROM usuarios WHERE nombreUsuario=:user and password=:pass";
				$this->query($sql);
				$this->bind(":user", $username);
				$this->bind(":pass", $pass);
				$this->execute();
				$resultado = $this->rowCount();
				*/
			
				//Si se crea correctamente, enviamos true, para la recarga de la pagina
				if ($resultado == 1) {
						return TRUE;
				} else {
						return FALSE;
				}
		}

		/**
		* Este DocBlock documenta la función del()
		* Borrar usuario por su ID
	  * @param  [int] $user [id del usuario a borrar]
	  * @return [boolean]
	  */
		function del($user){
				$sql="DELETE FROM usuarios WHERE idUsuario=:user AND roles_idRol != 1";
				$this->query($sql);
				$this->bind(":user", $user);
				$this->execute();

				$sql="SELECT * FROM usuarios WHERE idUsuario=:user";
				$this->query($sql);
				$this->bind(":user", $user);
				$this->execute();
				$resultado = $this->rowCount();

				if ($resultado == 0) {
						return TRUE;
				} else {
						return FALSE;
				}
		}

		/**
		* Este DocBlock documenta la función edit()
		* esta funcion es para editar usuarios desde la gestion de usuarios
	  * @param  [int] $id       [id del usuario]
	  * @param  [string] $username
	  * @param  [string] $pass
	  * @param  [string] $email
	  * @param  [int] $rol
	  * @param  [int] $activo
	  * @return [boolean]
	  */
		function edit($id,$username,$pass,$email,$rol,$activo){

			//sino cambiamos el pass, dejams el que ya habia
			$cambioPass = ($pass != null) ? "password = :pass," : " ";

			$sql="UPDATE usuarios
					set nombreUsuario = :username,"
					.$cambioPass.
					"email = :email,
					activo = :activo,
					roles_idRol = :rol
					where idUsuario = :id AND roles_idRol != 1";

				$this->query($sql);
				$this->bind(":id", $id);
				$this->bind(":username", $username);

				if($pass != null){
					$this->bind(":pass", $pass);
				}

				$this->bind(":email", $email);
				$this->bind(":rol", $rol);
				$this->bind(":activo", $activo);
				$resultado = $this->execute();

				if ($resultado > 0) {
						return TRUE;
				} else {
						return FALSE;
				}
		}


	}
