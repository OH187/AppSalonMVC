<h1 class="nombre-pagina">Actualizar servicio</h1>
<p class="descripcion-pagina">Coloca la información que deseas actualizar</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php'; 
    include_once __DIR__ . "/../templates/alertas.php"; 
?>

<form class="formulario"  method="POST">
    <?php include_once __DIR__ . '/formulario.php';?>
    <input type="submit" name="boton" class="boton" value="Actualizar">
</form>