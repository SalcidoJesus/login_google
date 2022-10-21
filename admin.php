<?php
session_start();

if ( $_SESSION['tipo'] != 'ADMIN' ) {
    header( 'location: index.php' );
}

echo "eres admin :D";
?>
