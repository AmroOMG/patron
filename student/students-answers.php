<?php
session_start();
include '../inc/db.php';

$student_id = $_SESSION['id'];
$subject_id = $_GET['subject_id'];
$quiz_id = $_GET['quiz_id'];
$topic_id = $_GET['topic_id'];
$question_id = $_GET['question_id'];
$std_answer = $_GET['std_answer'];

if (isset($subject_id) && isset($quiz_id) && isset($topic_id) && isset($question_id) && isset($std_answer)) {
    $sql = "INSERT INTO students_answers (student_id, subject_id, quiz_id, topic_id, question_id, std_answer) VALUES ('$student_id', '$subject_id', '$quiz_id', '$topic_id', '$question_id', '$std_answer')";
    $result = mysqli_query($conn, $sql);

    $sql2 = "SELECT * FROM questions WHERE id = '$question_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $correct_answer = $row2['correct_answer'];

    if ($std_answer == $correct_answer) {
        $sql3 = "SELECT * FROM quiz_teacher_student WHERE quiz_id = '$quiz_id' AND student_id = '$student_id'";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_assoc($result3);
        $mark = $row3['std_mark'];
        $new_mark = $mark + 1;

        $sql4 = "UPDATE quiz_teacher_student SET std_mark = '$new_mark' WHERE quiz_id = '$quiz_id' AND student_id = '$student_id'";
        $result4 = mysqli_query($conn, $sql4);
    }
}

//check the subject id column in the students_answers table in database
