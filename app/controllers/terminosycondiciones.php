<?php

   namespace X\App\Controllers;

   use X\Sys\Controller;


   class TerminosyCondiciones extends Controller{

      public function __construct($params){
        parent::__construct($params);
        $this->addData(array('page'=>'Términos y Condiciones'));
   			$this->model=new \X\App\Models\mTerminosyCondiciones();
   			$this->view =new \X\App\Views\vTerminosyCondiciones($this->dataView,$this->dataTable);
      }

   		function home(){
   		}
   }
