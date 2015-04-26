<?php
	include('curd_lib.php');
	/**
	* 
	*/
	class StudentInfo extends MySqlLib {
		var $host = 'localhost';
		var $username = 'root';
		var $password = '';
		var $database = 'mydb';
		var $tablename = 'student_info';
		var $connection_obj = null;
		var $mysql = null;
		function __construct() {
			$this->mysql = new MySqlLib();
			$this->mysql->connectDB($this->host, $this->username, $this->password, $this->database);
		}

		public function connection() {
			$this->connection_obj = $this->mysql->conn;
		}

		public function storeStudent($post_data) {
			$data = (array)$post_data->student;
			$result = $this->mysql->find_last($this->tablename, "student_id");
			$id = (integer)mysqli_fetch_assoc($result)["student_id"];
			$data['student_id'] = ++$id;
			if (!$this->mysql->insert($this->tablename, $data)){
				echo "Zero Record Updated...!";
				return;
			}
			echo "Record Updated...!";
		}

		public function getStudent($post_data) {
			$search_key = null;
			$i = 0;
			foreach ($post_data->search_key as $key => $value) {
				$search_key[$i++] = $key ."='". $value . "'";	
			}
			$column_names = sizeof((array)$post_data->columns) > 1 ? (array)$post_data->columns : $post_data->columns;
			$result = $this->mysql->find($this->tablename, $column_names, $search_key[0]);
			if(!$result) {
				echo $result;
				return;
			}
			echo json_encode(mysqli_fetch_assoc($result));
		}

		function __destruct() {
			$this->connection_obj->close();
		}

	}
	if ($_SERVER['REQUEST_METHOD'] === "POST") {
		if (!$_POST['data']) {
			die("Need post Data...!"); 
		}
		$student_info = json_decode($_POST['data']);
		$std_obj = new StudentInfo();
		$std_obj->connection();
		$std_obj->storeStudent($student_info);
	}
	if ( $_SERVER['REQUEST_METHOD'] === "GET" ) {
		if(!$_GET['data']) {
			die("Need get Data...!"); 	
		}
		$student_info = json_decode($_GET['data']);
		$std_obj = new StudentInfo();
		$std_obj->connection();
		$std_obj->getStudent($student_info);
	}
?>