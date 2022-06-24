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

class contacts{

    public static function create($nombre,$movil,$cedula,$direccion){
        $nombre = explode(" ", $nombre);
        if($nombre[2]){
            $nombreC = '"firstName" : "'.$nombre[0].'","secondName": "'.$nombre[1].'","lastName" : "'.$nombre[2].'"';
            
        } else {
            $nombreC = '"firstName" : "'.$nombre[0].'","lastName" : "'.$nombre[1].'"';
        }
        $direccion = substr($direccion, 0, 30);
        $movil = substr($movil, 0, 10);
        $auth = base64_encode('correo@hotmail.com:tokenapi');
        $ch = curl_init();
        $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Basic ' . $auth,

        );
        curl_setopt($ch, CURLOPT_URL, 'https://app.alegra.com/api/v1/contacts');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $body = '{
        "ignoreRepeated": false,
        "kindOfPerson": "PERSON_ENTITY",
        "name":{
            '.$nombreC.'
        },
        "identificationObject":{
            "type":"CC",
            "number":"'.$cedula.'"
        },
        "mobile": "'.$movil.'",
        "email": "",
        "phonePrimary":"'.$movil.'",
        "address": {
        "address": "'.$direccion.'",
        "city": "Pitalito",
        "department": "Huila",
        "country": "Colombia"
        },
        "type": "client"
        }';
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $contact = curl_exec($ch);
        $cont = json_decode($contact);
        if($cont->code){
            if($cont->code == 2006){
                return NULL;
            } else {
                $id_contact = $cont->id;
                return $id_contact;
            }
        } else{
            $id_contact = $cont->id;
            return $id_contact;
        }
        
        
        

    }



}

?>