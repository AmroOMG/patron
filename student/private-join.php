<?php
session_start();
include '../inc/db.php';

$student_id = $_SESSION['id'];
$pr_subject_id = $_GET['subject_id'];
$pr_teacher_id = $_GET['teacher_id'];
$pr_join_code = $_GET['join_code'];

if (isset($pr_subject_id) && isset($pr_teacher_id) && isset($pr_join_code)) {

    $sql = "SELECT * FROM subject_teacher_student WHERE subject_id = '$pr_subject_id' AND student_id = '$student_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        echo 'You already joined this subject, system will redirect you to subject in few seconds';
    } else {
        $sql1 = "SELECT * FROM subjects WHERE id = '$pr_subject_id'";
        $result1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_assoc($result1);
        $subject_title = $row1['subject_title'];
        $subject_code = $row1['subject_code'];
        if ($pr_join_code == $subject_code) {
            $sql2 = "INSERT INTO subject_teacher_student (subject_id, teacher_id, student_id) VALUES ('$pr_subject_id', '$pr_teacher_id', '$student_id')";
            $result2 = mysqli_query($conn, $sql2);
            if ($result2) {
                echo 'Subject joined successfully, system will redirect you to subject in few seconds';
            } else {
                echo 'Something wrong happened, Subject not joined ! please try again ';
            }
        } else {
            echo 'Incorrect join code for subjcet: ' . $subject_title;
        }
    }
}
