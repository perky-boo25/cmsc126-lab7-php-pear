<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Registration</title>
</head>
<body>
  <h1>Student Registration</h1>

  <?php

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
  <h2>Record Management</h2>
  <p><b>Look Up by Student ID</b></p>

  <input type="text" id="student_id_input" placeholder="Enter Student ID">

  <!--TODO: Search function, add filename inside quotations in form action -->
  <form action="search.php" method="get" style="display:inline;">
    <input type="hidden" name="student_id" id="search_id">
    <input type="submit" value="Search" onclick="document.getElementById('search_id').value = document.getElementById('student_id_input').value">
  </form>

<!--TODO: Update the info, add filename inside quotations in form action -->
  <form action="" method="get" style="display:inline;">
    <input type="hidden" name="student_id" id="update_id">
    <input type="submit" value="Update" onclick="document.getElementById('update_id').value = document.getElementById('student_id_input').value">
  </form>

  <form action="delete.php" method="post" style="display:inline;">
    <input type="hidden" name="student_id" id="delete_id">
    <input type="submit" value="Delete" onclick="document.getElementById('delete_id').value = document.getElementById('student_id_input').value">
  </form>
</body>
</html>