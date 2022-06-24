<?php
defined('_JEXEC') or die('<!DOCTYPE html>
<html>
    <head>
        <title>
            404 Not Found
        </title>
    </head>
    <body>
        <h1>Not Found</h1>
        <p>The resquest URL was not found on this server.</p>
        <hr>
        <address>Apache/2.4.10 (Debian) Server at internet2.fututel.com Port 80</address>
    </body>
</html>');

$hostname='';
$database='';
$username='';
$password='';

$conexion1 = new mysqli($hostname,$username,$password,$database);
if($conexion1->connect_errno){
    echo "lo sentimos, no se pudo establecer conexion";
}


?>