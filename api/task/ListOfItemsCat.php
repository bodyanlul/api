<?php

header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/product.php';

$categoryy = $_GET['category'];
if($categoryy == ""){
    echo "Введите название категории";
    return;
}

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$stmt = $product->read_2($categoryy);
$num = $stmt->rowCount();
if ($num>0) {
	$products_arr=array();
	$products_arr["records"]=array();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

		extract ($row) ;

	$product_item=array(
		"id" => $id,
		"product_code" =>$product_code,
		"product_name" =>$product_name,
		"category"=>$category,
		"standard_cost"=>$standard_cost
	);
array_push ($products_arr["records"], $product_item);
}
	http_response_code (200) ;
	echo json_encode($products_arr);

}

else {
	http_response_code (104) ;
	echo json_encode (array ("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
?>