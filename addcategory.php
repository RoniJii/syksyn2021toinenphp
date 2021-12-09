<?php
require_once('inc/headers.php');
require_once('inc/functions.php');

$input = json_decode(file_get_contents('php://input'));
$category = filter_var($input->category,FILTER_SANITIZE_STRING);

try {
    $db = openDb();
    $query = $db->prepare('insert into category(name) values (:category)');
    $query->bindValue(':category',$category,PDO::PARAM_STR);
    $query->execute();

    header('HTTP/1.1 200 OK');
   $data = array('id' => $db->lastInsertId(), 'category' => $category);
   print json_encode($data);
   } catch (PDOException $pdoex) {
         returnError($pdoex);
} 