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

		public function setData($post_data) {
			$data = (array)$post_data->student;
			$data['student_id'] = 1002;
			// $this->mysql->find_last($this->tablename, "student_id");
			if (!$this->mysql->insert($this->tablename, $data)){
				echo "Zero Record Updated...!";
				return;
			}
			echo "Record Updated...!";
		}

		public function getData($post_data) {
			$search_key = null;
			$i = 0;
			foreach ($post_data->search_key as $key => $value) {
				$search_key[$i++] = $key ."='". $value . "'";	
			}

			$column_names = sizeof((array)$post_data->columns) > 1 ? (array)$post_data->columns : $post_data->columns;
			$result = $this->mysql->find($this->tablename, $post_data->columns, $search_key[0]);
			if(!$result) {
				echo $result;
			} else {
				echo json_encode(mysqli_fetch_assoc($result));
			}

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
		$operation = $student_info->operation;
		$std_obj = new StudentInfo();
		if($operation === "insert") {
			$std_obj->connection();
			$std_obj->setData($student_info);
		} else if($operation === "select") {
			$std_obj->connection();
			$std_obj->getData($student_info);
		} else {
			echo "Specified Wrong Operation...!";
		}
	}	
?>