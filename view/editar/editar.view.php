<?php
    // Verificamos si tenemos inicializada la conexión con la base de datos
    if (isset($conexion)) {
        // Obtenemos el ID del usuario que vamos a editar mediante la variable superglobal $_GET
        
        // Obtenemos toda la información del contacto (el id del contacto aparece en el URL)
        $id_contacto = $_GET['ID_Usuario'];
        $datos_del_contacto = obtenerContactoEspecifico($id_contacto);
    } else {
        //echo '<>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
    <link rel="stylesheet" href="view/editar/editar.css">
    <title>Editar un contacto</title>
</head>
<body>
    <!-- Encabezado -->
    <header>
        <div class="encabezado">
            <div class="encabezado-contenido container">
                <h1 class="text-center text-white font-weight-bold py-4">Edición de contactos</h1>
            </div>
        </div>
    </header>

    <!-- Sección "Agregar un contacto" -->
    <div class="agregar-contacto">
        <div class="agregar-contacto-contenido container contenedor-redondeado px-0 mt-4">
            <h3 class="text-center text-white py-3 subtitulo">Agrega un contacto</h3>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" id="formulario-de-contacto" class="py-2 px-4">
                <div id="inputs" class="d-lg-flex justify-content-between">
                    <div class="form-group py-3 px-4">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="input-nombre" class="form-control border border-primary" placeholder="Nombre de la persona"
                        value="<?php
                        if ($datos_del_contacto) {
                            // Encontramos los datos del usuario
                            echo $datos_del_contacto['Nombre'];
                        } else {
                            // No hay datos (este else se ejecutará si el usuario intenta cambiar el valor de ID_Usuario dentro del URL del sitio)
                            echo 'NO HAY DATOS';
                        }
                        ?>">
                    </div>
                    <div class="form-group py-3 px-4">
                        <label for="telefono">Teléfono</label>
                        <input type="text" name="telefono" id="input-telefono" class="form-control border border-primary" placeholder="Teléfono de la persona"
                        value="<?php
                        if ($datos_del_contacto) {
                            // Encontramos los datos del usuario
                            echo $datos_del_contacto['Telefono'];
                        } else {
                            // No hay datos (este else se ejecutará si el usuario intenta cambiar el valor de ID_Usuario dentro del URL del sitio)
                            echo 'NO HAY DATOS';
                        }
                        ?>">
                    </div>
                    <div class="form-group py-3 px-4">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="input-email" class="form-control border border-primary" placeholder="Correo electrónico de la persona"
                        value="<?php
                        if ($datos_del_contacto) {
                            // Encontramos los datos del usuario
                            echo $datos_del_contacto['Email'];
                        } else {
                            // No hay datos (este else se ejecutará si el usuario intenta cambiar el valor de ID_Usuario dentro del URL del sitio)
                            echo 'NO HAY DATOS';
                        }
                        ?>">
                    </div>
                </div>
                <div id="submit" class="d-flex justify-content-end">
                    <a href="index.php" class="btn btn-lg btn-primary my-2 text-white" id="boton_actualizar_contacto">
                        <span>
                            <i class="fas fa-save"></i>
                        </span>
                        Finalizar edición de contacto
                    </a>
                    <input type="hidden" name="" id="id" value="<?php echo $datos_del_contacto['ID_Usuario'] ?>">
                </div>
            </form>
        </div>
    </div>

    <script src="js/funciones.js"></script>
    <script>
        /* Obtención de elementos */
        let formulario_de_contacto = document.getElementById("formulario-de-contacto");

        formulario_de_contacto.addEventListener("submit", validarInformacion);

        let botonActualizarContacto = document.getElementById("boton_actualizar_contacto");

        botonActualizarContacto.addEventListener("click", actualizarContactoAJAX);
        
        
    </script>

</body>
</html>