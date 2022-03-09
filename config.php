<?php 
	session_start();// start user session
	// connect to database
	$conn = mysqli_connect("localhost", "root", "orange", "blog");
	if (!$conn) {

		die("Error connecting to database: " . mysqli_connect_error());
	}
    // define global constants : you might change those globals
	define ('ROOT_PATH', realpath(dirname(__FILE__)));
	define('BASE_URL', 'http://localhost:8000/');
?>
