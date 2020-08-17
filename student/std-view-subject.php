<?php
ob_start();
$page_title = 'Patron - Subject';
include '../std-dashboard-header.php';

$subject_id = htmlspecialchars($_GET['subject_id']);
$student_id = $_SESSION['id'];

$sql = "SELECT * FROM subject_teacher_student WHERE subject_id = '$subject_id' AND student_id = '$student_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row) {

    $sql2 = "SELECT * FROM subjects WHERE id = '$subject_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);

    $subject_title = $row2['subject_title'];
    $sub_id = $row2['subject_id'];
    $status = $row2['status'];
    $teacher_id = $row2['teacher_id'];
    $creation_date = $row2['creation_date'];
    $description = $row2['description'];

    if ($status == 'private') {
        $subject_code = $row2['subject_code'];
    } else {
        $subject_code = 'Subject status is public, Any student can join this subject without code';
    }

    $sql3 = "SELECT * FROM users WHERE id = '$teacher_id'";
    $result3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_assoc($result3);
    $teacher_fname = $row3['first_name'];
    $teacher_lname = $row3['last_name'];

    $sql4 = "SELECT * FROM subject_teacher_student WHERE subject_id = $subject_id ";
    $result4 = mysqli_query($conn, $sql4);
    $students_count = mysqli_num_rows($result4);

    $sql5 = "SELECT * FROM quiz WHERE subject_id = $subject_id ";
    $result5 = mysqli_query($conn, $sql5);
    $quizzes_count = mysqli_num_rows($result5);
} else {
    header("Location: std-subjects.php");
}
?>

<div class="cd-content-wrapper">
    <!-- main content here -->
    <div class="container-fluid no-gutters">
        <div class="row no-gutters">
            <div class="col">
                <div class="hero hero-subject">
                    <div class="layout">
                        <h3><span><?php echo $subject_title; ?></span></h3>
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
                                <td>Subject title</td>
                                <td><?php echo $subject_title; ?></td>
                            </tr>
                            <tr>
                                <td>Subject id</td>
                                <td><?php echo $sub_id; ?></td>
                            </tr>
                            <tr>
                                <td>Instructor name</td>
                                <td><a href="student-profile.php?id=<?php echo $teacher_id; ?>"><?php echo $teacher_fname; ?> <?php echo $teacher_lname; ?></a></td>
                            </tr>
                            <tr>
                                <td>Subject code <span>&#40;students can join subject only via this code&#41;</span></td>
                                <td><?php echo $subject_code; ?></td>
                            </tr>
                            <tr>
                                <td>Subject description</td>
                                <td><?php echo $description; ?></td>
                            </tr>
                            <tr>
                                <td>Number of students</td>
                                <td><?php echo $students_count; ?></td>
                            </tr>
                            <tr>
                                <td>Number of quizzes</td>
                                <td><?php echo $quizzes_count; ?></td>
                            </tr>
                            <tr>
                                <td class="last">Created in</td>
                                <td class="last"><?php echo $creation_date; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        if ($quizzes_count > 0) { ?>
            <div class="row">
                <div class="col">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Quiz title</th>
                                <th scope="col">Start date</th>
                                <th scope="col">Start time</th>
                                <th scope="col">deadline date</th>
                                <th scope="col">deadline time</th>
                                <th scope="col">Questions</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Option</th>
                                <th scope="col">Mark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $quiz_number = 1;
                            while ($row5 = mysqli_fetch_assoc($result5)) {
                                $quiz_id = $row5['id'];
                                $quiz_title = $row5['quiz_title'];
                                $start_date = $row5['start_date'];
                                $start_time = $row5['start_time'];
                                $deadline_date = $row5['deadline_date'];
                                $deadline_time = $row5['deadline_time'];
                                $duration = $row5['duration'];

                                $start = $start_date . '' . $start_time;
                                $expire = $deadline_date . '' . $deadline_time;

                                $sql6 = "SELECT * FROM quiz_topics WHERE quiz_id = '$quiz_id'";
                                $result6 = mysqli_query($conn, $sql6);
                                $questions_count = 0;
                                while ($row6 = mysqli_fetch_assoc($result6)) {
                                    $quesions = $row6['questions_count'];
                                    $questions_count += $quesions;
                                }
                            ?>
                                <tr>
                                    <td scope="row"><?php echo $quiz_number; ?></td>
                                    <td scope="col"><?php echo $quiz_title; ?></td>
                                    <td scope="col"><?php echo $start_date; ?></td>
                                    <td scope="col"><?php echo date("g:i a", strtotime("$start_time")); ?></td>
                                    <td scope="col"><?php echo $deadline_date; ?></td>
                                    <td scope="col"><?php echo date("g:i a", strtotime("$deadline_time")); ?></td>
                                    <td scope="col"><?php echo $questions_count; ?></td>
                                    <td scope="col"><?php echo $duration; ?> m</td>
                                    <?php
                                    $sql7 = "SELECT * FROM quiz_teacher_student WHERE quiz_id = '$quiz_id' AND student_id = '$student_id'";
                                    $result7 = mysqli_query($conn, $sql7);
                                    $row7 = mysqli_fetch_assoc($result7);
                                    if ($row7) {
                                        //اذا مقدم الكويز
                                        $mark = $row7['std_mark']; ?>
                                        <td scope="col">Done</td>
                                        <!--if student finished quiz -->
                                        <td scope="col"><a href="view-student-answers.php?quiz_id=<?php echo $quiz_id; ?>"><?php echo $mark; ?></a></td>
                                        <?php
                                    } else {
                                        //اذا مش مقدم الكويز
                                        if (($start_date === '00-00-0000') || ($deadline_date === '00-00-0000')) {
                                            //ازا التواريخ مش محددة
                                        ?>
                                            <td scope="col">Not available yet</td>
                                            <!--if time is not yet -->
                                            <td scope="col">-</td>
                                            <?php
                                        } else {
                                            if ((time() + (60 * 60 * 1)) < strtotime($start)) { /* افحص ازا تاريخ البداية ما اجا وقتو */
                                            ?>
                                                <td scope="col">Not available yet</td>
                                                <!--if time is not yet -->
                                                <td scope="col">-</td>
                                                <?php

                                            } else {

                                                if ((time() + (60 * 60 * 1)) < strtotime($expire)) { /* افحص تاريخ النهاية ازا ما اجا وقتو */ ?>
                                                    <td scope="col" style="width: 144px"><a class="attend" onclick="return confirm('are you sure you want to attend the quiz ?\nInstructions:\n1.Quiz is multiple choice questions, you have to select one answer for the question to move to the next question.\n2.Try to finish answering all questions before the timer ends.\n3.Do NOT reload the quiz page during quiz.\nWarning: By reloading the quiz page you can NOT return to the quiz again, and you will get marks for the only answered questions.')" href="quiz.php?subject_id=<?php echo $subject_id; ?>&quiz_id=<?php echo $quiz_id; ?>">Attend quiz</a></td>
                                                    <!--quiz is available -->
                                                    <td scope="col">-</td>
                                                <?php    } else {
                                                    //هنا تاريخ النهاية خلص
                                                ?>
                                                    <td scope="col">Expired</td>
                                                    <!--if deadline is over and student didn't attend quiz -->
                                                    <td scope="col">-</td>
                                                <?php    }

                                                ?>

                                    <?php
                                            }
                                        }
                                    }
                                    ?>

                                </tr>
                            <?php
                                $quiz_number++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php }
        ?>


    </div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->
<?php include '../std-dashboard-footer.php'; ?>