<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuación</p>

<?php //$alertas; 
    include_once __DIR__ . "/../templates/alertas.php";

    if($error) return; //No mostramos el formulario en caso que la varible sea false, viene del LoginController
?>

<form method="POST" class="formulario"> <!-- Le quitamos el action, porque vamos a tomar la misma url y si lo dejamos eliminará el token -->
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu nuevo password" />
    </div>
    <input type="submit" class="boton" value="Guardar password">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes cuenta? Crear una</a>
</div>