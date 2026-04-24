-- session config: disable auto-increment on zero, use manual transactions, set utc timezone
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- create and select the database
CREATE DATABASE IF NOT EXISTS `student_db`;
USE `student_db`;


-- main student records table
CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `age` int(2) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `course` varchar(40) DEFAULT NULL,
  `year_level` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- stores file/graduation info linked to a student
CREATE TABLE `student_files` (
  `file_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `graduation_status` tinyint(1) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- primary key for students
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);


-- primary key and index on foreign key column for student_files
ALTER TABLE `student_files`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `student_id` (`student_id`);


-- auto-increment for students.id
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


-- auto-increment for student_files.file_id
ALTER TABLE `student_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;


-- foreign key: student_files.student_id → students.id
ALTER TABLE `student_files`
  ADD CONSTRAINT `student_files_ibfk_1`
  FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

COMMIT;