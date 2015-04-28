<?php
/**
* 
*/
class DatabaseService {
	private $hostname = 'localhost';
	private $username = 'root';
	private $dbname = 'mydb';
	private $password = '';
	private $conn = null;

	function __construct() {
		$this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
		if ($this->conn->error) {
			die("Connection Failed");
		}
	}

	public function getStudentDetails($id) {
		$sql = "select * from student_info where student_id=$id LIMIT 1";		
		return $this->conn->query($sql);
	}

	public function storeStudentDetails($columns, $values) {
		$sql = "insert into student_info($columns) values($values)";
		return $this->conn->query($sql);
	}

	public function updateStudentDetails($columnsValues, $id) {
		$sql = "update student_info set $columnsValues where student_id=$id";
		return $this->conn->query($sql);
	}
	
	public function getLastStudentData($column) {
		$sql = "select $column from student_info order by student_id desc LIMIT 1";
		return $this->conn->query($sql);
	}

	public function deleteStudentDetails($id) {
		$sql = "delete from student_info where student_id=$id";
		return $this->conn->query($sql);
	}

	function __destruct() {
		$this->conn->close();
	}
}
?>