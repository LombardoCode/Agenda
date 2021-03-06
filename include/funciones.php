<?php
function insertarContacto() {
    // Necesitaremos este archivo para poder obtener la variable $conexion y realizar operaciones con la misma
    include 'conexion.php';

    // Verificamos si existe la conexión a la base de datos
    if (isset($conexion)) {
        // Creamos unas variables iniciales para reutilizarlas dentro de código SQL
        $tablaBDD = "Agenda";
        // Verificamos si se realizó un submit dentro de nuestra aplicación
        if (isset($_POST['submit-contacto'])) {
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

            //echo '<script>alert("Insertando la información.");</script>';

            // Hacemos un INSERT con los datos recuperados del formulario
            $instruccion_sql = "INSERT INTO Contactos (Nombre, Telefono, Email) VALUES (:nombre, :telefono, :email)";
            $query = $conexion -> prepare($instruccion_sql);
            $query -> bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $query -> bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $query -> bindParam(':email', $email, PDO::PARAM_STR);
            $query -> execute();


            // Redireccionamos al usuario a la misma página, de modo que cuando sea redireccionado $_POST quede vacio y se evite la doble inserción de datos (SQL)
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
    } else {
        echo 'Algo salió mal.';
    }
}


function obtenerContactos() {
    //echo '<script>alert("Obteniendo la información.");</script>';

    // Necesitaremos este archivo para poder obtener la variable $conexion y realizar operaciones con la misma
    include 'conexion.php';

    try {
        // Obtenemos todos los contactos
        $instruccion_sql = $conexion -> prepare("SELECT * FROM Contactos");
        $instruccion_sql -> execute();
        $contactos = $instruccion_sql -> fetchAll();
        return $contactos;
    } catch (Exception $exception) {
        echo $exception -> getMessage();
        return false;
    }
}

function obtenerContactoEspecifico($id_contacto) {
    // Necesitaremos este archivo para poder obtener la variable $conexion y realizar operaciones con la misma
    include 'include/conexion.php';
    
    // Verificamos si la conexión a la base de datos ha sido inicializada
    if (isset($conexion)) {
        // Vamos a tratar de realizar la instrucción SQL
        try {
            // Obtenemos la información del contacto en especifico
            $instruccion_sql = "SELECT * FROM Contactos WHERE ID_Usuario = :id";
            $query = $conexion -> prepare($instruccion_sql);
            $query -> bindParam(":id", $id_contacto, PDO::PARAM_INT);
            $query -> execute();
            $resultados = $query -> fetch();
            if ($query -> rowCount() === 1) {
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'ID_Usuario' => $resultados['ID_Usuario'],
                    'Nombre' => $resultados['Nombre'],
                    'Telefono' => $resultados['Telefono'],
                    'Email' => $resultados['Email']
                );
            } else {
                $respuesta = array(
                    'respuesta' => 'No se obtuvieron los datos del usuario'
                );
            }
            return $respuesta;
        } catch (Exception $error) {
            echo $exception -> getMessage();
            return false;
        }
    } else {
        echo 'Hubo un error al conectarse a la base de datos';
    }

    

}

