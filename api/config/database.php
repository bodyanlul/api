<?php
class Database {

// учетные данные для подключения
private $host = "localhost";
private $db_name = "northwind";
private $username = "root";
private $password = "root";
public $conn;

// создание соединения с БД
public function getConnection() {

	$this->conn = null;

	try {
		$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
		$this->conn->exec("set names utf8");

} catch (PDOException $exception) {
	echo "Connection error: " . $exception->getMessage();
}

	return $this->conn;
	
}

}

?>