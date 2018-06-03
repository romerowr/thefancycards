<?php

   namespace X\App\Controllers;

   use X\Sys\Controller;


   class SobreNosotros extends Controller{

      public function __construct($params){
        parent::__construct($params);
        $this->addData(array('page'=>'Sobre Nosotros'));
   			$this->model=new \X\App\Models\mSobreNosotros();
   			$this->view =new \X\App\Views\vSobreNosotros($this->dataView,$this->dataTable);
      }

   		function home(){ 
   		}
   }
