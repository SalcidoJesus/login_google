<?php
session_start();

if ( $_SESSION['tipo'] != 'ALUMNO' ) {
    header( 'location: index.php' );
}

echo "eres alumno :D";
?>
