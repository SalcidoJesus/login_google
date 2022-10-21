<?php
// header('Content-Type: application/json');

// me traigo los paquetes que instalé con composer
require_once 'vendor/autoload.php';
require_once 'conexion.php';

// recibo el token que me generó el login de google
$id_token = $_POST['credential'];

// inicializo una nueva instancia del login de google
$client = new Google_Client([ 'client_id' => '626437405331-8d5qjsqqlk0hgqqj5uopah44p66rtcsl.apps.googleusercontent.com' ]);
// 626437405331-8d5qjsqqlk0hgqqj5uopah44p66rtcsl.apps.googleusercontent.com

// descifro el token que me llegó por post
$payload = $client -> verifyIdToken( $id_token );

// print_r( $payload );
$correo = $payload['email'];

// aquí busco los datos del correo que inició sesión
$resultado = $bd -> prepare( "SELECT * FROM usuarios WHERE usuario = ?" );
// la s es porque el parámetro es un string
$resultado -> bind_param("s", $correo);
// acá ejecutamos la consulta
$resultado -> execute();
// acá me traigo el resultado
$filas = $resultado -> get_result();
// con le num_rows me traigo la cantidad de lineas que me devuelve la consulta
$cantidad = $filas -> num_rows;

if ( $cantidad > 0 ) {
    // si está en la bd :D
    // me traigo los datos del usuario
    $datos = $filas -> fetch_assoc();
    
    // valido si es alumno
    if ( $datos['tipo'] == 'ALUMNO' ) {
        // creo una sesión
        session_start();
        // guardo el tipo de usuario
        $_SESSION['tipo'] = "ALUMNO";
        // lo redirijo a su panel
        header( 'location: alumno.php' );
        
    } else if ( $datos['tipo'] == 'ADMIN' ) {
        // creo una sesión
        session_start();
        // guardo el tipo de usuario
        $_SESSION['tipo'] = "ADMIN";
        // lo redirijo a su panel
        header( 'location: admin.php' );
        
    } else {
        echo "No tienes credenciales para acceder al sistema";
    }
    
} else {
    // no están en la bd
    echo "No tienes acceso al sistema.";
    ?>
    <br><a href='index.php'>Ir a la página principal</a>
    <?php
}

?>
