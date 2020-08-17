<?php
ob_start();
$page_title = 'Patron - Profile';
include '../dashboard-header.php';

$selected_id = htmlspecialchars($_GET['id']);
$teacher_id = $_SESSION['id'];

$sql = "SELECT * FROM users WHERE id=$selected_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $id = $row['id'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    $password = $row['password'];
    $rule = $row['rule'];
    $gender = $row['gender'];
    $phone = $row['phone'];
    $bio = $row['bio'];
    $specialization = $row['specialization'];
    $image = $row['image'];

    if (isset($_GET['delete_subject'])) {
        $delete_subject_id = htmlspecialchars($_GET['delete_subject']);
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

    if (isset($_GET['delete_user'])) {
        $delete_user_id = htmlspecialchars($_GET['delete_user']);
        $sql12 = "DELETE FROM users WHERE id = '$delete_user_id'";
        $result12 = mysqli_query($conn, $sql12);
        $sql13 = "DELETE FROM subjects WHERE teacher_id = '$delete_user_id'";
        $result13 = mysqli_query($conn, $sql13);
        $sql14 = "DELETE FROM topics WHERE teacher_id = '$delete_user_id'";
        $result14 = mysqli_query($conn, $sql14);
        $sql15 = "DELETE FROM questions WHERE teacher_id = '$delete_user_id'";
        $result15 = mysqli_query($conn, $sql15);
        $sql16 = "DELETE FROM subject_teacher_student WHERE teacher_id = '$delete_user_id'";
        $result16 = mysqli_query($conn, $sql16);
        $sql17 = "SELECT * FROM quiz WHERE teacher_id = '$delete_user_id'";
        $result17 = mysqli_query($conn, $sql17);
        while ($row17 = mysqli_fetch_assoc($result17)) {
            $quiz_id = $row17['id'];
            $sql18 = "DELETE FROM quiz WHERE id = '$quiz_id'";
            $result18 = mysqli_query($conn, $sql18);
            $sql19 = "DELETE FROM quiz_topics WHERE quiz_id = '$quiz_id'";
            $result19 = mysqli_query($conn, $sql19);
            $sql20 = "DELETE FROM quiz_teacher_student WHERE quiz_id = '$quiz_id'";
            $result20 = mysqli_query($conn, $sql20);
            $sql21 = "DELETE FROM students_answers WHERE quiz_id = '$quiz_id'";
            $result21 = mysqli_query($conn, $sql21);
        }
        if ($result12) {
            session_destroy();
            session_unset();
            header("Location: ../signup.php");
        } else {
            $error_account = 'Something wrong happened, account not deleted successfully please try again.';
        }
    }
} else {
    header("Location: teacher-profile.php?id=$teacher_id");
}

?>
<div class="cd-content-wrapper">
    <!-- main content here -->
    <div class="container-fluid no-gutters">
        <div class="row no-gutters justify-content-between">
            <div class="hero hero-profile">
                <div class="layout">
                    <div class="col-lg-5">
                        <div class="user-image">
                            <img src="../images/users/<?php echo $image; ?>" alt="">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="user-info">
                            <h3 style="text-transform: capitalize"><?php echo $first_name; ?> <?php echo $last_name; ?></h3>
                            <h5 style="text-transform: capitalize"><?php echo $specialization; ?></h5>
                            <h6 style="text-transform: capitalize">Rule: <?php echo $rule; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <?php if (isset($error_account) && !empty($error_account)) { ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?php echo $error_account; ?>
            </div>
        <?php } ?>
        <div class="row">
            <div class="dash-cards col">
                <div class="card dash-card bg-light mb-3">
                    <div class="card-header">
                        <h3>Bio</h3>
                        <div class="icon mr-auto"><i class="fas fa-globe-americas"></i></div>
                    </div>
                    <div class="card-body" style="overflow:auto; height:400px;">
                        <p class="card-text"><?php echo $bio; ?></p>

                    </div>
                </div>
            </div>
            <div class="dash-cards col">
                <div class="card dash-card bg-light mb-3">
                    <div class="card-header">
                        <h3>Information</h3>
                        <div class="icon mr-auto"><i class="fas fa-info-circle"></i></div>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><i class="fas fa-transgender"></i>Gender: <?php echo $gender; ?></p>
                        <p class="card-text"><i class="fas fa-at"></i>Email: <?php echo $email; ?></p>
                        <p class="card-text"><i class="fas fa-mobile-alt"></i>Phone: <?php echo $phone; ?></p>
                    </div>
                </div>
            </div>
            <?php
            if ($selected_id == $teacher_id) { ?>
                <div class="dash-cards col">
                    <div class="card dash-card bg-light mb-3">
                        <div class="card-header">
                            <h3>Settings</h3>
                            <div class="icon mr-auto"><i class="fas fa-cog"></i></div>
                        </div>
                        <div class="card-body settings">

                            <a href="edit-profile.php?id=<?php echo $teacher_id; ?>"><i class="fas fa-user-edit"></i>Edit profile</a>
                            <a href="change-password.php?id=<?php echo $teacher_id; ?>"><i class="fas fa-undo-alt"></i>Change password</a>
                            <a onclick="return confirm('Are you sure deleting account ? \nBy deleting the account all the subjects and quizzes you had created will be removed, and you will not be able to recover this data anymore!')" href="teacher-profile.php?id=<?php echo $teacher_id; ?>&delete_user=<?php echo $teacher_id; ?>"><i class="fas fa-times-circle"></i>Delete account</a>
                        </div>
                    </div>
                </div>
            <?php  }
            ?>

        </div>
        <?php
        if ($rule == 'teacher') { ?>
            <div class="row">
                <div class="dash-cards col-lg-12">
                    <div class="card dash-card bg-light mb-3">
                        <div class="card-header">
                            <h3>Statistics</h3>
                            <div class="icon mr-auto"><i class="fas fa-database"></i></div>
                        </div>
                        <div class="card-body statistics">

                            <?php
                            $sql2 = "SELECT * FROM quiz WHERE teacher_id = $selected_id";
                            $result2 = mysqli_query($conn, $sql2);
                            $quizzes_count = mysqli_num_rows($result2);

                            $sql3 = "SELECT * FROM subjects WHERE teacher_id = $selected_id";
                            $result3 = mysqli_query($conn, $sql3);
                            $subjects_count = mysqli_num_rows($result3);
                            ?>
                            <?php

                            if ($selected_id == $teacher_id) { ?>
                                <a class="statistics" href="view-quizzes.php"><i class="fas fa-question-circle"></i> Created &#40;<?php echo $quizzes_count; ?>&#41; quizzes </a>
                                <a class="statistics" href="subjects.php"><i class="fas fa-book-open"></i> Created &#40;<?php echo $subjects_count; ?>&#41; subjects</a>
                            <?php } else { ?>
                                <p class="statistics"><i class="fas fa-question-circle"></i> Created &#40;<?php echo $quizzes_count; ?>&#41; quizzes </p>
                                <p class="statistics"><i class="fas fa-book-open"></i> Created &#40;<?php echo $subjects_count; ?>&#41; subjects</p>
                            <?php }

                            ?>
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
                                        <?php
                                        if ($selected_id == $teacher_id) { ?>
                                            <th scope="col">Subject code</th>
                                        <?php }
                                        ?>
                                        <th scope="col">Number of students</th>
                                        <th scope="col">Number of quizzes</th>
                                        <th scope="col">Status</th>
                                        <?php
                                        if ($selected_id == $teacher_id) { ?>
                                            <th scope="col">Option</th>
                                        <?php }
                                        ?>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $subject_number = 1;
                                    while ($row3 = mysqli_fetch_assoc($result3)) {
                                        $sub_id = $row3['id'];
                                        $subject_title = $row3['subject_title'];
                                        $subject_id = $row3['subject_id'];
                                        $subject_code = $row3['subject_code'];
                                        $subject_title = $row3['subject_title'];
                                        $status = $row3['status'];

                                        $sql4 = "SELECT * FROM subject_teacher_student WHERE subject_id = '$sub_id'";
                                        $result4 = mysqli_query($conn, $sql4);
                                        $students_count = mysqli_num_rows($result4);

                                        $sql5 = "SELECT * FROM quiz WHERE subject_id = '$sub_id'";
                                        $result5 = mysqli_query($conn, $sql5);
                                        $quizzes_count = mysqli_num_rows($result5);
                                    ?>

                                        <tr>
                                            <td scope="row"><?php echo $subject_number; ?></td>
                                            <td scope="col">
                                                <?php
                                                if ($selected_id == $teacher_id) { ?>
                                                    <a href="view-subject.php?subject_id=<?php echo $sub_id; ?>"><?php echo $subject_title; ?></a>
                                                <?php
                                                } else {
                                                    echo $subject_title;
                                                }
                                                ?>

                                            </td>
                                            <td scope="col"><?php echo $subject_id; ?></td>
                                            <?php
                                            if ($selected_id == $teacher_id) {
                                            ?>
                                                <td scope="col"><?php
                                                                if ($subject_code == '') {
                                                                    echo '-';
                                                                } else {
                                                                    echo $subject_code;
                                                                } ?></td>
                                            <?php } ?>

                                            <td scope="col"><?php echo $students_count; ?></td>
                                            <td scope="col"><?php echo $quizzes_count; ?></td>
                                            <td scope="col"><?php
                                                            if ($status == 'public') {
                                                                $state = '<i class="fas fa-lock-open"></i>Public';
                                                            } elseif ($status == 'private') {
                                                                $state = '<i class="fas fa-lock"></i>Private';
                                                            }
                                                            echo $state; ?></td>
                                            <?php
                                            if ($selected_id == $teacher_id) { ?>
                                                <td scope="col"><a onclick="return confirm('Are you sure deleting subject <?php echo $subject_title; ?> ? \nBy deleting the subject everything related to this subject will be deleted such as topics, questions and quizzes, and you will not be able to recover this data anymore!')" href="teacher-profile.php?delete_subject=<?php echo $sub_id; ?>"><i class="fas fa-trash-alt"></i></a></td>
                                            <?php }
                                            /* in Student profile
                                                 elseif ($session_rule == 'student') {
                                                $sql6 = "SELECT * FROM stbject_teacher_student WHERE subject_id = '$sub_id' AND student_id = '$teacher_id'";
                                                $result6 = mysqli_query($conn, $sql6);
                                                $row6 = mysqli_fetch_assoc($result6);
                                                if ($row6) { ?>
                                                    <td scope="col"><a href="" class="drop">Drop</a></td>
                                                <?php  } else { ?>
                                                    <td scope="col"><a href="" class="join">Join</a></td> <!-- When implement student join subject -->
                                                <?php  }
                                                ?>


                                            <?php    } */
                                            ?>

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
            </div>
        <?php
        } ?>
    </div>



</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->

<?php include '../dashboard-footer.php'; ?>

<script>
    $(".card-body").niceScroll(".card-text", {
        cursorcolor: "#ff7d66",
        cursorwidth: "3px",
        cursorborder: 0,
        cursorborderradius: "3px",
    });
</script>