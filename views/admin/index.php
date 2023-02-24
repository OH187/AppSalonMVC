<h1 class="nombre-pagina">Panel de Administración</h1>

<!--Importamos la parte donde esta el saludo y el boton de cerrar sesión -->
<?php include_once __DIR__ . '/../templates/barra.php' ?>

<h2>Buscar citas</h2>

<div class="busqueda">
    <form class="formulario" action="">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form>
</div>

<?php if(count($citas) === 0){ echo "<h3>No hay citas en esta fecha</h3>"; } ?>

<div id="citas-admin">
    <ul class="citas">
        <?php 
            $idCita = 0;
            foreach($citas as $key => $cita): //$key es la posición que tiene el registro en el arreglo, el id es lo que viene de la BD
            //Este if va a impedir que muestre servicios pertenecientes al mismo id, solamente muestra una vez el
               if($idCita !== $cita->id):// inicio if
                    $total = 0;
        ?>
            <li>
                    <p>ID: <span><?php echo $cita->id; ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                    <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                    <p>Email: <span><?php echo $cita->email; ?></span></p>
                    <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>

                    <h3>Servicios</h3>
                    <?php 
                        $idCita = $cita->id; 
                        endif;  //fin if 
                        $total += $cita->precio;
                    ?>
                    <p class="servicio"><?php echo $cita->servicio . " $" . $cita->precio; ?></p>
            <?php 

                $actual = $cita->id; //nos retorna el id en el que nos encontramos (de la BD)
                $proximo = $citas[$key +1]->id ?? 0; //Este es el indice en el arreglo de la BD
                
                if(esUltimo($actual, $proximo)){ ?>
                    <p class="total">Total: <span>$<?php echo $total; ?></span></p>

                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>"> 
                        <input type="submit" class="boton-eliminar" value="Eliminar">
                    </form>

        <?php }; endforeach; ?>
    </ul>
    
</div>

<?php $script = "<script src='build/js/buscador.js'></script>" ?>

