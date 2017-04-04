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