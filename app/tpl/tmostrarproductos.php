<?php include 'head_common.php'; ?>
<div class="contenedor">
    <div class="breadcrumb">
        <ul>
            <li><a href="<?= BARRA; ?>">home</a></li>
            <li>&nbsp; > &nbsp;<a href="<?= BARRA; ?>mostrarproductos">mostrarproductos</a></li>
            <li><?php echo isset($this->categoria) ? "&nbsp; > &nbsp;" . $this->categoria : " "; ?></li>
        </ul>
    </div>

    <?php if (isset($this->categoria)) : ?>
        <!-- Categoria -->
        <h1><?= ucfirst($this->categoria); ?></h1>
    <?php endif; ?>

    <!-- Lista de Productos -->
    <div class="mostrar-general">
        <?php for ($i = 0; $i < count($this->dataTable); $i++) : ?>
            <?php $producto = $this->dataTable[$i]; ?>
            <?php include('item_producto.php'); ?>
        <?php endfor; ?>
    </div>
    <!-- Fin Lista de Productos -->

</div>
<?php include 'footer_common.php'; ?>
