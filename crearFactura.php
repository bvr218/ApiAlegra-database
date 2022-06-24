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

class invoice{

    public static function create($emitido,$vencimiento,$descripcion,$precio,$index,$id_contact){
        $hoy = date("Y-m-d");   
        $auth = base64_encode('correo@hotmail.com:tokenapi');
        $ch = curl_init();
        $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Basic ' . $auth,

        );
        curl_setopt($ch, CURLOPT_URL, 'https://app.alegra.com/api/v1/invoices');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $items = "";
        for($i=$index-1; $i>=0; $i--){
            if($i==0){
                if(strcmp($descripcion[$i], "Costo de reconexion") !== 0){
                    $ref = "REF CONEC";
                } else {
                    $ref = "REF ADIC";
                }
                $items = $items.'{"id":1,"reference":"'.$ref.'","price":'.$precio[$i].',"discount":0,"quantity":1, "description":"'.$descripcion[$i].'"}';
            } else{
                if(strcmp($descripcion[$i], "Costo de reconexion") !== 0){
                    $ref = "REF CONEC";
                } else {
                    $ref = "REF ADIC";
                }
                $items = $items.'{"id":1,"reference":"'.$ref.'","price":'.$precio[$i].',"discount":0,"quantity":1, "description":"'.$descripcion[$i].'"},';
            }
            
        }
        $body = '{ 
            "date": "'.$hoy.'",
            "dueDate": "'.$hoy.'",
            "client": '.$id_contact.',
            "paymentForm":"CASH",
            "paymentMethod":"CASH",
            "items":[
                '.$items.'
            ],
            "status": "open"
        }';
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $fac = curl_exec($ch);

        $cont = json_decode($fac); 
        $id_contact = $cont->id;
        return $id_contact;
        


    }



}

?>