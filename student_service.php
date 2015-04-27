<?php
	include('DB_Services.php');
	/**
	* 
	*/
	class StudentService
	{
		private $db;

		function __construct() {
			$this->db = new DatabaseService();			
		}

		public function getStudentData($id) {
			return mysqli_fetch_assoc($this->db->getStudentDetails($id));
		}

		public function storeStudentData($data) {
			$data = (array)json_decode($data);
			$columns = "student_id";
			$values = (integer)mysqli_fetch_assoc($this->db->getLastStudentData($columns))[$columns];
			$values = ++$values;
			foreach ($data['student'] as $key => $value) {
				$columns = "$columns, $key";
				$values = "$values, '$value'";
			}
			return $this->db->storeStudentDetails($columns, $values);
		}
		public function updateStudentData($data) {
			$data = (array)json_decode($data);
			$id = $data['student']->student_id;
			
		}
	}
?>