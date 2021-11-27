<?php

/**
 * Tämä tiedosto hoitaa login-toiminnon. Login tarkistaa on basic auth otsikko asetettu.
 * Tämän jälkeen tarkistetaan löytyykö otsikon käyttäjätunnus ja salasana tietokannasta.
 * Jos löytyy, palautetaan clientille ok ja lisäksi JWT token.
 * 
 * JTW työkalut on lisätty headers.php-tiedostoon (fb-kansiossa itse kirjasto)
 */

use Firebase\JWT\JWT;

require_once('headers.php');
require_once('inc/functions.php');


//Tarkistetaan tuleeko palvelimelle basic login tiedot (Authorization: Basic asfkjsafdjsajflkasj)
if( isset($_SERVER['PHP_AUTH_USER']) ){
    if(checkUser(createDbConnection(), $_SERVER['PHP_AUTH_USER'],$_SERVER["PHP_AUTH_PW"] )){
        //luodataan jwt payload
        $payload = array(
            "iat" => time(),
            "sub"=> $_SERVER['PHP_AUTH_USER']
        );

        //luodaa signeerattu JWT
        $jwt = JWT::encode($payload, base64_encode('mysecret'), 'HS256');

        // { "info":"Kirjauduit sisään" }
        //json_encode( array("info"=>"Kirjauduit sisään")  );

        // lähetään json muodossa ja toke 
        echo json_encode( array("info"=>"Kirjauduit sisään", "token"=> $jwt));
        header('Content-Type: application/json');
        exit;
    }
}

//Ilmoitetaan käyttäjälle, että kirjaudupa sisään (avaa selaimessa login ikkunan)
//header('WWW-Authenticate: Basic');

//Käyttäjälle unauhtorized-otsikko
echo '{"info":"Failed to login"}';
header('Content-Type: application/json');
header('HTTP/1.1 401');
exit;

?>