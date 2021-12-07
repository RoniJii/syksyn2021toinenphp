<?php
require_once('headers.php');
require_once('inc/functions.php');

echo "ja tänne lisäilyt sitten";

$fname = filter_var($input->firstname,FILTER_SANITIZE_STRING);
$lname = filter_var($input->lastname,FILTER_SANITIZE_STRING);
$address = filter_var($input->address,FILTER_SANITIZE_STRING);
$zip = filter_var($input->zip,FILTER_SANITIZE_STRING);
$city = filter_var($input->city,FILTER_SANITIZE_STRING);
$cart = $input->cart;

$db = null;
try {
    $db = openDb();

    $db->beginTransaction();

    $sql = "insert into customer (firstname,lastname,address,zip,city) values 
    ('" .
    filter_var($fname,FILTER_SANITIZE_STRING) . "','" .
    filter_var($lname,FILTER_SANITIZE_STRING) . "','" .
    filter_var($address,FILTER_SANITIZE_STRING) . "','" .
    filter_var($zip,FILTER_SANITIZE_STRING) . "','" .
    filter_var($city,FILTER_SANITIZE_STRING)
    . "')";

$customer_id = executeInsert($db,$sql);

$sql = "insert into `order` (customer_id) values ($customer_id)";
$order_id = executeInsert($db,$sql);

foreach ($cart as $product) {
    $sql = "insert into order_row (order_id,product_id) values ("
    .
    $order_id . "," .
    $product->id
    . ")";
    executeInsert($db,$sql);
}

$db->commit();



}
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
