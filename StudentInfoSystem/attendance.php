<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance</title>
</head>
<body>
    <h2>Mark Attendance</h2>
    <form action="mark_attendance.php" method="POST">
        <label for="student">Select Student:</label>
        <select name="student_id" required>
            <?php
            include 'db.php';  // Database connection

            // Student list fetch karna
            $sql = "SELECT StudentID, FirstName, LastName, DOB FROM students";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['StudentID']}'>{$row['FirstName']} {$row['LastName']} (DOB: {$row['DOB']})</option>";
                }
            } else {
                echo "<option value=''>No Students Found</option>";
            }
            ?>
        </select>
        
        <label for="date">Date:</label>
        <input type="date" name="date" required>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
        </select>

        <button type="submit">Mark Attendance</button>
    </form>
</body>
</html>
