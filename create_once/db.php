<?php

/* NOTE: Only used once to create database */

// Connection req. fields
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
else {
	echo "Connected Successfully!\n";
}

//Creating a Database through php
$sql= "CREATE DATABASE supermarketms";

// for dropping db
//$sql= "DROP DATABASE supermarketms";

// Check query
if (mysqli_query($conn, $sql)) {
	echo "Database created successfully";
}
else {
	echo "Error: " . mysqli_error($conn);
}

?>