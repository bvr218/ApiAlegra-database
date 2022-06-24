<?php
define( '_JEXEC', 1 );

require ('crearContactos.php');
require ('crearFactura.php');
require ('crearPago.php');
require ('conexion.php');
require ('consultarDB.php');




$resultado = consultas::consultaI($conexion1);
while($fila=$resultado -> fetch_assoc()){
    $i = 0;
    
    $response = contacts::create($fila['nombre'],$fila['movil'],$fila['cedula'],$fila['direccion']);
    
    if($response != NULL){
        $resultado1 = consultas::consultaF($conexion1,$fila['id']); 
        $total = 0;
        while($fila1=$resultado1 -> fetch_array()){
            $descripcion[$i] = $fila1[0];
            $precio[$i] = $fila1[1];
            $total = $total + $precio[$i];
            $i=$i+1;
        }
        $response1 = invoice::create($fila['emitido'],$fila['vencimiento'],$descripcion,$precio,$i,$response);
        if($fila['cobrado'] < $total){
            $total = $fila['cobrado'];

        }
        $response2 = payments::create($response1,$total);
        
        sleep(0.5);
    }
    
}  
?>