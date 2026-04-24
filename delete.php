<?php
include 'DBconnector.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['student_id'])) {

  $id = (int) $_POST['student_id'];

  // check if student exists
  $check = $conn->prepare("SELECT id FROM students WHERE id = ?");
  $check->bind_param("i", $id);
  $check->execute();
  $check->store_result();

  $exists = $check->num_rows > 0;
  $check->close();

  if (!$exists) {
    header("Location: index.php?status=not_found");
    exit;
  }

  // delete related files first
  $delFiles = $conn->prepare("DELETE FROM student_files WHERE student_id = ?");
  $delFiles->bind_param("i", $id);
  $delFiles->execute();
  $delFiles->close();

  // delete student
  $delStud = $conn->prepare("DELETE FROM students WHERE id = ?");
  $delStud->bind_param("i", $id);
  $success = $delStud->execute();
  $delStud->close();

  if ($success) {
    header("Location: index.php?status=deleted");
  } else {
    header("Location: index.php?status=error");
  }

} else {
  header("Location: index.php?status=error");
}

$conn->close();
?>