<?php
$page_title = 'Patron - Subjects';
include '../std-dashboard-header.php';

$student_id = $_SESSION['id'];

if (isset($_GET['delete'])) {
    $delete_subject_id = htmlspecialchars($_GET['delete']);

    $sql4 = "DELETE FROM subject_teacher_student WHERE subject_id = '$delete_subject_id' AND student_id = '$student_id'";
    $result4 = mysqli_query($conn, $sql4);
    $sql5 = "SELECT * FROM quiz WHERE subject_id = '$delete_subject_id'";
    $result5 = mysqli_query($conn, $sql5);
    while ($row5 = mysqli_fetch_assoc($result5)) {
        $quiz_id = $row5['id'];

        $sql6 = "DELETE FROM quiz_teacher_student WHERE quiz_id = '$quiz_id' AND student_id = '$student_id'";
        $result6 = mysqli_query($conn, $sql6);
    }
    if ($result4) {
        $success = "Subject deleted successfully.";
    } else {
        $error = 'Something wrong happened, subject not deleted successfully please try again.';
    }
}

$sql = "SELECT * FROM subject_teacher_student WHERE student_id = '$student_id'";
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
        <div class="add row">
            <div class="col">
                <form class="form-inline my-2 my-lg-0">

                    <input class="form-control mr-sm-2" type="search" placeholder="Search for subject ..." aria-label="Search">

                </form>
            </div>
            <div class="col ">
                <a href="join-subject.php">Join new subject</a>
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
                            <th scope="col">Instructor</th>
                            <th scope="col">Status</th>
                            <th scope="col">Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $subject_number = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $subject_id  = $row['subject_id'];

                            $sql2 = "SELECT * FROM subjects WHERE id = '$subject_id'";
                            $result2 = mysqli_query($conn, $sql2);
                            $row2 = mysqli_fetch_assoc($result2);

                            $subject_title = $row2['subject_title'];
                            $sub_id = $row2['subject_id'];
                            $subject_code = $row2['subject_code'];
                            $status = $row2['status'];
                            $teacher_id = $row2['teacher_id'];

                            $sql3 = "SELECT * FROM users WHERE id = '$teacher_id'";
                            $result3 = mysqli_query($conn, $sql3);
                            $row3 = mysqli_fetch_assoc($result3);
                            $teacher_fname = $row3['first_name'];
                            $teacher_lname = $row3['last_name']; ?>

                            <tr>
                                <td scope="row"><?php echo $subject_number; ?></td>
                                <td scope="col"><a href="std-view-subject.php?subject_id=<?php echo $subject_id; ?>"><?php echo $subject_title; ?></a></td>
                                <td scope="col"><?php echo $sub_id; ?></td>
                                <td scope="col" style="text-transform: capitalize"><a href="student-profile.php?id=<?php echo $teacher_id; ?>"><?php echo $teacher_fname; ?> <?php echo $teacher_lname; ?></a></td>
                                <td scope="col"><?php echo $status; ?></td>
                                <td scope="col"><a class="drop" onclick="return confirm('Are you sure deleting subject <?php echo $subject_title; ?> ? \nBy deleting the subject everything related to this subject will be deleted such as quizzes you had attended, and you will not be able to recover this data anymore!')" href="std-subjects.php?delete=<?php echo $subject_id; ?>">Drop</a></td>
                            </tr>

                        <?php
                            $subject_number++;
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