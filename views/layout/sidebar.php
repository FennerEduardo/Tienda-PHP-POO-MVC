<!-- BARRA LATERAL  -->
<aside id="lateral">
    <div id="carrito" class="block_aside">
        <h3>Mi Carrito</h3>
        <ul>
            <?php $stats = Utils::statsCarrito()?>
            <li><a href="<?=base_url?>carrito/index">Productos (<?=$stats['count']?>)</a></li>
            <li><a href="<?=base_url?>carrito/index">Total: <?=$stats['total']?> €</a></li>
            <li><a href="<?=base_url?>carrito/index">Ver el Carrito</a></li>
        </ul>   
    </div>
    
    
    <div id="login" class="block_aside">
        <?php if(!isset($_SESSION['identity'])): ?>
            
        
        <h3>Entrar a la Web</h3>
        <form action="<?=base_url?>usuario/login" method="POST">
            <label for="email">Email</label>
            <input type="email" name="email">
            <label for="password">Contraseña</label>
            <input type="password" name="password">
            <input type="submit" value="Entrar">
        </form>
        <?php else: ?>
        <h3><?=$_SESSION['identity']->nombre?>  <?=$_SESSION['identity']->apellidos?></h3>
        <?php endif; ?>
        <ul>
            
            <?php if(isset($_SESSION['admin'])): ?>
                <li><a href="<?=base_url?>categoria/index">Gestionar Categorías</a></li>
                <li><a href="<?=base_url?>producto/gestion">Gestionar Productos</a></li>
                <li><a href="<?=base_url?>pedido/gestion">Gestionar Pedidos</a></li>
            <?php endif; ?>
            <?php if(isset($_SESSION['identity'])): ?>
                <li><a href="<?=base_url?>pedido/mis_pedidos">Mis pedidos</a></li>
                <li><a href="<?=base_url?>usuario/logout">Cerrar Sesión</a></li>
            <?php else: ?>   
                 <li><a href="<?=base_url?>usuario/registro">Registrate aquí!</a></li>
            <?php endif; ?>
        </ul>
    </div>
</aside>
<!-- CONTENIDO CENTRAL  -->
<div id="central">
