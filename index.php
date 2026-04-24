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
      echo '<div class="msg success">&#10004; Student registered successfully!</div>';
    } elseif ($_GET['status'] === 'duplicate_email') {
      echo '<div class="msg error">&#10008; That email is already registered.</div>';
    } else {
      echo '<div class="msg error">&#10008; Something went wrong. Please try again.</div>';
    }
  }
  ?>

  <br>
  <h3>New Student:</h3>
  <form action="insert.php" method="post" enctype="multipart/form-data">
    <table>
      <tr>
        <td class="tlabel">Name</td>
        <td><input type="text" name="name" maxlength="40" required></td>
      </tr>
      <tr>
        <td class="tlabel">Age</td>
        <td><input type="number" name="age" min="0" max="99" required></td>
      </tr>
      <tr>
        <td class="tlabel">Email</td>
        <td><input type="email" name="email" maxlength="40" required></td>
      </tr>
      <tr>
        <td class="tlabel">Course</td>
        <td><input type="text" name="course" maxlength="40" required></td>
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
</body>
</html>