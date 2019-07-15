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

    <!-- Sección: "Lista de contactos" -->
    <div class="lista-de-contactos">
        <div class="lista-de-contactos-contenido container contenedor-redondeado px-0 mt-4">
            <h3 class="text-center text-white py-3 subtitulo">Lista de contactos</h3>
            <table class="table" id="tabla-de-contactos">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
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
                            <td><?php echo $contacto['Nombre'] ?></td>
                            <td><?php echo $contacto['Telefono'] ?></td>
                            <td><?php echo $contacto['Email'] ?></td>
                            <td>
                                <a href="<?php echo 'editar.php?ID_Usuario=' . $contacto['ID_Usuario']; ?>" class="rounded boton-icono border border-secondary">
                                    <i class="fas fa-edit fa-2x icono-editar text-dark"></i>
                                </a>
                                <a data-id="<?php echo $contacto['ID_Usuario'] ?>" class="rounded boton-icono border border-secondary">
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

    <script src="js/funciones.js"></script>
    <script>
        /* Obtención de elementos */
        let formulario_de_contacto = document.getElementById("formulario-de-contacto");

        formulario_de_contacto.addEventListener("submit", validarInformacion);

    </script>

</body>
</html>