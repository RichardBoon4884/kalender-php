<?php

function openDb() {
	$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	return $db;
}

function closeDb() {
	return null;
}

function render($filename = null, $data = null)
{
	if ($data) {
		foreach ($data as $key => $value) {
			$$key = $value;
		}
	}
	require(ROOT . 'view/template/header.php');
	if (!empty($filename)) {require(ROOT . 'view/' . $filename . '.php');}
	require(ROOT . 'view/template/footer.php');
	http_response_code(200);
}