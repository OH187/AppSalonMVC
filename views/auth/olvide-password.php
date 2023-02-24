<h2 class="nombre-pagina">Olvidé password</h2>
<p class="descripcion-pagina">Reestablece tu password escribiendo tu email a continuación</p>

<?php //$alertas; 
    include_once __DIR__ . "/../templates/alertas.php";
?>


<form action="/olvide" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu Email" />
    </div>

    <input type="submit" class="boton" value="Enviar instrucciones">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>
</div>