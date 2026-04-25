<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Registration</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Student Registration</h1>

  <?php
  include 'DBConnector.php';


  // shows the feedback after redirect from insert.php
  if (!empty($_GET['status'])) {
    if ($_GET['status'] === 'success') {
      echo '<div class="msg success">Student registered successfully!</div>';
    } elseif ($_GET['status'] === 'duplicate_email') {
      echo '<div class="msg error">That email is already registered.</div>';
    } else {
      echo '<div class="msg error">Something went wrong. Please try again.</div>';
    }
  }
  
  // fetch all students for the table display
  $all_students = null;
  $all_sql      = "SELECT s.*, sf.graduation_status, sf.image_path
                  FROM `students` s
                  LEFT JOIN `student_files` sf ON s.id = sf.student_id;";
  $all_result   = $conn->query($all_sql);

  if ($all_result && $all_result->num_rows > 0) {
      // fetch all rows into an array
      $all_students = $all_result->fetch_all(MYSQLI_ASSOC);
  }
    ?>

  <br>
  <h3>New Student:</h3>
  <form action="insert.php" method="post" enctype="multipart/form-data">
    <table>
      <tr>
        <td class="tlabel">Name</td>
        <td><input type="text" name="name" maxlength="40" placeholder="Juan J. dela Cruz" required></td>
      </tr>
      <tr>
        <td class="tlabel">Age</td>
        <td><input type="number" name="age" min="0" max="99" placeholder="0-99" required></td>
      </tr>
      <tr>
        <td class="tlabel">Email</td>
        <td><input type="email" name="email" maxlength="40" placeholder="jjdelacruz@up.edu.ph" required></td>
      </tr>
      <tr>
        <td class="tlabel">Course</td>
        <td><input type="text" name="course" maxlength="40" placeholder="BS Computer Science" required></td>
      </tr>
      <tr>
        <td class="tlabel">Year Level</td>
        <td>
          <select name="year_level" required>
            <option value="" disabled selected>-- Select Year --</option>
            <option value="1">1st Year</option>
            <option value="2">2nd Year</option>
            <option value="3">3rd Year</option>
            <option value="4">4th Year</option>
          </select>
        </td>
      </tr>
      <tr>
        <td class="tlabel">Graduating?</td>
        <td>
          <input type="radio" name="graduation_status" value="1" required> Yes<br>
          <input type="radio" name="graduation_status" value="0"> No
        </td>
      </tr>
      <tr>
        <td class="tlabel">Profile Image</td>
        <td>
          <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.webp"><br>
          <small style="opacity:.75">JPG, PNG, GIF, WEBP accepted</small>
        </td>
      </tr>

      <tr>
        <td class="tlabel"></td>
        <td><br><input type="submit" value="Register Student"></td>
      </tr>
    </table>
  </form>

  <div class="records">
  <h2>Record Management</h2>
  <p><b>Look Up by Student ID</b></p>

  <input type="text" id="student_id_input" placeholder="Enter Student ID">

  <!--TODO: Search function, add filename inside quotations in form action -->
  <form action="index.php" method="get" style="display:inline;">
    <input type="hidden" name="student_id" id="search_id">
     <input type="submit" value="Search" onclick="
     if (document.getElementById('student_id_input').value.trim() === '') {
      alert('Please enter a Student ID.');
      return false;
    }
    document.getElementById('search_id').value = document.getElementById('student_id_input').value;
  ">
  </form>

<!--TODO: Update the info, add filename inside quotations in form action -->
  <form action="edit.php" method="get" style="display:inline;">
    <input type="hidden" name="student_id" id="update_id">
    <input type="submit" value="Update" onclick="document.getElementById('update_id').value = document.getElementById('student_id_input').value">
  </form>

  <form action="delete.php" method="post" style="display:inline;">
    <input type="hidden" name="student_id" id="delete_id">
    <input type="submit" value="Delete" onclick="document.getElementById('delete_id').value = document.getElementById('student_id_input').value">
  </form>
</div>
<a href = "index.php"> ← Back </a>
<div id="all-students">


<?php if (isset($_GET['student_id']) && $_GET['student_id'] !== ''): ?>

  <!-- search result only, all students hidden -->
  <?php include 'search.php'; ?>

<?php else: ?>

  <!-- no search made, show all students -->
  <h3>All Students:</h3>

  <?php if ($all_students): ?>
    <div class="card-container">
      <?php foreach ($all_students as $row): ?>
        <div class="student-card">
          
          <div class="card-image">
            <?php if (!empty($row['image_path'])): ?>
              <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Profile">
            <?php else: ?>
              <img src="no_image.png" alt="No Image">
            <?php endif; ?>
          </div>

          <div class="card-info">
            <h3><?= htmlspecialchars($row['name']) ?></h3>
            <p><strong>ID:</strong> <?= $row['id'] ?></p>
          </div>

        </div>
      <?php endforeach; ?>
    </div>

  <?php else: ?>
    <div class="msg error">No students registered yet.</div>
  <?php endif; ?>

<?php endif; ?>

</div>
</body>
</html>