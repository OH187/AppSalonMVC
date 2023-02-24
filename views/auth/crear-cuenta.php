<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Llena el formulario para crear una cuenta</p>

<?php //$alertas; 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form action="/crear-cuenta" class="formulario" method="POST">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" autocomplete="username" value="<?php echo s($usuario->nombre); ?>"/>
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" placeholder="Tu apellido" value="<?php echo s($usuario->apellido); ?>" />
    </div>

    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Tu telefono" value="<?php echo s($usuario->telefono); ?>" />
    </div>

    <div class="campo">
        <label for="email">Email</label>
        <input type="tel" id="email" name="email" placeholder="Tu email" value="<?php echo s($usuario->email); ?>" autocomplete="username"/>
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu password" autocomplete="current-password"/>
    </div>

    <input type="submit" value="Crear cuenta" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>