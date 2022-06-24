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

class payments{

    public static function create($id,$amount){
        $hoy = date("Y-m-d");
        $auth = base64_encode('correo@hotmail.com:tokenapi');
        $ch = curl_init();
        $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Basic ' . $auth,

        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.alegra.com/api/v1/payments');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $body = '{
        "date":"'.$hoy.'",
        "bankAccount":{
            "id":"1"
        },
        "paymentMethod": "cash",
        "invoices":[
            {"id":"'.$id.'","amount":"'.$amount.'"}
        ]
        }';
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $contact = curl_exec($ch);
 
        $cont = json_decode($contact);
        $id_contact = $cont->id;
        return $id_contact;
    }



}

?>