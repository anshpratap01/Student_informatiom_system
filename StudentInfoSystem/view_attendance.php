<?php
// Enable full error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include DB connection
include 'db.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Attendance Record</title>
    <link rel='stylesheet' href='style.css'>
    <style>
        body {
            padding-top: 80px;
            background: rgba(255, 255, 255, 0.95);
            color: black;
        }
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: white;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
<h2>📅 Attendance Record</h2>";

$sql = "SELECT students.FirstName, students.LastName, attendance.date, attendance.status 
        FROM attendance 
        INNER JOIN students ON attendance.student_id = students.StudentID 
        ORDER BY attendance.date DESC";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<table>
            <tr><th>Student Name</th><th>Date</th><th>Status</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['FirstName']} {$row['LastName']}</td>
                <td>{$row['date']}</td>
                <td>{$row['status']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align:center;'>❌ No attendance records found.</p>";
}

$conn->close();

echo "<p style='text-align:center;'><a href='dashboard.html'>⬅ Back to Dashboard</a></p>";
echo "</body></html>";
?>
