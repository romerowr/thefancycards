<?php

   namespace X\App\Controllers;

   use X\Sys\Controller;

   /**
   *  @author Alex Romero
   * Esta clase la tenemos para enviarnos cuando sucede un error de controlador inexistente,
   * o reenviamos nosotros por alguna necesidad
   */
   class Error extends Controller{

      public function __construct($params){
        parent::__construct($params);
        $this->addData(array('page'=>'Error'));
   			$this->model=new \X\App\Models\mError();
   			$this->view =new \X\App\Views\vError($this->dataView,$this->dataTable);
      }

   		function home(){
   		}
   }
