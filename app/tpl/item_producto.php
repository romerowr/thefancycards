<!-- Item producto (<?= $producto['idProducto']; ?>) -->
<figure class="producto mostrar-producto">
    <div class="contenedor-imagen">
        <img class="imagen" src="<?= BARRA . $producto['path']; ?>" alt="<?= $producto['producto']; ?>">
    </div>
    <div class="precio"><?= $producto['precio']; ?> €</div>
    <figcaption class="mostrar-nombre">
        <h3 class="nombre"><?= $producto['producto']; ?></h3>
        <p class="descripcion"><?= $producto['descripcion']; ?></p>
        <button class="boton-anadir-producto" name="anadirProducto" value="<?= $producto['idProducto']; ?>">AÑADIR AL CARRITO</button>
    </figcaption>
</figure>
<!-- Fin Item producto(<?= $producto['idProducto']; ?>) -->