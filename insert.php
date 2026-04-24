<?php
ob_start();             // buffer output so DBconnector's echo doesn't break header()
include 'DBconnector.php';

$name              = $_POST["name"];
$age               = $_POST["age"];
$email             = $_POST["email"];
$course            = $_POST["course"];
$year_level        = $_POST["year_level"];
$graduation_status = $_POST["graduation_status"];

// handles image upload
$image_path = null;

if (!empty($_FILES['image']['name'])) {
    $filename   = uniqid('img_', true) . '_' . basename($_FILES['image']['name']);
    $upload_dir = 'uploads/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename);
    $image_path = $upload_dir . $filename;
}

// insert into students
$sql = "INSERT INTO `students` (`name`, `age`, `email`, `course`, `year_level`)
        VALUES ('$name', '$age', '$email', '$course', '$year_level');";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;    // ID of the newly inserted student

    // insert into student_files (linked by student_id)
    $query = "INSERT INTO `student_files` (`student_id`, `graduation_status`, `image_path`)
              VALUES ('$last_id', '$graduation_status', '$image_path');";
    $conn->query($query);

    ob_end_clean();     
    header("Location: index.php?status=success");

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>