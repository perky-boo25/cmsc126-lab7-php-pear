<?php
include 'DBConnector.php';

$student_id = $_GET['student_id'];

// join tables to get all data
$sql = "SELECT s.*, sf.graduation_status, sf.image_path
        FROM `students` s
        JOIN `student_files` sf ON s.id = sf.student_id
        WHERE s.id = '$student_id'";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

if (!$row) {
    die("No student found with that ID.");
}
$conn->close();
?>

<!DOCTYPE html>
<html lang = "en">
<head>
  <meta charset = "UTF-8">
  <title>Edit Student</title>
</head>
<body>
    <h1> Edit Student </h1>

    <?php if (!empty($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'success'): ?>
            <div class = "msg_success"> Student updated successfully!</div>
        <?php else: ?>
            <div class = "msg_error"> Something went wrong. Please try again. </div>
        <?php endif; ?>
    <?php endif; ?>

    <form action = "update.php" method = "post" enctype = "multipart/form-data">

        <!--pass student ID thru-->
        <input type = "hidden" name = "student_id" value = "<?= $row['image_path'] ?>">

        <table>
            <tr>
                <td>Name</td>
                <td><input type = "text" name = "name" maxlength = "40" value = "<?= htmlspecialchars($row['name']) ?>" required></td>
            </tr>
            <tr>
                <td>Age</td>
                <td><input type = "number" name = "age" min = "0" max = "99" value = "<?= $row['age'] ?>" required></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type = "email" name = "email" maxlength = "40" value = "<?= htmlspecialchars($row['email']) ?>" required></td>
            </tr>
            <tr>
                <td>Course</td>
                <td><input type = "text" name = "course" maxlength = "40" value = "<?= htmlspecialchars($row['course']) ?>" required></td>
            </tr>
            <tr>
                <td> Year Level </td>
                <td>
                    <select name = "year_level" required>
                        <?php for ($y = 1; $y <= 4; $y++): ?>
                            <option value = "<?= $y ?>" <?=+ $row['year_level'] == $y ? 'selected' : '' ?>>
                                <?= + $y ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td> Graduating? </td>
                <td>
                    <input type = "radio" name = "graduation_status" value = "1" <?= + $row['graduation_status'] == 1 ? 'checked' : '' ?>> Yes <br>
                    <input type = "radio" name = "graduation_status" value = "0" <?= + $row['graduation_status'] == 0 ? 'checked' : '' ?>> No
                </td>
            </tr>
            <tr>
                <td> Profile Image </td>
                <td>
                    <?php if (!empty($row['image_path'])): ?>
                        <img src = "<?= $row['image_path'] ?>" width = "100"> <br>
                        <small> Current image. Upload a new one to replace it. </small> <br>
                    <?php endif; ?>
                    <input type = "file" name = "image" accept = ".jpg, .jpeg, .png, .gof, .webp">
                    <input type="hidden" name="existing_image" value="<?= htmlspecialchars($row['image_path']) ?>">
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <br>
                    <input type="submit" value="Update Student">
                </td>
                </tr>
        </table>
    </form>

    <br> <a href = "index.php"> ← Back </a>
</body>
</html>
