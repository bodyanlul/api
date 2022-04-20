<?php
class Product {

// подключение к базе данных и таблице 'products'
private $conn;

// свойства объекта
public $id;
public $product_code;
public $product_name;
public $standard_cost;
public $category;
 
public function __construct($db) {
	$this->conn = $db;
}

function read_1 () {

$query = 'SELECT
			id, product_code, product_name, category, standard_cost
		FROM
			products
		ORDER BY
			id';


$stmt = $this->conn->prepare($query);

$stmt->execute();

return $stmt;

}

function read_2 ($categ) {

	$query = 'SELECT
				id, product_code, product_name, category, standard_cost
			FROM
				 products 
			WHERE
			    category LIKE :categ 
			ORDER BY
				id';
	

	
	$stmt = $this->conn->prepare($query);
	$stmt->bindValue(':categ', "%$categ%");
	$stmt->execute();
	
	return $stmt;
	
	}
}
?>