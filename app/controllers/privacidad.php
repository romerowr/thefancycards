<?php

   namespace X\App\Controllers;

   use X\Sys\Controller;

   /**
   *  @author Alex Romero
   * Esta clase encargada de mostrar la privacidad
   */
   class Privacidad extends Controller{

      public function __construct($params){
        parent::__construct($params);
        $this->addData(array('page'=>'Privacidad'));
   			$this->model=new \X\App\Models\mPrivacidad();
   			$this->view =new \X\App\Views\vPrivacidad($this->dataView,$this->dataTable);
      }

   		function home(){ 
   		}
   }
