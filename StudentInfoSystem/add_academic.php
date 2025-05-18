
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

// Fetch students for dropdown
$student_query = "SELECT StudentID, FirstName, LastName FROM students";
$students = $conn->query($student_query);

if (!$students) {
    die("Error fetching students: " . $conn->error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentID = $_POST['student_ID'] ?? null;
    $course = $_POST['course'] ?? null;
    $year = $_POST['year'] ?? null;
    $semester = $_POST['semester'] ?? null;
    $gpa = $_POST['gpa'] ?? null;

    // Validate input
    if (!$studentID || !$course || !$year || !$semester || !$gpa) {
        echo "<script>alert('Error: All fields are required!');</script>";
    } else {
        // Check for duplicate academic record
        $check = $conn->prepare("SELECT * FROM academic_records WHERE StudentID = ? AND Course = ? AND Year = ? AND Semester = ?");
        $check->bind_param("ssss", $studentID, $course, $year, $semester);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('❌ This academic record already exists for this student.'); window.location.href='add_academic.php';</script>";
        } else {
            // Insert record
            $stmt = $conn->prepare("INSERT INTO academic_records (StudentID, Course, Year, Semester, GPA) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $studentID, $course, $year, $semester, $gpa);

            if ($stmt->execute()) {
                echo "<script>alert('✅ Academic record added successfully!'); window.location.href='add_academic.php';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $check->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Academic Record</title>
</head>
<body>
    <h2>Add Academic Record</h2>
    
    <form action="add_academic.php" method="POST">
        <label>Select Student:</label>
        <select name="student_ID" required>
            <option value="">Select Student</option>
            <?php
            if ($students->num_rows > 0) {
                while ($row = $students->fetch_assoc()) {
                    echo "<option value='" . $row['StudentID'] . "'>" . $row['FirstName'] . " " . $row['LastName'] . " (ID: " . $row['StudentID'] . ")</option>";
                }
            } else {
                echo "<option value=''>No students found</option>";
            }
            ?>
        </select>

        <input type="text" name="course" placeholder="Course Name" required>
        <input type="number" name="year" placeholder="Year" required>
        <input type="number" name="semester" placeholder="Semester" required>
        <input type="text" name="gpa" placeholder="GPA" required>

        <button type="submit">Add Record</button>
    </form>

    <h2>Go to Student System</h2>
    <a href="dashboard.html">
        <button>Back to Dashboard</button>
    </a>
</body>
</html>
