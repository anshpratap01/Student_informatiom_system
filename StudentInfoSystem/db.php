<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Student_Information_System";

// MySQL Connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Connection Check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
