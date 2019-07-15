<?php
// Incluimos el archivo a la conexión a la base de datos
include 'include/conexion.php';

// Si la conexión ha sido establecida...
if (isset($conexion)) {
    // Obtenemos el ID del usuario (que fué mandada por POST)
    if (isset($_POST['id_usuario'])) {
        $id_usuario = filter_var($_POST['id_usuario'], FILTER_SANITIZE_NUMBER_INT);
    }

    try {
        //echo 'Se ha realizado la conexión a la base de datos.';
        $instruccion_sql = "DELETE FROM Contactos WHERE ID_Usuario = :id_usuario";
        $query = $conexion -> prepare($instruccion_sql);
        $query -> bindParam(':id_usuario', $id_usuario, PDO::PARAM_STR);
        $query -> execute();

        if ($query -> rowCount() === 1) {
            $respuesta = array(
                'respuesta' => 'correcto',
                'mensaje' => 'usuario eliminado'
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error',
                'mensaje' => 'el usuario no ha sido eliminado'
            );
        }
    } catch (Exception $excepcion) {
        echo $excepcion -> getMessage();
    }

    // Devolvemos la respuesta al XHR (AJAX)
    echo json_encode($respuesta);
} else {
    echo 'No se ha podido establecer la conexión con la base de datos.';
}
?>