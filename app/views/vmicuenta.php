<?php

	namespace X\App\Views;

	use \X\Sys\View;

	class vMiCuenta extends View{

		function __construct($dataView,$dataTable=null){
			parent::__construct($dataView,$dataTable);
			$this->output= $this->render('tmicuenta.php');

		}


	}
