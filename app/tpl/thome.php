<?php /* @var $this \X\Sys\View */ ?>
<?php include 'head_common.php'; ?>


<?php if ($this->dataTable['mas_vendidos']) : ?>
    <!-- Productos más vendidos section -->
    <section id="los-mas-vendidos" class="home-section">
        <header>
            <h1 class="title">Los más vendidos</h1>
        </header>
        <div class="lista-productos center">
            <?php foreach ($this->dataTable['mas_vendidos'] as $producto) : ?>
                <?php include('item_producto.php'); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <!-- Fin Productos más vendidos section -->
<?php endif; ?>

<?php if ($this->dataTable['ultimos_anadidos']) : ?>
    <!-- Últimos Productos section -->
    <section id="ultimos-anadidos" class="home-section">
        <header>
            <h1 class="title">Últimos añadidos</h1>
        </header>
        <div class="lista-productos center">
            <?php foreach ($this->dataTable['ultimos_anadidos'] as $producto) : ?>
                <?php include('item_producto.php'); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <!-- Fin Últimos Productos section -->
<?php endif; ?>

<?php include 'footer_common.php'; ?>
