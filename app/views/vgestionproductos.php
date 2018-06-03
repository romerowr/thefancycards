<?php

	namespace X\App\Views;

	use \X\Sys\View;

	class vGestionProductos extends View{

		function __construct($dataView,$dataTable=null){
			parent::__construct($dataView,$dataTable);
			$this->output= $this->render('tgestionproductos.php');

		}


	}
