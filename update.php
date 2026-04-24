<?php
ob_start();
include 'DBConnector.php';

$student_id                = $_POST['student_id'];
$name                      = $_POST['name'];
$age                       = $_POST['age'];
$email                     = $_POST['email'];
$course                    = $_POST['course'];
$year_level                = $_POST['year_level'];
$graduation_status         = $_POST['graduation_status'];

// handles image
$image_path = $_POST['existing_image'];

if (!empty($_FILES['image']['name'])) {
    $filename   = uniqid('img_', true) . '_' / basename ($_FILES['image']['name']);
    $upload_dir = 'uploads/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename);
    $image_path = $upload_dir . $filename;
}

// update students table
$sql = "UPDATE `students`
        SET `name`='$name', `age`='$age', `email`='$email',
            `course`='$course', `year_level`='$year_level'
        WHERE `id`='$student_id'";

if (conn->query($sql) === TRUE) {

    // update student_files table
    $query = "UPDATE `student_files`
        SET `graduation_status`='$graduation_status', `image_path`='$image_path'
        WHERE `student_id`='$student_id'";

    $conn->query($query);

    ob_end_clean();
    header("Location: edit.php?student_id=$student_id&status=success");
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>