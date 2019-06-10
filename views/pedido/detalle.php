<h1>Detalle del pedido</h1>

 <?php if (isset($pedido)): ?>
        <?php if(isset($_SESSION['admin'])): ?>
            <h3>Cambiar Estado del pedido</h3>
            <form action="<?=base_url?>/pedido/estado" method="POST">
                <input type="hidden" value="<?=$pedido->id?>" name="pedido_id"/>
                <select name="estado">
                    <option value="confirm" <?=$pedido->estado == "confirm" ? 'selected' : '' ?>>Pendiente</option>
                    <option value="preparate" <?=$pedido->estado == "preparate" ? 'selected' : '' ?>>En preparación</option>
                    <option value="ready" <?=$pedido->estado == "ready" ? 'selected' : '' ?>>Preparado para envío</option>
                    <option value="sended" <?=$pedido->estado == "sended" ? 'selected' : '' ?>>Envíado</option>
                </select>
                <input type="submit" value="Cambiar Estado" class="button">
            </form>
            <br>
        <?php endif;?>
        <h3>Dirección de Envío:</h3>
        <p>
            Provincia: <?= $pedido->provincia ?> <br/>
            Ciudad: <?= $pedido->localidad ?>   <br/>
            Dirección: <?= $pedido->direccion ?>   <br/>
        </p>
        <br/>
        <h3>Datos del pedido:</h3>
        <p>
            Estado: <?=Utils::showStatus($pedido->estado)?> <br/>
            Número: <?= $pedido->id ?> <br/>
            Total a pagar: <?= $pedido->coste ?> €  <br/>
        </p>
        <p>Productos:</p>
        <br>
        <table>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Unidades</th>
            </tr>
            <?php while ($producto = $productos->fetch_object()): ?>
                <tr>
                    <td>
                        <?php if ($producto->imagen != null): ?>
                            <img src="<?= base_url ?>uploads/images/<?= $producto->imagen ?>" class="img_carrito" alt="Camiseta">
                        <?php else: ?>
                            <img src="<?= base_url ?>assets/img/camiseta.png" class="img_carrito" alt="Camiseta">
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url ?>producto/ver&id=<?= $producto->id ?>"><?= $producto->nombre ?></a>
                    </td>
                    <td><?= $producto->precio ?> €</td>
                    <td><?= $producto->unidades ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>