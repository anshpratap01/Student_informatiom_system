<?php
include 'db.php'; // Database Connection

if (isset($_GET['query'])) {
    $search = $conn->real_escape_string($_GET['query']);

    // Student details + Course & Semester fetch karna
    $sql = "SELECT s.StudentID, s.FirstName, s.LastName, s.DOB, s.Gender, 
                   s.ContactNo, s.Address, ar.Course, ar.Year AS Semester 
            FROM students s
            LEFT JOIN academic_records ar ON s.StudentID = ar.StudentID
            WHERE s.FirstName LIKE '%$search%' OR s.LastName LIKE '%$search%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Search Results</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row["StudentID"] . "<br>";
            echo "Name: " . $row["FirstName"] . " " . $row["LastName"] . "<br>";
            echo "DOB: " . $row["DOB"] . "<br>";
            echo "Gender: " . $row["Gender"] . "<br>";
            echo "Course: " . ($row["Course"] ? $row["Course"] : "N/A") . "<br>";
            echo "Semester: " . ($row["Semester"] ? $row["Semester"] : "N/A") . "<br>";
            echo "Contact: " . $row["ContactNo"] . "<br>";
            echo "Address: " . $row["Address"] . "<br><hr>";
        }
    } else {
        echo "No student found!";
    }
}
?>

