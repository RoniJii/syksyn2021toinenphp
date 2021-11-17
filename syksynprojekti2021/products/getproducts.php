<?php
require_once('../inc/headers.php');
require_once('../inc/functions.php');

//read parameters from url. Example http://localhost/webshop/products/getproduct.php/1
$uri = parse_url(filter_input(INPUT_SERVER,'PATH_INFO'),PHP_URL_PATH);
// Parametres are separated with (/)
$parameters = explode('/',$uri);
// Catergory id is first parameter so it follows after address separed with slash
$category_id = $parameters[1];

try {
    $db = openDb();
    selectAsJson($db,"select * from product where category_id = $category_id");
}
catch (PDOException $pdoex){
    returnError($pdox);
}