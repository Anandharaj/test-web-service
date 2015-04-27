<?php
	include('student_service.php');

	$instance = new StudentService();

	if ($_GET['type'] === 'getStudentData') {	
		$result = $instance->getStudentData($_GET['student_id']);
		foreach ($result as $key => $value) {
			echo "$key = $value <br>";
		}
		return;
	}
	if ($_POST['data']) {
		var_dump($_POST['data']);
		$data = (array)json_decode($_POST['data']);
		if ($data['type'] === "storeStudentData") {
			echo "store";
		} elseif ($data['type'] === "updateStudentData") {
			echo "update";
		} else {
			echo "string";
		}
	}
	if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
		echo "put";
		return;
	}
	echo 'Unknown Service';
?>