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

function read_1 ($id,$fdate,$sdate,$sort_categ,$sort_date) {
    if($id != "" && ($sort_categ == "" && $sort_date =="")){
$query = 'SELECT
             products.id as id,orders.id as order_id, products.product_code as product_code, products.product_name as product_name, products.category as category, products.standard_cost as standard_cost, orders.order_date as order_date
           FROM
             orders INNER JOIN order_details ON orders.id = order_details.order_id INNER JOIN products ON products.id = order_details.product_id
           WHERE
             orders.order_date >= :fdate AND orders.order_date <= :sdate AND products.id = :id';
    }
    if($id != "" && ($sort_categ == 1 && $sort_date ==""))
     {
      $query = 'SELECT
                   products.id as id,orders.id as order_id, products.product_code as product_code, products.product_name as product_name, products.category as category, products.standard_cost as standard_cost, orders.order_date as order_date
                 FROM
                   orders INNER JOIN order_details ON orders.id = order_details.order_id INNER JOIN products ON products.id = order_details.product_id
                 WHERE
                   orders.order_date >= :fdate AND orders.order_date <= :sdate AND products.id = :id
                 ORDER BY
                 products.category';
     }
     if($id != "" && ($sort_categ == "" && $sort_date ==1))
     {
      $query = 'SELECT
                   products.id as id,orders.id as order_id, products.product_code as product_code, products.product_name as product_name, products.category as category, products.standard_cost as standard_cost, orders.order_date as order_date
                 FROM
                   orders INNER JOIN order_details ON orders.id = order_details.order_id INNER JOIN products ON products.id = order_details.product_id
                 WHERE
                   orders.order_date >= :fdate AND orders.order_date <= :sdate AND products.id = :id
                 ORDER BY
                 orders.order_date';
     }
     if($id != "" && ($sort_categ == 1 && $sort_date ==1))
     {
      $query = 'SELECT
                   products.id as id,orders.id as order_id, products.product_code as product_code, products.product_name as product_name, products.category as category, products.standard_cost as standard_cost, orders.order_date as order_date
                 FROM
                   orders INNER JOIN order_details ON orders.id = order_details.order_id INNER JOIN products ON products.id = order_details.product_id
                 WHERE
                   orders.order_date >= :fdate AND orders.order_date <= :sdate AND products.id = :id
                 ORDER BY
                 orders.order_date, products.category';
     }
     if($id == "" && ($sort_categ == "" && $sort_date ==""))
     {
      $query = 'SELECT
                   products.id as id,orders.id as order_id, products.product_code as product_code, products.product_name as product_name, products.category as category, products.standard_cost as standard_cost, orders.order_date as order_date
                 FROM
                   orders INNER JOIN order_details ON orders.id = order_details.order_id INNER JOIN products ON products.id = order_details.product_id
                 WHERE
                   orders.order_date >= :fdate AND orders.order_date <= :sdate';
     }
     if($id == "" && ($sort_categ == 1 && $sort_date ==""))
     {
      $query = 'SELECT
                   products.id as id,orders.id as order_id, products.product_code as product_code, products.product_name as product_name, products.category as category, products.standard_cost as standard_cost, orders.order_date as order_date
                 FROM
                   orders INNER JOIN order_details ON orders.id = order_details.order_id INNER JOIN products ON products.id = order_details.product_id
                 WHERE
                   orders.order_date >= :fdate AND orders.order_date <= :sdate
                 ORDER BY
                 products.category';
     }
     if($id == "" && ($sort_categ == "" && $sort_date ==1))
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
     if($id == "" && ($sort_categ == 1 && $sort_date ==1))
     {
      $query = 'SELECT
                   products.id as id,orders.id as order_id, products.product_code as product_code, products.product_name as product_name, products.category as category, products.standard_cost as standard_cost, orders.order_date as order_date
                 FROM
                   orders INNER JOIN order_details ON orders.id = order_details.order_id INNER JOIN products ON products.id = order_details.product_id
                 WHERE
                   orders.order_date >= :fdate AND orders.order_date <= :sdate
                 ORDER BY
                 orders.order_date,products.category';
     }                     
    
// nomrororKa sanpoca
$stmt = $this->conn->prepare($query);
if($id)
$stmt->bindValue(':id', $id,PDO::PARAM_INT);

$stmt->bindValue(':fdate', $fdate,PDO::PARAM_STR);
$stmt->bindValue(':sdate', $sdate,PDO::PARAM_STR);

// wunomisem sampoc
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
	

	// nomrororKa sanpoca
	$stmt = $this->conn->prepare($query);

	$stmt->bindValue(':idd', $idd,PDO::PARAM_INT);

    $stmt->bindValue(':yearr', $yearr,PDO::PARAM_STR);
	// wunomisem sampoc
	$stmt->execute();
	
	return $stmt;
	
	}
}
?>