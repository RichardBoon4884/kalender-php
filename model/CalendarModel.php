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

function addBirthdays($day, $month, $year) {
    try {
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

        $sth->fetchAll();

        $db = closeDb();

        if ($succes == true) {
            return $lastId;
        } else {
            return false;
        }
    }
    catch(PDOException $e)
    {
        exit($e->getMessage());
        return 0;

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
                $htmlCalender .= "<li class=\"box\" id=\"birthday-" . $birthday["id"] . "\"><h3>" . $birthday["person"]. "</h3> <a href=\"#\" onclick=\"birthday" . $birthday["id"] . ".edit()\" >(edit)</a> " . $birthday["day"]. " " . $months[$monthsCount] . " " . $birthday["year"]. "</li>";
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