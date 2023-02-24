<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php //$alertas; 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form  action="/" class="formulario" method="POST" > <!-- / es la url que hemos colocado en el post en public/index para el metodo post-->
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu Email" name="email" autocomplete="username"/> <!-- el name me servirá para acceder $_POST['email'] -->
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu password" name="password" autocomplete="current-password"/>
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión" />
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes cuenta? Crear una</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>