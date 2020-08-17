<?php
ob_start();
$page_title = 'Patron - Quiz';
include '../dashboard-header.php';

$quiz_id = htmlspecialchars($_GET['quiz_id']);
$subject_id = htmlspecialchars($_GET['subject_id']);
$teach_id = $_SESSION['id'];
$teacher_fname = $_SESSION['first_name'];
$teacher_lname = $_SESSION['last_name'];

$sql = "SELECT * FROM quiz WHERE id = '$quiz_id' AND teacher_id = '$teach_id' AND subject_id = '$subject_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $quiz_title = $row['quiz_title'];
    $start_date = $row['start_date'];
    $start_time = $row['start_time'];
    $exp_date = $row['deadline_date'];
    $exp_time = $row['deadline_time'];
    $duration = $row['duration'];
    $mark = $row['total_mark'];

    $sql2 = "SELECT * FROM subject_teacher_student WHERE subject_id = $subject_id ";
    $result2 = mysqli_query($conn, $sql2);
    $students_count = mysqli_num_rows($result2);

    $sql5 = "SELECT * FROM quiz_teacher_student WHERE quiz_id = '$quiz_id'";
    $result5 = mysqli_query($conn, $sql5);
    $quiz_students_count = mysqli_num_rows($result5);
} else {
    header("Location: subjects.php");
}

?>

<div class="cd-content-wrapper">
    <!-- main content here -->
    <div class="container-fluid no-gutters">
        <div class="row no-gutters">
            <div class="col">
                <div class="hero hero-subject">
                    <div class="layout">
                        <h3><?php echo $quiz_title; ?></h3>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="create row">
            <div class="col ">
                <div class="subject-details">
                    <table class="table table-bordered">

                        <tbody>
                            <tr>
                                <td>Quiz title</td>
                                <td style="text-transform: capitalize"><?php echo $quiz_title; ?></td>
                            </tr>

                            <tr>
                                <td>Instructor name</td>
                                <td style="text-transform: capitalize"><?php echo $teacher_fname; ?> <?php echo $teacher_lname; ?></td>
                            </tr>

                            <tr>
                                <td>topics of quiz</td>
                                <td>
                                    <?php
                                    $sql3 = "SELECT * FROM quiz_topics WHERE quiz_id='$quiz_id'";
                                    $result3 = mysqli_query($conn, $sql3);
                                    while ($row3 = mysqli_fetch_assoc($result3)) {
                                        $topic_id = $row3['topic_id'];
                                        $questions_count = $row3['questions_count'];

                                        $sql4 = "SELECT * FROM topics WHERE id='$topic_id'";
                                        $result4 = mysqli_query($conn, $sql4);
                                        $row4 = mysqli_fetch_assoc($result4);
                                        $topic_title = $row4['topic_title'];

                                        $sql_check_questions = "SELECT * FROM questions WHERE topic_id= '$topic_id'";
                                        $result_check_questions  = mysqli_query($conn, $sql_check_questions);
                                        $topic_questions_count_now = mysqli_num_rows($result_check_questions);

                                        if ($topic_questions_count_now < $questions_count) {
                                            $sql_update_questions_count = "UPDATE quiz_topics SET questions_count = '$topic_questions_count_now' WHERE topic_id = '$topic_id' AND quiz_id = '$quiz_id'";
                                            $result_update_questions_count = mysqli_query($conn, $sql_update_questions_count);

                                            $sql_select_marks = "SELECT * FROM quiz_topics WHERE quiz_id = '$quiz_id'";
                                            $result_select_marks = mysqli_query($conn, $sql_select_marks);
                                            $new_mark = 0;
                                            while ($row_select_marks = mysqli_fetch_assoc($result_select_marks)) {
                                                $old_mark = $row_select_marks['questions_count'];
                                                $new_mark += $old_mark;
                                            }

                                            $sql_update_quiz_mark = "UPDATE quiz SET total_mark = '$new_mark' WHERE id = '$quiz_id'";
                                            $result_update_quiz_mark = mysqli_query($conn, $sql_update_quiz_mark);

                                            $sql_select_new_mark = "SELECT * FROM quiz WHERE id='$quiz_id'";
                                            $result_select_new_mark = mysqli_query($conn, $sql_select_new_mark);
                                            $row_select_new_mark = mysqli_fetch_assoc($result_select_new_mark);
                                            $mark = $row_select_new_mark['total_mark'];

                                            $sql_new_select = "SELECT * FROM quiz_topics WHERE quiz_id='$quiz_id' AND topic_id='$topic_id'";
                                            $result_new_select = mysqli_query($conn, $sql_new_select);
                                            $row_new_select = mysqli_fetch_assoc($result_new_select);
                                            $questions_count = $row_new_select['questions_count'];
                                        } else {
                                            $sql_select_marks = "SELECT * FROM quiz_topics WHERE quiz_id = '$quiz_id'";
                                            $result_select_marks = mysqli_query($conn, $sql_select_marks);
                                            $new_mark = 0;
                                            while ($row_select_marks = mysqli_fetch_assoc($result_select_marks)) {
                                                $old_mark = $row_select_marks['questions_count'];
                                                $new_mark += $old_mark;
                                            }

                                            $sql_update_quiz_mark = "UPDATE quiz SET total_mark = '$new_mark' WHERE id = '$quiz_id'";
                                            $result_update_quiz_mark = mysqli_query($conn, $sql_update_quiz_mark);

                                            $sql_select_new_mark = "SELECT * FROM quiz WHERE id='$quiz_id'";
                                            $result_select_new_mark = mysqli_query($conn, $sql_select_new_mark);
                                            $row_select_new_mark = mysqli_fetch_assoc($result_select_new_mark);
                                            $mark = $row_select_new_mark['total_mark'];
                                        }

                                    ?>

                                        <a style="text-transform: capitalize" href="view-topic.php?topic_id=<?php echo $topic_id; ?>&subject_id=<?php echo $subject_id; ?>"><?php echo $topic_title; ?><?php echo ' &#40;'; ?><?php echo $questions_count; ?><?php echo '&#41;'; ?><?php echo '<br>'; ?></a>


                                    <?php  }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Start date</td>
                                <td><?php echo $start_date; ?></td>
                            </tr>
                            <tr>
                                <td>Start time</td>
                                <td><?php echo date("g:i a", strtotime("$start_time")); ?></td>
                            </tr>
                            <tr>
                                <td>Duration</td>
                                <td><?php echo $duration; ?> minutes</td>
                            </tr>
                            <tr>
                                <td>Deadline date</td>
                                <td><?php echo $exp_date; ?></td>
                            </tr>
                            <tr>
                                <td>Deadline time</td>
                                <td><?php echo date("g:i a", strtotime("$exp_time")); ?></td>
                            </tr>

                            <tr>
                                <td class="last"># Participants</td>
                                <td class="last">&#40;<?php echo $quiz_students_count; ?>&#41; of <?php echo $students_count; ?> students</td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="add row">
            <div class="col text-right">
                <a href="edit-quiz.php?quiz_id=<?php echo $quiz_id; ?>&subject_id=<?php echo $subject_id; ?>">Edit Quiz</a>
                <a onclick="return confirm('Are you sure deleting quiz <?php echo $quiz_title; ?> ? \nBy deleting the quiz everything related to this quiz will be deleted such as students answers and analysis, and you will not be able to recover this data anymore!')" href="view-quizzes.php?delete_quiz=<?php echo $quiz_id; ?>">Delete Quiz</a>
                <a href="quiz-sample.php?subject_id=<?php echo $subject_id; ?>&quiz_id=<?php echo $quiz_id; ?>" target="_blank">View Quiz Sample</a>
                <a href="">View Analysis Result</a>
            </div>
        </div>

        <div class="row" id="students">
            <div class="col">
                <h3>Participant Students</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Mark <span>from &#40;<?php echo $mark; ?>&#41;</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $student_number = 1;
                        while ($row5  = mysqli_fetch_assoc($result5)) {
                            $student_id = $row5['student_id'];
                            $student_mark = $row5['std_mark'];

                            $sql6 = "SELECT * FROM users WHERE id='$student_id'";
                            $result6 = mysqli_query($conn, $sql6);
                            $row6 = mysqli_fetch_assoc($result6);
                            $student_fname = $row6['first_name'];
                            $student_lname = $row6['last_name'];
                            $student_email = $row6['email'];
                            $student_phone = $row6['phone'];
                        ?>
                            <tr>
                                <td scope="row"><?php echo $student_number; ?></td>
                                <td scope="col" style="text-transform: capitalize"><a href="teacher-profile.php?id=<?php echo $student_id; ?>"><?php echo $student_fname; ?> <?php echo $student_lname; ?></a></td>
                                <td scope="col"><?php echo $student_email; ?></td>
                                <td scope="col"><?php echo $student_phone; ?></td>
                                <td scope="col"><a target="_blank" href="view-student-answers.php?quiz_id=<?php echo $quiz_id; ?>&student_id=<?php echo $student_id; ?>"><?php echo $student_mark; ?></a></td>
                            </tr>
                        <?php $student_number++;
                        }
                        ?>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->
<?php include '../dashboard-footer.php'; ?>