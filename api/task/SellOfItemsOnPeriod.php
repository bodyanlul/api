<?php

// Heo6xonyuMEe HTTP-saronoBKn

header ("Access-Control-Allow-Origin: *");
header ("Content-Type: application/json; charset=UTF-8");

// noaKmmueHve G6asbl WaHHEIX Uu dain, conepxkammi oObeKTEL
include_once '../config/database.php';
include_once '../objects/order.php';

$idd = $_GET['id'];
$first_date = $_GET['begin'];
$second_date = $_GET['end'];
$sort_categ = $_GET['sort_category'];
$sort_date = $_GET['sort_date'];

if($first_date == "" || $second_date == ""){
    echo "Введите период";
    return;
}

if(($sort_categ != "" && $sort_categ != 1) || ($sort_date !="" && $sort_date != 1)){
	echo "Неправильно заданы параметры сортировки";
	return;
}

// Tlomyuaem coequHeHVe c 6as0% TaHHEIX
$database = new Database();
$db = $database->getConnection();

// weuunanmsupyeM o6beKT
$order = new Order($db);

// 3ampalmBaem TOBapsi
$stmt = $order->read_1($idd,$first_date,$second_date,$sort_categ,$sort_date);
$num = $stmt->rowCount();
if ($num>0) {

	// maccus ToRapoB
	$orders_arr=array();
	$orders_arr["records"]=array();
	// nomyuaem cozepxumoe Hale TaOmMuEI
	// fetch() Oucrpee, vem fetchAll()
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

		// wspnexaem cxpoxy
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
	// yovavannupaem Kom ompera - 200 OK
	http_response_code (200) ;
	// BBIBOIMM WaHHEIe O TOBape B dopmate JSON
	echo json_encode($orders_arr);

}

else {
	// yovavonmm xox orpeta - 404 He uatigeno
	http_response_code (104) ;
	// coobmaem nombecnatenm, ¥TO TORapy He HalineHE
	echo json_encode (array ("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
?>