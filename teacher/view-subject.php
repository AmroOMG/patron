<?php
ob_start();
$page_title = 'Patron - Subject';
include '../dashboard-header.php';

$subject_id = htmlspecialchars($_GET['subject_id']);
$teach_id = $_SESSION['id'];
$sql = "SELECT * FROM subjects WHERE id = $subject_id AND teacher_id = $teach_id ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $subject_title = $row['subject_title'];

    $teacher_id = $row['teacher_id'];
    $sql2 = "SELECT * FROM users WHERE id = $teacher_id ";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $teacher_fn = $row2['first_name'];
    $teacher_ln = $row2['last_name'];

    $sql3 = "SELECT * FROM subject_teacher_student WHERE subject_id = $subject_id ";
    $result3 = mysqli_query($conn, $sql3);
    $students_count = mysqli_num_rows($result3);

    if (isset($_GET['delete_quiz'])) {
        $delete_quiz_id = htmlspecialchars($_GET['delete_quiz']);

        $sql9 = "DELETE FROM quiz WHERE id = '$delete_quiz_id'";
        $result9 = mysqli_query($conn, $sql9);
        $sql10 = "DELETE FROM quiz_topics WHERE quiz_id = '$delete_quiz_id'";
        $result10 = mysqli_query($conn, $sql10);
        $sql11 = "DELETE FROM quiz_teacher_student WHERE quiz_id = '$delete_quiz_id'";
        $result11 = mysqli_query($conn, $sql11);
        $sql12 = "DELETE FROM students_answers WHERE quiz_id = '$delete_quiz_id'";
        $result12 = mysqli_query($conn, $sql12);

        if ($result9) {
            $success = 'Quiz deleted successfully.';
        } else {
            $error = 'Something wrong happened, quiz not deleted successfully please try again.';
        }
    }

    $sql4 = "SELECT * FROM quiz WHERE subject_id = $subject_id ";
    $result4 = mysqli_query($conn, $sql4);
    $quizzes_count = mysqli_num_rows($result4);

    $subject_status = $row['status'];
    if ($subject_status == 'private') {
        $subject_code = $row['subject_code'];
    } else {
        $subject_code = 'Subject status is public, Any student can join this subject without code';
    }
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
                                <td><?php echo $row['subject_id']; ?></td>
                            </tr>
                            <tr>
                                <td>Instructor name</td>
                                <td><?php echo $teacher_fn; ?> <?php echo $teacher_ln; ?></td>
                            </tr>
                            <tr>
                                <td>Subject code <span>&#40;students can join subject only via this code&#41;</span></td>
                                <td><?php echo $subject_code; ?></td>
                            </tr>
                            <tr>
                                <td>Subject description</td>
                                <td><?php echo $row['description']; ?></td>
                            </tr>
                            <tr>
                                <td># Participants</td>
                                <td><a href="#students"><?php echo $students_count; ?></a></td>
                            </tr>
                            <tr>
                                <td># Number of quizzes</td>
                                <td><?php echo $quizzes_count; ?></td>
                            </tr>
                            <tr>
                                <td class="last">Created in</td>
                                <td class="last"><?php echo $row['creation_date']; ?></td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="add row">
            <div class="col text-right ">
                <a href="edit-subject.php?subject_id=<?php echo $subject_id; ?>">Edit subject</a>
                <a onclick="return confirm('Are you sure deleting subject <?php echo $subject_title; ?> ? \nBy deleting the subject everything related to this subject will be deleted such as topics, questions and quizzes, and you will not be able to recover this data anymore!')" href="subjects.php?delete=<?php echo $subject_id; ?>">Delete Subject</a>
                <a href="question-bank.php?subject_id=<?php echo $subject_id; ?>">Manage Question Bank</a>
                <a href="create-quiz.php?subject_id=<?php echo $subject_id; ?>">Create new Quiz</a>
            </div>
        </div>
        <?php
        if ($quizzes_count > 0) { ?>
            <div class="row">
                <div class="col">
                    <?php if (isset($error) && !empty($error)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php echo $error; ?>
                        </div>
                    <?php } elseif (isset($success) && !empty($success)) { ?>
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php echo $success; ?>
                        </div>
                    <?php } ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Quiz title</th>
                                <th scope="col">Questions</th>
                                <th scope="col">Participants</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $quiz_number = 1;
                            while ($row4 = mysqli_fetch_assoc($result4)) {

                                $quiz_id = $row4['id'];
                                $sql5 = "SELECT * FROM quiz_teacher_student WHERE quiz_id = $quiz_id ";
                                $result5 = mysqli_query($conn, $sql5);
                                $students_count = mysqli_num_rows($result5);

                                $sql6 = "SELECT * FROM quiz_topics WHERE quiz_id = $quiz_id ";
                                $result6 = mysqli_query($conn, $sql6);
                                $questions_count = 0;
                                while ($row6 = mysqli_fetch_assoc($result6)) {
                                    $questions_count += $row6['questions_count'];
                                }
                            ?>

                                <tr>
                                    <td scope="row"><?php echo $quiz_number; ?></td>
                                    <td scope="col"><a href="quiz-details.php?quiz_id=<?php echo $row4['id']; ?>&subject_id=<?php echo $subject_id; ?>"><?php echo $row4['quiz_title']; ?></a></td>
                                    <td scope="col"><?php echo $questions_count; ?></td>
                                    <td scope="col"><a href="quiz-details.php?quiz_id=<?php echo $row4['id']; ?>&subject_id=<?php echo $subject_id; ?>#students"><?php echo $students_count; ?></a></td>
                                    <td scope="col"><a href="edit-quiz.php?quiz_id=<?php echo $row4['id']; ?>&subject_id=<?php echo $subject_id; ?>"><i class="fas fa-pencil-alt"></i></a></td>
                                    <td scope="col"><a onclick="return confirm('Are you sure deleting quiz <?php echo $row4['quiz_title']; ?> ? \nBy deleting the quiz everything related to this quiz will be deleted such as students answers and analysis, and you will not be able to recover this data anymore!')" href="view-subject.php?subject_id=<?php echo $subject_id; ?>&delete_quiz=<?php echo $quiz_id; ?>"><i class="fas fa-trash-alt"></i></a></td>
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

        <?php
        if ($students_count > 0) { ?>
            <div class="row" id="students">
                <div class="col">
                    <h3>Participant Students</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Student Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql7 = "SELECT * FROM subject_teacher_student WHERE subject_id = $subject_id ";
                            $result7 = mysqli_query($conn, $sql7);
                            while ($row7 = mysqli_fetch_assoc($result7)) {
                                $student_id = $row7['student_id'];
                                $sql8 = "SELECT * FROM users WHERE id = $student_id ";
                                $result8 = mysqli_query($conn, $sql8);
                                $student_number = 1;
                                while ($row8 = mysqli_fetch_assoc($result8)) { ?>
                                    <tr>
                                        <td scope="row"><?php echo $student_number; ?></td>
                                        <td scope="col" style="text-transform: capitalize"><a href="teacher-profile.php?id=<?php echo $student_id; ?>"><?php echo $row8['first_name']; ?> <?php echo $row8['last_name']; ?></a></td>
                                        <td scope="col"><?php echo $row8['email']; ?></td>
                                        <td scope="col"><?php echo $row8['gender']; ?></td>
                                        <td scope="col"><?php echo $row8['phone']; ?></td>
                                        <td scope="col"><a href=""><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>
                            <?php
                                    $student_number++;
                                }
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

<?php include '../dashboard-footer.php'; ?>