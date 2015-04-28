<!doctype html>
<html>
<head>
	<title>Student Information System</title>
	<script type="text/javascript" src="jquery-2.1.3.min.js"></script>
</head>
<body>
	<h1>Student Information System</h1>
	<form>
		<ul>	
			<li>
				<input type="text" name="student_name" id="student_name" placeholder="Name"/>
			</li>
			<li>
				<input type="txt" name="student_department" id="student_department" placeholder="Department"/>
			</li>
			<li>
				<input type="number" min="18" max="28" name="student_age" id="student_age" placeholder="Age"/>
			</li>
			<li>
				<input type="text" name="student_address" id="student_address" placeholder="Address"/>
			</li>
			<li>
				<input type="text" name="student_blood_group" id="student_blood_group" placeholder="Blood Group"/>
			</li>
		</ul>
	</form>
	<button onclick="registerDetails()">Register</button>
</body>
<script type="text/javascript">
	var registerDetails = function() {
		var errorMsg = "";
		var elements = $("input");
		for (i = 0; i < elements.length; i++) {
			if (elements[i].value === "") {
				errorMsg = errorMsg + " " + elements[0].placeholder;
			}
		}
		if (errorMsg === '') {
			alert('These fields need to be filled up' + )
		}
	}
</script>
</html>