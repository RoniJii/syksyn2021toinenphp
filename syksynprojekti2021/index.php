<?php
require_once('inc/headers.php');
require_once('inc/functions.php');

try {
    $db = openDb();
    selectAsJson($db,'select * from category');
}
catch (PDOException $pdoex) {
    returnError($pdoex);
} 
/* $sql = 'select * from xxxx';
$query = $db->query($sql);
$results = $query->fetchAll(PDO::FETCH_ASSOC);
header('HTTP/1.1 200 OK');
print json_encode($results);  */