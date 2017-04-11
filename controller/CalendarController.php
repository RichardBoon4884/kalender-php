<?php
require ROOT . 'model/CalendarModel.php';

function index() {
    $htmlCalender = getHtmlList();

    $htmlentities["title"] = "Overview";
    $htmlentities["headAtr"] = "<script>" . getJsCode() . "</script>";

    render("calendar/index", array(
        'htmlentities' => $htmlentities,
        'htmlCalender' => $htmlCalender));
}
function ajaxAdd($person, $day, $month, $year)
{
    $id = addBirthday($person, $day, $month, $year);

    echo "<script>var birthday" . $id . " = new Birthday(" . $id . ", \"" . $person . "\", 
    " . $day . ", " . $month . ", " . $year . ")</script>;";
}

function ajaxEdit($id, $person, $day, $month, $year)
{
    editBirthday($id, $person, $day, $month, $year);

    echo "Sucses";
}
function ajaxDelete($id)
{
    deleteBirthday($id);

    echo "Sucses";
}