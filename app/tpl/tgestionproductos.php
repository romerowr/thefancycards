<?php
	include 'head_common.php';
	?>

	<?php
		use \X\Sys\Session;

		if(!empty(Session::get('rol'))) :
				if(Session::get('rol') < 3) :
	?>
		<div class="contenedor">
			<div class="breadcrumb">
				<ul>
					<li><a href="<?= BARRA;?>">home</a></li>
					<li>&nbsp; > &nbsp;<a href="<?= BARRA;?>gestionproductos">gestionproductos</a></li>
				</ul>
			</div>

			<!-- Inicio ver tabla Productos -->
			<div class="gestionProductos">

				<div><h1>Gestión Productos</h1></div>
                <div>
                    <table class="table tab_productos">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Precio/€</th>
                                    <th>Categoría</th>
                                    <th>Path img</th>
                                    <th>Activo</th>
                                    <th>Editar</th>
                                    <th>Cambiar estado</th>
                                </tr>
                         <?php for($i=0;$i<count($this->dataTable);$i++){ ?>
                                <tr>
                                    <?php foreach($this->dataTable[$i] as $key=>$value) :?>
                                         <td><?= $value; ?></td>
                                    <?php endforeach; ?>
                                    <td class="editProducto" data-valor="<?= $this->dataTable[$i]['idProducto']; ?>"> <a href="#modProduct-id">Editar</a> </td>
                                    <td class="estadoProducto" data-valor="<?= $this->dataTable[$i]['idProducto']; ?>" data-activo="<?= $this->dataTable[$i]['activo']; ?>">
                                        <a>
                                            <?= ($this->dataTable[$i]['activo'] == 1) ? "Desactivar" : "Activar";  ?>
                                        </a> </td>
                             </tr>
                         <?php } ?>
                    </table>
                </div>
			</div>
			<!-- Fin ver tabla Producto -->

			<!-- Inicio añadir nuevo Producto -->
			<div class="gestionProductos">
				<div><h1>Añadir Producto</h1></div>
                <div class="contenedor-tabla">
                    <table border class="tab_productos">
                        <tr>
                            <th>Nombre Producto</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Categoria</th>
                            <th>Path</th>
                            <th>Nombre Imagen</th>
                            <th></th>
                        </tr>
                        <tr> <!--  id="nuevoProducto" -->
                            <form action="<?= BARRA;?>gestionproductos/nuevoProducto" method="POST" enctype="multipart/form-data">
                                <td>
                                    <label for="nombre"></label>
                                    <input name="nombre" type="text" placeholder="Nombre" required>
                                </td>
                                <td>
                                    <label for="descripcion"></label>
                                    <input name="descripcion" type="text" placeholder="Descripción" required>
                                </td>
                                <td>
                                    <label for="precio"></label>
                                    <input name="precio" type="text" placeholder="Precio" required>
                                </td>
                                <td class="selectCategorias">
                                    <select name="categoria" required>
                                        <!--Cargo categorias desde ajax -->
                                    </select>
                                </td>
                                <td>
                                    <label for="archivo"></label>
                                    <input name="archivo" type="file" required>
                                </td>
                                <td>
                                    <label for="imagen"></label>
                                    <input name="imagen" type="text" placeholder="Nombre imagen" required>
                                </td>
                                <td>
                                    <input type="submit" value="Nuevo Producto">
                                </td>
                            </form>
                        </tr>
                    </table>
                </div>
				<p>*(En el precio se separan los decimales con el <strong>PUNTO</strong>, no con la COMA)</p>
			</div>
			<!-- Fin añadir nuevo producto -->

			<!-- Inicio editar Producto -->
			<div class="gestionProductos">
				<div><h1>Editar Producto</h1></div>
                <div class="contenedor-tabla">
                    <table border class="tab_productos">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Precio</th>
                            <th>Categoria</th>
                            <th>Path</th>
                            <th>Activo</th>
                            <th></th>
                        </tr>
                        <tr>

                                <form id="modProduct" method="POST">
                                    <td>
                                        <label for="id"></label>
                                        <input id="modProduct-id" name="id" type="text" placeholder="" required readonly>
                                    </td>
                                    <td>
                                        <label for="nombre"></label>
                                        <input id="modProduct-nombre" name="nombre" type="text" placeholder="Nombre" required>
                                    </td>
                                    <td>
                                        <label for="descripcion"></label>
                                        <input id="modProduct-descripcion" name="descripcion" type="text" placeholder="Descripción" required>
                                    </td>
                                    <td>
                                        <label for="precio"></label>
                                        <input id="modProduct-precio" name="precio" type="text" placeholder="Precio" required>
                                    </td>
                                    <td class="selectCategorias2">
                                        <select id="modProduct-categoria" name="categoria" required>
                                            <!--Cargo categorias desde ajax -->
                                        </select>
                                    </td>
                                    <td>
                                        <label for="path"></label>
                                        <input id="modProduct-path" name="path" type="text" placeholder="Path" required readonly>
                                    </td>
                                    <td>
                                        <select id="modProduct-activo" name="activo" required>
                                          <option value="0">Desactivar</option>
                                          <option value="1">Activar</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="submit" value="Editar Producto">
                                    </td>
                            </form>
                        </tr>
                    </table>
                </div>
				<p>*(En el precio se separan los decimales con el <strong>PUNTO</strong>, no con la COMA)</p>
			</div>
			<!-- Fin editar Producto -->

		</div>

		<?php
		/**
		* Mensaje a la hora de no poder gestionar productos
		*/
	 else : ?>  <h1>No tienes permisos para gestionar los productos</h1>
 <?php endif; else : ?>
 <h1>No tienes permisos para gestionar productos</h1> <?php endif; ?>



<?php
	include 'footer_common.php';
?>
