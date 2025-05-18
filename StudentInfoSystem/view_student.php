<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_information_system";

// Database connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch students with personal details and academic records
$student_query = "SELECT s.StudentID, s.FirstName, s.LastName, s.Gender, s.Address, s.ContactNo, 
                         ar.Course, ar.Year, ar.Semester, ar.GPA
                  FROM students s
                  LEFT JOIN academic_records ar ON s.StudentID = ar.StudentID
                  GROUP BY s.StudentID";  // 🔹 Duplicate students hataye

$students = $conn->query($student_query);

if (!$students) {
    die("Error fetching students: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
</head>
<body>
    <h2>Student List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Contact</th>
            <th>Course</th>
            <th>Year</th>
            <th>Semester</th>
            <th>GPA</th>
            <th>Action</th>
        </tr>
        <?php
        if ($students->num_rows > 0) {
            while ($row = $students->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['StudentID']}</td>
                        <td>{$row['FirstName']} {$row['LastName']}</td>
                        <td>{$row['Gender']}</td>
                        <td>{$row['Address']}</td>
                        <td>{$row['ContactNo']}</td>
                        <td>" . ($row['Course'] ?? "N/A") . "</td>
                        <td>" . ($row['Year'] ?? "N/A") . "</td>
                        <td>" . ($row['Semester'] ?? "N/A") . "</td>
                        <td>" . ($row['GPA'] ?? "N/A") . "</td>
                        <td>
                            <a href='delete_student.php?id={$row['StudentID']}' onclick='return confirm(\"Are you sure you want to delete this student?\")'>
                                🗑️ Delete
                            </a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No students found</td></tr>";
        }
        ?>
    </table>

    <h2>Go to Student System</h2>
    <a href="index.php">
        <button>Back to Home</button>
    </a>
</body>
</html>

<?php
$conn->close();
?>


