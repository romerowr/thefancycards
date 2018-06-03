<?php
	include 'head_common.php';
	?>

	<?php
		use \X\Sys\Session;

		/**
		* Aqui comprobamos si hay session si no hay, redireccionamos a error
		*/
		if(!empty(Session::get('rol'))) :
	?>

	<div class="contenedor">
		<div class="breadcrumb">
			<ul>
				<li><a href="<?= BARRA;?>">Home</a></li>
				<li>&nbsp; > &nbsp;<a href="<?= BARRA;?>micuenta">MiCuenta</a></li>
			</ul>
		</div>


<div class="tabordion">
	<!-- Inicio perfil -->
  <section id="section1">
    <input type="radio" name="sections" id="option1" >
    <label for="option1">Perfil</label>
    <article>
      <h2>Perfil</h2>
			<div>
					<form id="editPerfil" method="POST">
							<p>
									<label for="nombre">Nombre</label>
									<input name="nombre" type="text" <?= ($this->dataTable['0']['nombre'] != "") ? "value='".$this->dataTable['0']['nombre']."'" : "placeholder='nombre'" ?> required>
							</p>

							<p>
									<label for="apellido1">Apellido1</label>
									<input name="apellido1" type="text" <?= ($this->dataTable['0']['apellido1'] != "") ? "value='".$this->dataTable['0']['apellido1']."'" : "placeholder='Primer apellido'" ?> required>
							</p>

							<p>
									<label for="apellido2">Apellido2</label>
									<input name="apellido2" type="text" <?= ($this->dataTable['0']['apellido2'] != "") ? "value='".$this->dataTable['0']['apellido2']."'" : "placeholder='Segundo apellido'" ?> required>
							</p>

							<p>
									<label for="dni">Dni</label>
									<input name="dni" type="text" <?= ($this->dataTable['0']['dni'] != "") ? "value='".$this->dataTable['0']['dni']."'" : "placeholder='Dni'" ?> required>
							</p>

							<p>
									<label for="direccion">Dirección</label>
									<input name="direccion" type="text" <?= ($this->dataTable['0']['direccion'] != "") ? "value='".$this->dataTable['0']['direccion']."'" : "placeholder='Dirección'" ?> required>
							</p>

							<p>
									<label for="telefono">Teléfono</label>
									<input name="telefono" type="text" <?= ($this->dataTable['0']['telefono'] != "") ? "value='".$this->dataTable['0']['telefono']."'" : "placeholder='Teléfono'" ?> required>
							</p>

							<p>
								<label for="cargaProvincias">Provincia</label>
								<input id="ocultoProvincia" type="hidden" name="ocultoProvincia" value="<?= ($this->dataTable['0']['provincias_idProvincia'] != "") ? $this->dataTable['0']['provincias_idProvincia'] : "0" ?>">
								<select id="cargaProvincias" name="cargaProvincias" required>
									<!--Cargo Provincia desde ajax -->
								</select>
								<?= ($this->dataTable['0']['proviNombre'] != "") ? "<span>Actual: ".$this->dataTable['0']['proviNombre']."</span>" : "" ?>
							</p>

							<p>
								<label for="cargaPoblaciones">Población</label>
								<input id="ocultoPoblacion" type="hidden" name="ocultoPoblacion" value="<?= ($this->dataTable['0']['poblaciones_idPoblaciones'] != "") ? $this->dataTable['0']['poblaciones_idPoblaciones'] : "0" ?>">
								<select id="cargaPoblaciones" name="cargaPoblaciones" required>
									<!--Cargo Provincia desde ajax -->
								</select>
								<?= ($this->dataTable['0']['poblaNombre'] != "") ? "<span>Actual: ".$this->dataTable['0']['poblaNombre']."</span>" : "" ?>
							</p>
							<p>
									<input type="submit" value="Aceptar Cambios">
							</p>
					</form>

			</div>
    </article>
  </section>
	<!-- Fin perfil -->

	<!-- Inicio pedidos -->
  <section id="section2">
    <input type="radio" name="sections" id="option2">
    <label for="option2">Pedidos</label>
    <article>
			<div class="pedidoPendiente">
				<!-- contenido cargado mediante ajax -->
			</div>
			<div class="pedidosFormPago">
				<form action="<?= BARRA;?>micuenta/pagarPedido" method="POST">
						<p>
								<label for="pedidoNumero">Pedido Numero</label>
								<input id="pedidoNumero" name="pedidoNumero" type="text" placeholder="numero" required readonly>
						</p>

						<p>
								<label for="precioTotal">Total</label>
								<input id="precioTotal" name="precioTotal" type="text" placeholder="numero" required readonly>
						</p>

						<p>
							<input type="radio" name="pago" value="1" checked> Tarjeta
  						<input type="radio" name="pago" value="2"> PayPal
  						<input type="radio" name="pago" value="3"> Otros
						</p>

						<p>
								<input type="submit" value="Formalizar Pago">
						</p>
				</form>
			</div>
			<div class="pedidosPagados">
				<!-- contenido cargado mediante ajax -->
			</div>
		</article>
  </section>
	<!-- Fin pedidos -->

</div>
</div>

<?php
/**
* Mensaje de cuando no estas registrado
*/
else : ?>
<h1>Registrate para acceder a tu cuenta</h1>
<?php endif; ?>

<?php
	include 'footer_common.php';
?>
