<?php
include 'db.php'; // Database Connection

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Pehle academic_records table se delete karein (Agar StudentID wahan hai)
    $sql1 = "DELETE FROM academic_records WHERE StudentID = '$student_id'";
    $conn->query($sql1);

    // Ab main students table se delete karein
    $sql2 = "DELETE FROM students WHERE StudentID = '$student_id'";
    
    if ($conn->query($sql2) === TRUE) {
        echo "<script>
                alert('Student deleted successfully!');
                window.location.href = 'view_students.php';
              </script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}
?>
