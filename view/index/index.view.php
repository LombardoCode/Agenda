<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
    <link rel="stylesheet" href="view/index/index.css">
    <title>Agenda de contactos</title>
</head>
<body>

    <!-- Encabezado -->
    <header>
        <div class="encabezado">
            <div class="encabezado-contenido container">
                <h1 class="text-center text-white font-weight-bold py-4">Agenda de contactos</h1>
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
                        <input type="text" name="nombre" id="input-nombre" class="form-control border border-primary" placeholder="Nombre de la persona">
                    </div>
                    <div class="form-group py-3 px-4">
                        <label for="telefono">Teléfono</label>
                        <input type="text" name="telefono" id="input-telefono" class="form-control border border-primary" placeholder="Teléfono de la persona" required>
                    </div>
                    <div class="form-group py-3 px-4">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="input-email" class="form-control border border-primary" placeholder="Correo electrónico de la persona" required>
                    </div>
                </div>
                <div id="submit" class="d-flex justify-content-end">
                    <input type="submit" name="submit-contacto" id="submit-contacto" class="btn btn-lg btn-success my-2" value="Crear contacto" required>
                </div>
            </form>
        </div>
    </div>

    <!-- El modal -->
    <div class="modal fade hide" id="EliminarContactoModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Eliminación de contacto</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p>¿Estas seguro que desea eliminar el siguiente contacto?:</p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" id="botonEliminadorContacto" class="btn btn-danger" data-dismiss="modal">Eliminar contacto</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección: "Lista de contactos" -->
    <div class="lista-de-contactos mb-5">
        <div class="lista-de-contactos-contenido container contenedor-redondeado px-0 mt-4">
            <h3 class="text-center text-white py-3 subtitulo">Lista de contactos</h3>
            <h3 class="text-center py-3">Buscador de contactos</h3>
            <div id="buscador-de-contactos" class="justify-content-center d-none d-md-flex mb-3">
                <input type="text" id="buscador" class="form-control w-75 border border-primary" placeholder="Busca un contacto">
            </div>
            <table class="table" id="tabla-de-contactos">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php
                    // Si el usuario ya realizó un submit al formulario de contacto...
                    if (isset($_POST['submit-contacto'])) {
                        // Insertamos el contacto
                        insertarContacto();
                    }

                    // Obtenemos los contactos (la función está ubicada dentro de funciones.php)
                    $contactos = obtenerContactos();
                    
                    // Si tenemos contactos...
                    if ($contactos): ?>
                        <?php
                        // Imprime la información de cada contacto en una fila para la tabla
                        foreach($contactos as $contacto) { ?>
                        <tr>
                            <td><?php echo $contacto['Nombre']; ?></td>
                            <td><?php echo $contacto['Telefono']; ?></td>
                            <td><?php echo $contacto['Email']; ?></td>
                            <td>
                                <a href="<?php echo 'editar.php?ID_Usuario=' . $contacto['ID_Usuario']; ?>" class="rounded boton-icono border border-secondary">
                                    <i class="fas fa-edit fa-2x icono-editar text-dark"></i>
                                </a>
                                <a data-id="<?php echo $contacto['ID_Usuario']; ?>" class="rounded boton-icono border border-secondary boton-eliminar" data-toggle="modal" data-target="#EliminarContactoModal">
                                    <i class="fas fa-user-slash fa-2x icono-eliminar text-danger"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="js/funciones.js"></script>
    <script>
        /* Obtención de elementos */
        let formulario_de_contacto = document.getElementById("formulario-de-contacto");

        formulario_de_contacto.addEventListener("submit", validarInformacion);

    </script>
    

</body>
</html>