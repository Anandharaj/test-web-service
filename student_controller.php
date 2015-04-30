<?php
	// echo $_SERVER['REQUEST_METHOD'];
	// parse_str(file_get_contents("php://input"),$put_vars);
	// // echo $put_vars['type'];
	// var_dump($put_vars);
	// return;

	include('student_service.php');

	$instance = new StudentService();
	
	switch ($_SERVER['REQUEST_METHOD']) {
		case 'GET':
			if (!isset($_GET["student_id"]) && !isset($_GET["type"])) {
				die('Parameters is missing');
			}

			switch ($_GET['type']) {
				case 'getStudentData':
					$result = null;
					if (isset($_GET['student_id'])) {
						$result = $instance->getStudentData($_GET['student_id']);
					} else {
						$result = $instance->getStudentData(null);
					}
					if (!$result) {
						die('Record not found..!');
					}
					foreach ($result as $key => $value) {
						echo "$key = $value <br>";
					}
					return;
					break;

				case 'deleteStudentData':
					if (!$instance->deleteStudentData($_GET['student_id'])) {
						die('Record Deletion Failed');
					}
					echo 'Record Deleted..!';
					return;
					break;
				
				default:
					echo 'Wrong Operation...!';
					break;
			}
			break;
		
		case 'POST':
			if (!$_POST['data']) { 
				die('Post Data is Missing...!');
			}
			$data = (array)json_decode($_POST['data']);
			switch ($data['type']) {
				case 'storeStudentData':
					if(!$instance->storeStudentData($data)) {
						die('Record insertion failed...!');
					}
					echo 'Record inserted..!';
					break;

				case 'updateStudentData':
					if (!$instance->updateStudentData($data)) {
						die('Record Updation failed...!');
					}
					echo 'Record Updated..!';
					break;

				default:
					echo 'Wrong Post Data...!';
					break;
			}	
			break;

		default:
			echo "Unknown Service...!";
			break;
	}

	// if (!isset($_REQUEST['type'])) {
	// 	die("Unknown Request");
	// 	return;
	// }

	// if ($_REQUEST['type'] == "studentData") {
		
	// 	// GET
	// 	if ($_SERVER['REQUEST_METHOD'] == "GET") {
	// 		if (isset($_GET['method']) && $_GET['method'] == "delete") {
	// 			//  delete opt
	// 		}

	// 		if (isset($_GET['id'])) {
	// 			// get details for id
	// 			return;
	// 		}

	// 		// get all details

	// 	}

	// 	// POST
	// 	if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['data'])) {

	// 	}
	// }

?>