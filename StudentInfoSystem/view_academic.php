<!-- <?php
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

// Fix SQL query by including record_id and year
$sql = "SELECT ar.record_id, CONCAT(s.FirstName, ' ', s.LastName) AS StudentName, 
               ar.Course, ar.year, ar.GPA 
        FROM academic_records ar
        JOIN students s ON ar.StudentID = s.StudentID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>Record ID</th><th>Student Name</th><th>Course</th><th>Year</th><th>GPA</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . (isset($row["record_id"]) ? $row["record_id"] : "N/A") . "</td>
                <td>" . $row["StudentName"] . "</td>
                <td>" . $row["Course"] . "</td>
                <td>" . (isset($row["year"]) ? $row["year"] : "N/A") . "</td>
                <td>" . $row["GPA"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No academic records found.";
}

$conn->close();
?> -->


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

// Fetch academic records including Semester
$sql = "SELECT ar.record_id, CONCAT(s.FirstName, ' ', s.LastName) AS StudentName, 
               ar.Course, ar.year, ar.Semester, ar.GPA 
        FROM academic_records ar
        JOIN students s ON ar.StudentID = s.StudentID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Record ID</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Year</th>
                <th>Semester</th>  <!-- 🔹 Semester Column Added -->
                <th>GPA</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . (isset($row["record_id"]) ? $row["record_id"] : "N/A") . "</td>
                <td>" . $row["StudentName"] . "</td>
                <td>" . $row["Course"] . "</td>
                <td>" . (isset($row["year"]) ? $row["year"] : "N/A") . "</td>
                <td>" . (isset($row["Semester"]) ? $row["Semester"] : "N/A") . "</td>  <!-- 🔹 Display Semester -->
                <td>" . $row["GPA"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No academic records found.";
}

$conn->close();
?>

