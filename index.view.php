<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
    <link rel="stylesheet" href="index.css">
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
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="py-2 px-4">
                <div id="inputs" class="d-lg-flex justify-content-between">
                    <div class="form-group py-3 px-4">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="" class="form-control border border-primary" placeholder="Nombre de la persona" required>
                    </div>
                    <div class="form-group py-3 px-4">
                        <label for="telefono">Teléfono</label>
                        <input type="text" name="telefono" id="" class="form-control border border-primary" placeholder="Teléfono de la persona" required>
                    </div>
                    <div class="form-group py-3 px-4">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="" class="form-control border border-primary" placeholder="Correo electrónico de la persona" required>
                    </div>
                </div>
                <div id="submit" class="d-flex justify-content-end">
                    <input type="submit" name="submit-contacto" class="btn btn-lg btn-success" value="Crear contacto">
                </div>
            </form>
        </div>
    </div>

    <!-- Sección: "Lista de contactos" -->
    <div class="lista-de-contactos">
        <div class="lista-de-contactos-contenido container contenedor-redondeado px-0 mt-4">
            <h3 class="text-center text-white py-3 subtitulo">Lista de contactos</h3>
            <table class="table">
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
                        
                        // Limpiamos el $_POST para que al momento de que el usuario recargue la página no haya una doble inserción de datos en la base de datos
                        // limpiarPOST();
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
                                <button class="rounded boton-icono border border-secondary">
                                    <i class="fas fa-edit fa-2x icono-editar text-dark"></i>
                                </button>
                                <button class="rounded boton-icono border border-secondary">
                                    <i class="fas fa-user-slash fa-2x icono-eliminar text-danger"></i>
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let xhr = new XMLHttpRequest();
        xhr.open("GET", 'index.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Código...
            }
        }
    </script>

</body>
</html>