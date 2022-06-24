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
    
class consultas{
    
    public static function consultaI($conexion1){
        $hoy = date("Y-m-01");
        $consulta = "SELECT emitido,vencimiento,nombre,movil,cedula,direccion,facturas.id,facturas.cobrado FROM `facturas` inner join tblservicios,usuarios WHERE instalado >= '$hoy' and tblservicios.idcliente = facturas.idcliente and usuarios.id = facturas.idcliente and emitido >= '$hoy'";
        $resultado = $conexion1 -> query($consulta);
        return $resultado;
    }
    public static function consultaF($conexion1,$idfactura){
        
        $consulta = "select facturaitems.descripcion,cantidad from facturas inner join facturaitems,tblservicios where facturas.idcliente = tblservicios.idcliente and facturaitems.idfactura = facturas.id and facturaitems.idfactura = $idfactura ";
        $resultado = $conexion1 -> query($consulta);
        return $resultado;
    }

}
    
    
?>