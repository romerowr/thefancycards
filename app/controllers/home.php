<?php

namespace X\App\Controllers;

use X\App\Models\mHome;
use X\App\Views\vHome;
use X\Sys\Controller;
/**
*  @author Alex Romero
* Esta clase la que se carga por defecto al cargar nuestra web
*/
class Home extends Controller
{
    public function __construct($params)
    {
        parent::__construct($params);
        $this->addData(array(
            'page' => 'Home',
        ));
        $this->model = new mHome();
        $this->view = new vHome($this->dataView, $this->dataTable);
    }

    /**
    * Cargamos los datos que queremos usar para la vista de nuestra pagina de inicio
    * Y le paso los datos en una array multidimensional
    */

    function home()
    {
        $data = array();
        $data['mas_vendidos'] = $this->model->getProductosMasVendidos(3);
        $data['ultimos_anadidos'] = $this->model->getUltimosProductos(3);
        $this->addData($data);
        $this->view->__construct($this->dataView, $this->dataTable);
        $this->view->show();
    }
}
