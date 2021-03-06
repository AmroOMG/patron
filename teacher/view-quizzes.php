<?php
ob_start();
$page_title = 'Patron - Quizzes';
include '../dashboard-header.php';

$teacher_id = $_SESSION['id'];

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
            <!--
            <div class="col">
                <form class="form-inline my-2 my-lg-0">

                    <input class="form-control mr-sm-2" type="search" placeholder="Search for quiz ..." aria-label="Search">

                </form>
            </div>
-->
        </div>
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
                            <th scope="col">Subject</th>
                            <th scope="col">Deadline Date</th>
                            <th scope="col">Deadline Time</th>
                            <th scope="col">Duratuion</th>
                            <th scope="col">Participants</th>
                            <th scope="col">Sample</th>
                            <th scope="col">Analysis result</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM quiz WHERE teacher_id = '$teacher_id'";
                        $result = mysqli_query($conn, $sql);
                        $quiz_number = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $subject_id = $row['subject_id'];
                            $quiz_id = $row['id'];
                            $quiz_title = $row['quiz_title'];
                            $quiz_title = $row['quiz_title'];
                            $deadline_date = $row['deadline_date'];
                            $deadline_time = $row['deadline_time'];
                            $duration = $row['duration'];

                            $sql2 = "SELECT * FROM subjects WHERE id = '$subject_id' ";
                            $result2 = mysqli_query($conn, $sql2);
                            $row2 = mysqli_fetch_assoc($result2);
                            $subject_title = $row2['subject_title'];

                            $sql3 = "SELECT * FROM quiz_teacher_student WHERE quiz_id = '$quiz_id' ";
                            $result3 = mysqli_query($conn, $sql3);
                            $participants_count = mysqli_num_rows($result3);
                        ?>
                            <tr>
                                <td scope="col"><?php echo $quiz_number; ?></td>
                                <td scope="col"><a href="quiz-details.php?quiz_id=<?php echo $quiz_id; ?>&subject_id=<?php echo $subject_id; ?>"><?php echo $quiz_title; ?></a></td>
                                <td scope="col"><a href="view-subject.php?subject_id=<?php echo $subject_id; ?>"><?php echo $subject_title; ?></a></td>
                                <td scope="col"><?php echo $deadline_date; ?></td>
                                <td scope="col"><?php echo date("g:i a", strtotime("$deadline_time")); ?></td>
                                <td scope="col"><?php echo $duration; ?></td>
                                <td scope="col"><a href="quiz-details.php?quiz_id=<?php echo $quiz_id; ?>&subject_id=<?php echo $subject_id; ?>#students"><?php echo $participants_count; ?></a></td>
                                <td scope="col"><a href="quiz-sample.php?subject_id=<?php echo $subject_id; ?>&quiz_id=<?php echo $quiz_id; ?>" target="_blank"><i class="far fa-file-alt"></i></a></td>
                                <td scope="col"><a href="analysis-result.html"><i class="fas fa-chart-pie"></i></a></td>
                                <td scope="col"><a href="edit-quiz.php?quiz_id=<?php echo $quiz_id; ?>&subject_id=<?php echo $subject_id; ?>"><i class="fas fa-pencil-alt"></i></a></td>
                                <td scope="col"><a onclick="return confirm('Are you sure deleting quiz <?php echo $quiz_title; ?> ? \nBy deleting the quiz everything related to this quiz will be deleted such as students answers and analysis, and you will not be able to recover this data anymore!')" href="view-quizzes.php?delete_quiz=<?php echo $quiz_id; ?>"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                        <?php $quiz_number++;
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