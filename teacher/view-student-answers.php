<?php
ob_start();
$page_title = 'Patron - Student Answers';
include '../dashboard-header.php';

$student_id = $_GET['student_id'];
$quiz_id = $_GET['quiz_id'];

$sql0 = "SELECT * FROM users WHERE id = '$student_id' ";
$result0 = mysqli_query($conn, $sql0);
$row0 = mysqli_fetch_assoc($result0);
$student_fname = $row0['first_name'];
$student_lname = $row0['last_name'];

$sql01 = "SELECT * FROM quiz_teacher_student WHERE student_id = '$student_id' AND quiz_id = '$quiz_id' ";
$result01 = mysqli_query($conn, $sql01);
$row01 = mysqli_fetch_assoc($result01);
$student_mark = $row01['std_mark'];

$sql02 = "SELECT * FROM quiz WHERE id = '$quiz_id' ";
$result02 = mysqli_query($conn, $sql02);
$row02 = mysqli_fetch_assoc($result02);
$total_mark = $row02['total_mark'];

$sql = "SELECT * FROM students_answers WHERE student_id = '$student_id' AND quiz_id = '$quiz_id' ";
$result = mysqli_query($conn, $sql);

?>

<div class="cd-content-wrapper">
    <!-- main content here -->
    <div class="container-fluid no-gutters">
        <div class="row no-gutters">
            <div class="col">
                <div class="hero hero-subject">
                    <div class="layout">
                        <h3>Student Answers</h3>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h5><span style="font-weight: bold;">Student name : </span><?php echo $student_fname . ' ' . $student_lname ?></h5>
                <h5><span style="font-weight: bold;">Mark : </span><?php echo $student_mark . ' of ' . $total_mark; ?></h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Question</th>
                            <th scope="col">Correct Answer</th>
                            <th scope="col">student Answar</th>
                            <th scope="col">status</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $question_number = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $question_id = $row['question_id'];
                            $sql2 = "SELECT * FROM questions WHERE id = $question_id ";
                            $result2 = mysqli_query($conn, $sql2);
                            $row2 = mysqli_fetch_assoc($result2);
                            $question = $row2['question'];
                            $correct_answer = $row2['correct_answer'];

                            $sql3 = "SELECT * FROM students_answers WHERE quiz_id = '$quiz_id' AND student_id = '$student_id' AND question_id = '$question_id'";
                            $result3 = mysqli_query($conn, $sql3);
                            $row3 = mysqli_fetch_assoc($result3);
                            $student_answer = $row3['std_answer'];
                        ?>
                            <tr>
                                <td scope="col"><?php echo $question_number; ?></td>
                                <td scope="col"><?php echo $question; ?></td>
                                <td scope="col"><?php echo $correct_answer; ?></td>
                                <td scope="col"><?php echo $student_answer; ?></td>
                                <td scope="col"><?php if ($correct_answer == $student_answer) { ?>
                                        <span style="color: green;">correct</span>
                                    <?php
                                                } else { ?>
                                        <span style="color: red;">wrong</span>
                                    <?php   } ?></td>

                            </tr>
                        <?php $question_number++;
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