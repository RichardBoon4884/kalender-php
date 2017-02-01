<?php
	$servername = "localhost";
	$username = "kalender";
	$password = "kalender";
	$dbname = "kalender";

	// Create connection
	$mysql = new mysqli($servername, $username, $password, $dbname);
	
	$db = array (
		'host' => 'localhost',
		'dbname' => 'kalender',
		'user' => 'kalender',
		'pass' => 'kalender'
	);

	try
	{
		$db = new PDO('mysql:host='.$db['host'].';dbname='.$db['dbname'], $db['user'], $db['pass']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query("SET SESSION sql_mode = 'ANSI,ONLY_FULL_GROUP_BY'");
	}
	catch(PDOException $e)
	{
		$sMsg = '<p>
				Line: '.$e->getLine().'<br />
				File: '.$e->getFile().'<br />
				Error: '.$e->getMessage().'
			</p>';

		trigger_error($sMsg);
	}
?>