<?php
	class MySqlLib{
		public $conn;
		function __contruct() {

		}
		// Connect Operation function call is used to connect Database parameters $host type(string), $username type(string), $password type(string) and $dbname type(string)
		public function connectDB($host, $username, $password, $dbname) {
			$conn = new mysqli($host, $username, $password, $dbname);
			if ($conn->connect_error) {
				die($conn->connect_error);
			} else {
				$this->conn = $conn;
			}
		}
		// columnGenerator function call is form the columns values. Parameter $columns type(array)
		private function columnGenerator($columns) {
			$columnsValues = "";
			if(is_array($columns)) {
				foreach ($columns as $key => $value) {
					$columnsValues = " $key $value," . $columnsValues;
				} 
				$columnsValues = trim($columnsValues, ",");
			}	else {
				echo "<br>Err-> Needs Array type Value...!";
			}
			return $columnsValues;
		}
		// Create Operation function call parameters tableName type(string) and $columns type(array)
		public function create($tableName, $columns) {
			$query = "create table " . $tableName . "(" . $this->columnGenerator($columns) . ")";
			if($this->conn->query($query) === TRUE) {
				return true;			
			} else {
				echo "Err-> $this->conn->error";
			}
		}

		// Insert Operation function call parameters tableName type(string) and $data type(array)
		public function insert($tableName, $data) {
			$columnNames = "";
			$values = "";
			if ($tableName && $data) {
				foreach ($data as $key => $value) {
					$columnNames = " $key," . $columnNames;
					$values = " '$value'," . $values;
				}
				$columnNames = trim($columnNames, ",");
				$values = trim($values, ",");
				$query = "insert into " . $tableName . " (" . $columnNames . ") " . "values (" . $values . ")";
				if ($this->conn->query($query) === TRUE) {
					return true;
				} else {
					echo "<br>Err->" . $this->conn->error;
				}
			}
		}

		// Update Operation function call parameters tableName type(string), $field_changes type(string) or type(Array) and $condition type(string)
		public function update($tableName, $fields_changes, $condition) {
			$query = "update " . $tableName . " set " . $fields_changes . " where " .$condition;
			if ($this->conn->query($query) === TRUE) {
				return true;
			} else {
				echo "<br>Err->" . $this->conn->error;
			}
			return null;
		}

		// Find Operation function call parameters tableName type(string), $columnName type(string) or type(Array) and $condition type(string)
		public function find($tableName, $columnName, $condition) {
			$temp = null;
			if(is_array($columnName)) {
				for ($i = 0; $i < sizeof($columnName); $i++) {
					$temp = $temp . ", " . $columnName[$i];
				}
				$columnName = (string) trim($temp, ", ");
			}
			if ($condition) {
				$query = "select " . $columnName . " from " . $tableName . " where " . $condition;
			} else {
				$query = "select " . $columnName . " from " . $tableName;
			}
			$result = $this->conn->query($query);
			if ($result->num_rows > 0) {
				return $result;
			} 
			return null;
		}

		// Delete Operation function call parameters tableName type(string) and condition type(string)
		public function delete($tableName, $condition) {
			$query = "delete from " . $tableName . " where " . $condition;
			if ($this->conn->query($query) === TRUE) {
				echo "<br>One Row Deleted...!";
			} else {
				echo "<br>Err->" . $this->conn->error;
			}
		}	
		public function find_last($tableName, $columnName) {
			$query = "select last($columnName) from $tableName";
			$result = $this->conn->query($query);
			// if ($result) {
			// 	echo "";
			// } else {
			// 	echo "<br>Err->" . $this->conn->error;
			// }
		}
		// Drop Operation function call parameters $type type(string) specifies whether it is Table or Database and $name type(string) specifies the name of the table or database 
		public function drop($type, $name) {
			$query = "drop " . $type . " " . $name;
			if ($this->conn->query($query) === TRUE) {
				echo "<br>$type Dropped...!";
			} else {
				echo "<br>Err->" . $this->conn->error;
			}
		}

		// Truncate Operation function call parameters $tableName type(string)
		public function truncate($tableName) {
			$query = "truncate table " . $tableName;
			if ($this->conn->query($query) === TRUE) {
				echo "<br>Table Truncated...!";
			} else {
				echo "<br>Err->" . $this->conn->error;
			}
		}

		// close Operation function call To close the current connection of Database
		public function close() {
			$this->conn->close();
		}
	}
?>