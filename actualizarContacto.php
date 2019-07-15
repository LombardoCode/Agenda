<?php
    // Vamos a requerir la conexión a la base de datos para poder actualizar el contacto
    include 'include/conexion.php';

    // Verificamos si la conexión se estableció correctamente
    if (isset($conexion)) {
        // Verificamos hay contenido dentro del $_POST de nombre, teléfono y email
        if (isset($_POST['nombre'])) {
            $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
            //echo 'Nombre: ' . $nombre . '<br>';
        }
        if (isset($_POST['telefono'])) {
            $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_NUMBER_INT);
            //echo 'Telefono: ' . $telefono . '<br>';
        }
        if (isset($_POST['email'])) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            //echo 'Email: ' . $email . '<br>';
        }
        if (isset($_POST['id_usuario'])) {
            $id_usuario = filter_var($_POST['id_usuario'], FILTER_SANITIZE_NUMBER_INT);
            //echo 'Email: ' . $email . '<br>';
        }

        //echo '<pre>';
        //print_r($_POST);
        //echo '</pre>';

        // Realizamos la actualización mediante SQL
        try {
            $instruccion_sql = "UPDATE Contactos SET Nombre = :nombre, Telefono = :telefono, Email = :email WHERE ID_Usuario = :id_usuario";
            $query = $conexion -> prepare($instruccion_sql);
            $query -> bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $query -> bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $query -> bindParam(':email', $email, PDO::PARAM_STR);
            $query -> bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
            $query -> execute();

            // Verificamos si se realizado correctamente la actualización de los datos
            if ($query -> rowCount() === 1) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => $nombre,
                    'telefono' => $telefono,
                    'email' => $email
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'Sin cambios'
                );
            }
        } catch (Exception $error) {
            $respuesta = array(
                'error' => $error -> getMessage()
            );
        }

        // Retornamos la respuesta del AJAX
        echo json_encode($respuesta);
    }
?>