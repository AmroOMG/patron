<?php
session_start();
include '../inc/db.php';

$subject_id = $_GET['s_id'];
$teacher_id = $_GET['t_id'];
$student_id = $_SESSION['id'];

if (isset($teacher_id) && isset($subject_id)) {
    $sql = "SELECT * FROM subject_teacher_student WHERE subject_id = '$subject_id' AND student_id = '$student_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        echo 'You already joined this subject, system will redirect you to subject in few seconds';
    } else {
        $sql2 = "INSERT INTO subject_teacher_student (subject_id, teacher_id, student_id) VALUES ('$subject_id', '$teacher_id', '$student_id')";
        $result2 = mysqli_query($conn, $sql2);
        if ($result2) {
            echo 'Subject joined successfully, system will redirect you to subject in few seconds';
        } else {
            echo 'Something wrong happened, Subject not joined ! please try again ';
        }
    }
}
