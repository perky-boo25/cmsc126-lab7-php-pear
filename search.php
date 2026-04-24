<?php
include 'DBconnector.php';

$student = null;
$error   = null;


// only run search if a student_id was passed
if (isset($_GET['student_id']) && $_GET['student_id'] !== '') {

    $input = $_GET['student_id'];

    // check if input is a valid number (digits only)
    if (!ctype_digit($input)) {

        $error = "Invalid ID. Please enter a number.";

    } else {

        // convert valid input into integer
        $search_id = (int)$input;

        // query student + related file info
        $sql = "SELECT s.*, sf.graduation_status, sf.image_path
                FROM students s
                LEFT JOIN student_files sf ON s.id = sf.student_id
                WHERE s.id = '$search_id'";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {

            // student found
            $student = $result->fetch_assoc();

        } else {

            // no matching student in database
            $error = "No student found with ID: " . $search_id;
        }
    }
}
?>


<?php if ($error): ?>
  <!-- no result found -->
  <div class="msg error"><?= htmlspecialchars($error) ?></div>

<?php elseif ($student): ?>
  <!-- search result only, all students hidden -->

  <h3>Student Found:</h3>

  <!-- card style display-->
  <div class="student-card">
    
    <div class="card-image">
      <?php if (!empty($student['image_path'])): ?>
        <img src="<?= htmlspecialchars($student['image_path']) ?>" alt="Profile">
      <?php else: ?>
        <img src="no_image.png" alt="No Image">
      <?php endif; ?>
    </div>

    <div class="card-info">
      <h3><?= htmlspecialchars($student['name']) ?></h3>
      <p><strong>ID:</strong> <?= $student['id'] ?></p>
      <p><strong>Course:</strong> <?= htmlspecialchars($student['course']) ?></p>
      <p><strong>Year:</strong> <?= $student['year_level'] ?></p>
      <p><strong>Graduating:</strong> <?= !empty($student['graduation_status']) ? 'Yes' : 'No' ?></p>
    </div>

  </div>

<?php endif; ?>