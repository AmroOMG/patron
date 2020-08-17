<?php
ob_start();
$page_title = 'Patron - Quizzes';
include '../std-dashboard-header.php';

$student_id = $_SESSION['id'];

$sql = "SELECT * FROM subject_teacher_student WHERE student_id = '$student_id' ";
$result = mysqli_query($conn, $sql);

?>

<div class="cd-content-wrapper">
    <!-- main content here -->
    <div class="container-fluid no-gutters">
        <div class="row no-gutters">
            <div class="col">
                <div class="hero hero-subject">
                    <div class="layout">
                        <h3>Quizzes</h3>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="add row">
            <div class="col">
                <form class="form-inline my-2 my-lg-0">

                    <input class="form-control mr-sm-2" type="search" placeholder="Search for quiz ..." aria-label="Search">

                </form>
            </div>

        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Quiz title</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Start date</th>
                            <th scope="col">Start time</th>
                            <th scope="col">Deadline date</th>
                            <th scope="col">Deadline time</th>
                            <th scope="col">Questions</th>
                            <th scope="col">Duratuion</th>
                            <th scope="col">Option</th>
                            <th scope="col">Mark</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $quiz_number = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $subject_id = $row['subject_id'];
                            $sql2 = "SELECT * FROM quiz WHERE subject_id = $subject_id ";
                            $result2 = mysqli_query($conn, $sql2);
                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                $quiz_id = $row2['id'];
                                $subject_id = $row2['subject_id'];
                                $quiz_title = $row2['quiz_title'];
                                $start_date = $row2['start_date'];
                                $start_time = $row2['start_time'];
                                $deadline_date = $row2['deadline_date'];
                                $deadline_time = $row2['deadline_time'];
                                $duration = $row2['duration'];

                                $start = $start_date . '' . $start_time;
                                $expire = $deadline_date . '' . $deadline_time;

                                $sql3 = "SELECT * FROM subjects WHERE id = '$subject_id'";
                                $result3 = mysqli_query($conn, $sql3);
                                $row3 = mysqli_fetch_assoc($result3);
                                $subject_title = $row3['subject_title'];

                                $sql4 = "SELECT * FROM quiz_topics WHERE quiz_id = '$quiz_id'";
                                $result4 = mysqli_query($conn, $sql4);
                                $questions_count = 0;
                                while ($row4 = mysqli_fetch_assoc($result4)) {
                                    $quesions = $row4['questions_count'];
                                    $questions_count += $quesions;
                                }
                        ?>
                                <tr>
                                    <td scope="col"><?php echo $quiz_number; ?></td>
                                    <td scope="col" style="width: 100px"><?php echo $quiz_title; ?></td>
                                    <td scope="col"><a href="std-view-subject.php?subject_id=<?php echo $subject_id; ?>"><?php echo $subject_title; ?></a></td>
                                    <td scope="col" style="width: 143px"><?php echo $start_date; ?></td>
                                    <td scope="col"><?php echo date("g:i a", strtotime("$start_time")); ?></td>
                                    <td scope="col" style="width: 143px"><?php echo $deadline_date; ?></td>
                                    <td scope="col"><?php echo date("g:i a", strtotime("$deadline_time")); ?></td>
                                    <td scope="col"><?php echo $questions_count; ?></td>
                                    <td scope="col"><?php echo $duration; ?> m</td>
                                    <?php
                                    $sql5 = "SELECT * FROM quiz_teacher_student WHERE quiz_id = '$quiz_id' AND student_id = '$student_id'";
                                    $result5 = mysqli_query($conn, $sql5);
                                    $row5 = mysqli_fetch_assoc($result5);
                                    if ($row5) {
                                        //اذا مقدم الكويز
                                        $mark = $row5['std_mark']; ?>
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
                                                    <td scope="col" style="width: 172px"><a class="attend" onclick="return confirm('are you sure you want to attend the quiz ?\nInstructions:\n1.Quiz is multiple choice questions, you have to select one answer for the question to move to the next question.\n2.Try to finish answering all questions before the timer ends.\n3.Do NOT reload the quiz page during quiz.\nWarning: By reloading the quiz page you can NOT return to the quiz again, and you will get marks for the only answered questions.')" href="quiz.php?subject_id=<?php echo $subject_id; ?>&quiz_id=<?php echo $quiz_id; ?>">Attend quiz</a></td>
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
                        <?php $quiz_number++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->

<?php include '../std-dashboard-footer.php'; ?>