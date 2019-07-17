<?php
    // Vamos a requerir la conexión a la base de datos para poder actualizar el contacto
    include 'include/conexion.php';

    // Verificamos si la conexión se estableció correctamente
    if (isset($conexion)) {
        // Verificamos hay contenido dentro del $_POST de nombre, teléfono y email
        if (isset($_POST['busqueda'])) {
            $busqueda = filter_var($_POST['busqueda'], FILTER_SANITIZE_STRING);
        }

        // Realizamos la actualización mediante SQL
        try {
            $instruccion_sql = "SELECT * FROM Contactos WHERE Nombre LIKE CONCAT('%', :busqueda, '%')";
            $query = $conexion -> prepare($instruccion_sql);
            $query -> bindParam(':busqueda', $busqueda, PDO::PARAM_STR);
            $query -> execute();

            // Verificamos si se realizado correctamente la actualización de los datos
            if ($query -> rowCount() > 0) {
                // Obtenemos los resultados
                $resultados = $query -> fetchAll();

                $respuesta = array(
                    'respuesta' => 'correcto',
                    'resultados' => $resultados
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'No se encontraron resultados'
                );
            }
        } catch (Exception $error) {
            $respuesta = array(
                'error' => $error -> getMessage()
            );
        }

        echo json_encode($respuesta);
    }
?>