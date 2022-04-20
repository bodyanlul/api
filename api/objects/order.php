<?php
class Order {

// подключение к базе данных и таблице 'orders'
private $conn;

// свойства объекта
public $month;
public $id;
public $order_id;
public $product_code;
public $product_name;
public $standard_cost;
public $category;
public $order_date;
public $quantity;
 
public function __construct($db) {
	$this->conn = $db;
}

function read_1 ($id,$fdate,$sdate,$ssets) {
  $splited = split(",",$ssets);
  $param1 = $splited[0];
  $param2 = $splited[1]; 
    if($id != ""){
$query = 'SELECT
             products.id as id,orders.id as order_id, products.product_code as product_code, products.product_name as product_name, products.category as category, products.standard_cost as standard_cost, orders.order_date as order_date
           FROM
             orders INNER JOIN order_details ON orders.id = order_details.order_id INNER JOIN products ON products.id = order_details.product_id
           WHERE
             orders.order_date >= :fdate AND orders.order_date <= :sdate AND products.id = :id
           ORDER BY
           orders.order_date';
    }
     else
     {
      $query = 'SELECT
                   products.id as id,orders.id as order_id, products.product_code as product_code, products.product_name as product_name, products.category as category, products.standard_cost as standard_cost, orders.order_date as order_date
                 FROM
                   orders INNER JOIN order_details ON orders.id = order_details.order_id INNER JOIN products ON products.id = order_details.product_id
                 WHERE
                   orders.order_date >= :fdate AND orders.order_date <= :sdate
                 ORDER BY
                 orders.order_date';
     }      

$stmt = $this->conn->prepare($query);
if($id)
$stmt->bindValue(':id', $id,PDO::PARAM_INT);

$stmt->bindValue(':fdate', $fdate,PDO::PARAM_STR);
$stmt->bindValue(':sdate', $sdate,PDO::PARAM_STR);

$stmt->execute();

return $stmt;

}

function read_2 ($idd,$yearr) {

	$query = 'SELECT
    MONTH(orders.order_date) as month, products.id as id,orders.id as order_id, products.product_code as product_code, products.product_name as product_name, products.category as category, products.standard_cost as standard_cost,order_details.quantity as quantity
  FROM
    orders INNER JOIN order_details ON orders.id = order_details.order_id INNER JOIN products ON products.id = order_details.product_id
  WHERE
    YEAR(orders.order_date) = :yearr AND products.id = :idd
  ORDER BY
  MONTH(orders.order_date)';
	

	$stmt = $this->conn->prepare($query);

	$stmt->bindValue(':idd', $idd,PDO::PARAM_INT);

    $stmt->bindValue(':yearr', $yearr,PDO::PARAM_STR);
	$stmt->execute();
	
	return $stmt;
	
	}
}
?>