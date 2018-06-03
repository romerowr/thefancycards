<?php

namespace X\App\Models;

use X\Sys\Model;

class mHome extends Model
{
    public function __construct()
    {
        parent::__construct();

    }


  //Funcion que al final no uso
    public function getRoles()
    {
        $sql = "SELECT * FROM roles";
        $this->query($sql);

        $res = $this->execute();
        if ($res) {
            $result = $this->resultset();

        } else {
            $result = null;
        }

        return $result;
    }


    /**
    * Este DocBlock documenta la función getProductosMasVendidos()
    * Recogemos los productos mas vendidos en nuestra web
    * Ponemos que por defecto, si no pedimos cantidad de productos el maximo sean 10
    * @param  integer $limit
    * @return [array]
    */
    public function getProductosMasVendidos($limit = 10)
    {
        $sql = 'select idProducto, p.nombre as producto, descripcion, precio, categorias.nombre as categoria, path '
            . 'from productos p '
            . 'left join pedidos_has_productos pp on pp.productos_idProducto = p.idProducto '
            . 'inner join imagenes on p.idProducto = imagenes.productos_idProducto '
            . 'inner join productos_has_categorias on p.idProducto = productos_has_categorias.productos_idProducto '
            . 'inner join categorias on productos_has_categorias.categorias_idCategoria = categorias.idCategoria '
            . 'group by p.idProducto '
            . 'order by count(*) desc '
            . 'limit ' . $limit;

        return $this->devolverArray($sql);
    }
    /**
    * Este DocBlock documenta la función getUltimosProductos()
    * Recogemos los ultimos productos añadidos en nuestra web
    * Ponemos que por defecto, si no pedimos cantidad de productos el maximo sean 10
    * @param  integer $limit
    * @return [array]
    */
    public function getUltimosProductos($limit = 10)
    {
        $sql = 'select idProducto, p.nombre as producto, descripcion, precio, categorias.nombre as categoria, path '
            . 'from productos p '
            . 'inner join imagenes on p.idProducto = imagenes.productos_idProducto '
            . 'inner join productos_has_categorias on p.idProducto = productos_has_categorias.productos_idProducto '
            . 'inner join categorias on productos_has_categorias.categorias_idCategoria = categorias.idCategoria '
            . 'order by idProducto desc '
            . 'limit ' . $limit;

        return $this->devolverArray($sql);
    }
    /**
    * Este DocBlock documenta la función devolverArray()
    * hacemos esta funcion privada para reutilizarla y no duplicar codigo
    * hace la parte del retorno y el execute.
    * @param  [string] $sql
    * @return [array]      [Array con los resultados de la consulta, o array vacio]
    */
    private function devolverArray($sql)
    {
        $this->query($sql);
        $res = $this->execute();
        if ($res) {
            $result = $this->resultset();

        } else {
            $result = array();
        }
        return $result;
    }
}
