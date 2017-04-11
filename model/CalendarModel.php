<?php

function getAllBirthdays() {
    $db = openDb();
    $sth = $db->prepare("SELECT id, person, day, month, year FROM birthdays ORDER BY month, day, year");
    $sth->execute();

    $result = $sth->fetchAll();
    $db = closeDb();
    return $result;
}

function getBirthday($id) {
    $db = openDb();

    $sth = $db->prepare("SELECT id, person, day, month, year FROM birthdays WHERE :requestedAppointment LIMIT 1");
    $sth->bindParam(':requestedAppointment', $id, PDO::PARAM_STR);

    $sth->execute();

    $result = $sth->fetchAll();
    $result = $result[0];
    $db = closeDb();
    return $result;
}

function addBirthday($person, $day, $month, $year) {
    $db = openDb();
    $sth = $db->prepare("INSERT INTO birthdays (
        `person`,
        `day`,
        `month`,
        `year`)
        VALUES (
        :person,
        :day,
        :month,
        :year)");
    $sth->bindParam(':person', $person);
    $sth->bindParam(':day', $day);
    $sth->bindParam(':month', $month);
    $sth->bindParam(':year', $year);

    $succes = $sth->execute();

    $lastId = $db->lastInsertId();

    $db = closeDb();

    if ($succes == true) {
        return $lastId;
    } else {
        return false;
    }
}
function editBirthday($id, $person, $day, $month, $year) {
    $db = openDb();
    $sth = $db->prepare("UPDATE birthdays SET
        `person` = :person,
        `day` = :day,
        `month` = :month,
        `year` = :year
        WHERE id = :id");
    $sth->bindParam(':person', $person);
    $sth->bindParam(':day', $day);
    $sth->bindParam(':month', $month);
    $sth->bindParam(':year', $year);
    $sth->bindParam(':id', $id);

    $succes = $sth->execute();

    $lastId = $db->lastInsertId();

    $db = closeDb();

    if ($succes == true) {
        return true;
    } else {
        return false;
    }
}
function deleteBirthday($id) {
    $db = openDb();
    $sth = $db->prepare("DELETE FROM birthdays WHERE id = :id");
    $sth->bindParam(':id', $id);

    $succes = $sth->execute();

    $lastId = $db->lastInsertId();

    $db = closeDb();

    if ($succes == true) {
        return true;
    } else {
        return false;
    }
}
function getHtmlList()
{
    $months = ["unknown","januari","februari","maart","april","mei","juni","juli","augustus","september","oktober","november","december"];
    $monthsCount = 0;
    $birthdays = getAllBirthdays();
    $htmlCalender;

    if (count($birthdays) > 0) {
        // output data of each row
        // while ($row = $statement->fetch()) {
        foreach ($birthdays as $birthday) {
            while ($birthday["month"] > $monthsCount) {
                if ($birthday["month"] > $monthsCount and $birthday["month"] < 13) {
                    $monthsCount++;
                    if ($monthsCount == 1) {
                        $htmlCalender = "<nav id=\"month-" . $monthsCount . "\" class=\"list\"><h2>" . $months[$monthsCount] . "</h2><ul>";
                    } elseif ($monthsCount == 12) {
                        $htmlCalender .= "</ul></nav><nav id=\"month-" . $monthsCount . "\" class=\"list\"><h2>" . $months[$monthsCount] . "</h2><ul>";
                    } elseif ($monthsCount > 1 and $monthsCount < 12) {
                        $htmlCalender .= "</ul></nav><nav id=\"month-" . $monthsCount . "\" class=\"list\"><h2>" . $months[$monthsCount] . "</h2><ul>";
                    }
                }
            }

            if ($birthday["month"] == $monthsCount) {
                $htmlCalender .= "<li class=\"box\" id=\"birthday-" . $birthday["id"] . "\"><h3>" . $birthday["person"]. "</h3> <span class=\"button\">(edit)</span> " . $birthday["day"]. " " . $months[$monthsCount] . " " . $birthday["year"]. "</li>";
            }
        }
    }
    while ($monthsCount < 12) {
        $monthsCount++;
        if ($monthsCount == 1) {
            $htmlCalender .= "<nav id=\"month-" . $monthsCount . "\" class=\"list\"><h2>" . $months[$monthsCount] . "</h2><ul>";
        } elseif ($monthsCount == 12) {
            $htmlCalender .= "</ul></nav><nav id=\"month-" . $monthsCount . "\" class=\"list\"><h2>" . $months[$monthsCount] . "</h2><ul>";
        } else {
            $htmlCalender .= "</ul></nav><nav id=\"month-" . $monthsCount . "\" class=\"list\"><h2>" . $months[$monthsCount] . "</h2><ul></ul></nav>";
        }
    }

    return $htmlCalender;
}

function getJsCode()
{
    $jsCode = null;

    foreach (getAllBirthdays() as $birthday) {
        $jsCode .= "var birthday" . $birthday["id"] . " = new Birthday(" . $birthday['id'] . ", \"" . $birthday['person'] . "\", " . $birthday['day'] . ", " . $birthday['month'] . ", " . $birthday['year'] . ");";
    }

    return $jsCode;
}