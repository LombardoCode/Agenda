<?php
try {
    $conexion = new PDO('mysql:host=localhost;dbname=Agenda', 'lombardoDBA', '1234');
    /*
    foreach($conexion->query('SELECT * from Contactos') as $row) {
        print_r($row);
    }
    */
    //$conexion = new PDO('mysql:host=localhost;dname=Agenda', 'lombardoDBA', '1234');
    //$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo '<script>alert("Conexión establecida.");</script>';
    
} catch (PDOException $error) {
    echo '<script>alert("Ocurrió un error al conectarse a la base de datos.");</script>';
    echo $error;
}
?>