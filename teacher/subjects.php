<?php
$page_title = 'Patron - Subjects';
include '../dashboard-header.php';

$teacher_id = $_SESSION['id'];

if (isset($_GET['delete'])) {
    $delete_subject_id = htmlspecialchars($_GET['delete']);
    $sql3 = "DELETE FROM subjects WHERE id = '$delete_subject_id'";
    $result3 = mysqli_query($conn, $sql3);
    $sql4 = "DELETE FROM topics WHERE subject_id = '$delete_subject_id'";
    $result4 = mysqli_query($conn, $sql4);
    $sql5 = "DELETE FROM questions WHERE subject_id = '$delete_subject_id'";
    $result5 = mysqli_query($conn, $sql5);
    $sql6 = "DELETE FROM subject_teacher_student WHERE subject_id = '$delete_subject_id'";
    $result6 = mysqli_query($conn, $sql6);
    $sql7 = "SELECT * FROM quiz WHERE subject_id = '$delete_subject_id'";
    $result7 = mysqli_query($conn, $sql7);
    while ($row7 = mysqli_fetch_assoc($result7)) {
        $quiz_id = $row7['id'];
        $sql8 = "DELETE FROM quiz WHERE id = '$quiz_id'";
        $result8 = mysqli_query($conn, $sql8);
        $sql9 = "DELETE FROM quiz_topics WHERE quiz_id = '$quiz_id'";
        $result9 = mysqli_query($conn, $sql9);
        $sql10 = "DELETE FROM quiz_teacher_student WHERE quiz_id = '$quiz_id'";
        $result10 = mysqli_query($conn, $sql10);
        $sql11 = "DELETE FROM students_answers WHERE quiz_id = '$quiz_id'";
        $result11 = mysqli_query($conn, $sql11);
    }
    if ($result3) {
        $success = "Subject deleted successfully.";
    } else {
        $error = 'Something wrong happened, subject not deleted successfully please try again.';
    }
}

$sql = "SELECT * FROM subjects WHERE teacher_id = $teacher_id ";
$result = mysqli_query($conn, $sql);

?>

<div class="cd-content-wrapper">
    <!-- main content here -->
    <div class="container-fluid no-gutters">
        <div class="row no-gutters">
            <div class="col">
                <div class="hero hero-subject">
                    <div class="layout">
                        <h3>Subjects</h3>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="add row justify-content-end">
            <!--
            <div class="col">
                <form class="form-inline my-2 my-lg-0">

                    <input class="form-control mr-sm-2" type="search" placeholder="Search for subject ..." aria-label="Search">

                </form>
            </div>
            -->
            <div class="col-sm-12 col-lg-4 text-right">
                <a href="create-subject.php">Create new subject</a>
            </div>
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
                            <th scope="col">Subject title</th>
                            <th scope="col">Subject id</th>
                            <th scope="col">Subject code</th>
                            <th scope="col">Participants</th>
                            <th scope="col">Status</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $subject_number = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $subject_id = $row['id'];
                            $sql2 = "SELECT * FROM subject_teacher_student WHERE subject_id = $subject_id ";
                            $result2 = mysqli_query($conn, $sql2);
                            $students_count = mysqli_num_rows($result2);
                            if ($row['status'] == 'private') {
                                $class = 'fas fa-lock';
                                $subject_code = $row['subject_code'];
                            } else {
                                $class = 'fas fa-lock-open';
                                $subject_code = '-';
                            } ?>
                            <tr>
                                <td scope="row"><?php echo $subject_number; ?></td>
                                <td scope="col"><a href="view-subject.php?subject_id=<?php echo $row['id']; ?>"><?php echo $row['subject_title']; ?></a></td>
                                <td scope="col"><?php echo $row['subject_id']; ?></td>
                                <td scope="col"><?php echo $subject_code; ?></td>
                                <td scope="col"><a href="view-subject.php?subject_id=<?php echo $row['id']; ?>#students"><?php echo $students_count; ?></a></td>
                                <td scope="col"><i class="<?php echo $class; ?>"></i><?php echo $row['status']; ?></td>
                                <td scope="col"><a href="edit-subject.php?subject_id=<?php echo $row['id']; ?>"><i class="fas fa-pencil-alt"></i></a></td>
                                <td scope="col"><a onclick="return confirm('Are you sure deleting subject <?php echo $row['subject_title']; ?> ? \nBy deleting the subject everything related to this subject will be deleted such as topics, questions and quizzes, and you will not be able to recover this data anymore!')" href="subjects.php?delete=<?php echo $row['id']; ?>"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                        <?php
                            $subject_number++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->

<?php include '../dashboard-footer.php'; ?>