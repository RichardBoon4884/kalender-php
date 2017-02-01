<?php 
	include "db_connection.php";

	$months = ["unknown","januari","februari","maart","april","mei","juni","juli","augustus","september","oktober","november","december"];
	$monthsCount = 0;
	$htmlCalander;

	$stmt = $mysql->prepare("SELECT id, person, day, month, year FROM birthdays ORDER BY month, day, year");
	$stmt->execute();
	$result = $stmt->get_result();

	// $statement = $db->prepare("SELECT id, person, day, month, year FROM birthdays ORDER BY month, day, year");
	// $statement->execute();
	// $result = $statement->get_result();

	if ($result->num_rows > 0) {
		// output data of each row
		// while ($row = $statement->fetch()) {
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