<?php
	$db_name = 'radovi';
	$dir = "backup/$db_name";
	if (!is_dir($dir)) {
        if (!mkdir($dir, 0777, true)) {
            die("<p>Can not create directory.</p></body></html>");
        }
    }
	$time = time();
	$conn = new mysqli("localhost","root","", $db_name);
	if ($conn -> connect_error) die("<p>Can't connect to db</p>");
	$result = $conn->query('SHOW TABLES');
	if ($result->num_rows > 0) {
		echo "<p>Backup of '$db_name'</p>";
		while (list($table) = $result->fetch_array(MYSQLI_NUM)) {
			$sql = "SELECT * FROM $table";
			$result2 = $conn->query($sql);
			$columns = $result2->fetch_fields();
			if ($result2->num_rows > 0) {
				if ($fp = fopen ("$dir/{$table}_{$time}.txt", 'w')) {
					while ($row = $result2->fetch_array(MYSQLI_NUM)) {
						fwrite($fp, "INSERT INTO $db_name (");
						foreach($columns as $column) {
							fwrite($fp, "$column->name");
							if ($column != end($columns)) {
								fwrite($fp, ", ");
							}
						}
						fwrite($fp, ")\r\nVALUES (");
						foreach ($row as $value) {
							$value = addslashes($value);
							fwrite ($fp, "'$value'");
							if ($value != end($row)) {
								fwrite($fp, ", ");
							} else {
								fwrite($fp, ")\";");
							}
						}
						fwrite ($fp, "\r\n");
					}
					fclose($fp);
					echo "<p>Table $table saved.</p>";
					if ($fp2 = gzopen("$dir/{$table}_{$time}.sql.gz", 'w9')) {
						gzwrite($fp2, file_get_contents("$dir/{$table}_{$time}.txt"));
						gzclose($fp2);
					} else {
						echo "<p>File $dir/{$table}_{$time}.sql.gz can't be open</p>";
						break;						
					}
				} else {
					echo "<p>File $dir/{$table}_{$time}.txt can't be open</p>";
					break;
				}
			}
		}
	} else {
		echo "<p>Db doesn't have any tables.</p>";
	}
	
?>