<?php
require ROOT . 'controller/CalendarController.php';

class HomeController {
	public function index()
    {
        $calendarController = new CalendarController();
        $calendarController->index();
    }
}