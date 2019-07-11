<?php
    // Devolvemos un string JSON ya codificado
    //echo json_encode($_POST);

    // Necesitaremos este archivo para poder obtener la variable $conexion y realizar operaciones con la misma
    include 'conexion.php';

    // Verificamos si existe la conexión a la base de datos
    if (isset($conexion)) {
        // Verificamos hay contenido dentro del $_POST de nombre, teléfono y email
        if (isset($_POST['nombre'])) {
            $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
        }
        if (isset($_POST['telefono'])) {
            $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_NUMBER_INT);
        }
        if (isset($_POST['email'])) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        }

        try {
            // Hacemos un INSERT con los datos recuperados del formulario
            $instruccion_sql = "INSERT INTO Contactos (Nombre, Telefono, Email) VALUES (:nombre, :telefono, :email)";
            $query = $conexion -> prepare($instruccion_sql);
            $query -> bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $query -> bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $query -> bindParam(':email', $email, PDO::PARAM_STR);
            $query -> execute();
            if ($query -> rowCount() === 1) {
                $respuesta = array (
                    'respuesta' => 'correcto',
                    'id_insertado' => $conexion -> lastInsertId(),
                    'nombre' => $nombre,
                    'telefono' => $telefono,
                    'email' => $email
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