<?php


header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/order.php';

$idd = $_GET['id'];
$first_date = $_GET['begin'];
$second_date = $_GET['end'];

if($first_date == "" || $second_date == ""){
    echo "Введите период";
    return;
}

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);

$stmt = $order->read_1($idd,$first_date,$second_date);
$num = $stmt->rowCount();
if ($num>0) {
	$orders_arr=array();
	$orders_arr["records"]=array();
	
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

		extract ($row) ;

	$order_item=array(
		"id" => $id,
        "order_id" => $order_id,
		"product_code" =>$product_code,
		"product_name" =>$product_name,
		"category"=>$category,
		"standard_cost"=>$standard_cost,
        "order_date" => $order_date
	);
array_push ($orders_arr["records"], $order_item);
}
	http_response_code (200) ;
	echo json_encode($orders_arr);

}

else {
	http_response_code (104) ;
	echo json_encode (array ("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
?>