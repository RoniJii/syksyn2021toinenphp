<?php
require_once('headers.php');
require_once('inc/functions.php');

$input = json_decode(file_get_contents('php://input'));

$name = filter_var($input->name,FILTER_SANITIZE_STRING);
$price = filter_var($input->price,FILTER_SANITIZE_STRING);
$image = filter_var($input->image,FILTER_SANITIZE_STRING);
$category = filter_var($input->category,FILTER_SANITIZE_STRING);

try {
    $db = openDb();
    $query = $db->prepare('insert into product(name, price, image, category_id) values (:name, :price, :image, :category)');
    $query->bindValue(':name', $name,PDO::PARAM_STR);
    $query->bindValue(':price', $price,PDO::PARAM_STR);
    $query->bindValue(':image', $image,PDO::PARAM_STR);
    $query->bindValue(':category',$category,PDO::PARAM_STR);
    $query->execute();

    header('HTTP/1.1 200 OK');
   $data = array('id' => $db->lastInsertId(), ':name' => $name, ':price' => $price, ':image' => $image, ':category' => $category, 'category' => $category);
   print json_encode($data);
   } catch (PDOException $pdoex) {
         returnError($pdoex);
}
