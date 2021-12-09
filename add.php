<?php
require_once('headers.php');
require_once('inc/functions.php');



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
