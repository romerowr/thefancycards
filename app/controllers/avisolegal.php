<?php

   namespace X\App\Controllers;

   use X\Sys\Controller;

   /**
   *  @author Alex Romero
   * Esta clase encargada de mostrar el aviso legal
   */
   class AvisoLegal extends Controller{
      public function __construct($params){
        parent::__construct($params);
        $this->addData(array('page'=>'Aviso Legal'));
   			$this->model=new \X\App\Models\mAvisoLegal();
   			$this->view =new \X\App\Views\vAvisoLegal($this->dataView,$this->dataTable);
      }


   		function home(){
   		}
   }
