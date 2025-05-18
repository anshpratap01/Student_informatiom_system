
<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    // Check if attendance already exists for this student and date
    $check = $conn->prepare("SELECT * FROM attendance WHERE student_id = ? AND date = ?");
    $check->bind_param("is", $student_id, $date);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('❌ Attendance already marked for this student on this date.'); window.location.href='attendance.php';</script>";
    } else {
        // Insert attendance
        $stmt = $conn->prepare("INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $student_id, $date, $status);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Attendance marked successfully!'); window.location.href='attendance.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $check->close();
    $conn->close();
}
?>

