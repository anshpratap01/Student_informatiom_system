 <?php
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $contact_no = $_POST['contact_no'];
    $address = $_POST['address'];

    // 🔍 Check if student with same contact number already exists
    $check_sql = "SELECT * FROM students WHERE ContactNo = ?";
    $stmt_check = $conn->prepare($check_sql);
    $stmt_check->bind_param("s", $contact_no);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('❌ Error: Student with this contact number already exists!'); window.location.href='index.html';</script>";
    } else {
        // ✅ Insert the student
        $sql = "INSERT INTO students (FirstName, LastName, DOB, Gender, ContactNo, Address) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $first_name, $last_name, $dob, $gender, $contact_no, $address);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Student Added Successfully!'); window.location.href='index.html';</script>";
        } else {
            echo "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    }

    $stmt_check->close();
}

$conn->close();
?>
