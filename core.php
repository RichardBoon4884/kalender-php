<?php 
	$months = ["unknown","januari","februari","maart","april","mei","juni","juli","augustus","september","oktober","november","december"];
	$monthsCount = 0;

	$servername = "localhost";
	$username = "kalender";
	$password = "kalender";
	$dbname = "kalender";

	$htmlCalander;

	// Create connection
	$mysql = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($mysql->connect_error) {
		die("Connection failed: " . $mysql->connect_error);
	}

	$sql = "SELECT id, person, day, month, year FROM birthdays ORDER BY month, day, year";
	$result = $mysql->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			while ($row["month"] > $monthsCount) {
				if ($row["month"] > $monthsCount and $row["month"] < 13) {
					$monthsCount++;
					if ($monthsCount == 1) {
						$htmlCalander = "<nav id=\"" . $months[$monthsCount] . "\" class=\"list\"><h2>" . $months[$monthsCount] . "</h2><ul>";
					} elseif ($monthsCount == 12) {
						$htmlCalander .= "</ul></nav><nav id=\"" . $months[$monthsCount] . "\" class=\"list\"><h2>" . $months[$monthsCount] . "</h2><ul>";
					} elseif ($monthsCount > 1 and $monthsCount < 12) {
						$htmlCalander .= "</ul></nav><nav id=\"" . $months[$monthsCount] . "\" class=\"list\"><h2>" . $months[$monthsCount] . "</h2><ul>";
					}
				}
			}
			
			if ($row["month"] == $monthsCount) {
				$htmlCalander .= "<li class=\"box\" id=\"" . $row["id"] . "\"><h3>" . $row["person"]. "</h3> " . $row["day"]. " " . $months[$monthsCount] . " " . $row["year"]. "</li>";
				// echo "Id:" . $row["id"] . " Name:" . $row["person"]. " Day:" . $row["day"]. " " . $months[$row["month"]] . " (" . $monthsCount . ") " . $row["year"]. "<br>";
			}
		}
	}
	while ($monthsCount < 12) {
		$monthsCount++;
		if ($monthsCount == 1) {
			$htmlCalander .= "<nav id=\"" . $months[$monthsCount] . "\" class=\"list\"><h2>" . $months[$monthsCount] . "</h2><ul>";
		} elseif ($monthsCount == 12) {
			$htmlCalander .= "</ul></nav><nav id=\"" . $months[$monthsCount] . "\" class=\"list\"><h2>" . $months[$monthsCount] . "</h2><ul>";
		} else {
			$htmlCalander .= "</ul></nav><nav id=\"" . $months[$monthsCount] . "\" class=\"list\"><h2>" . $months[$monthsCount] . "</h2><ul></ul></nav>";
		}
	}

	?>