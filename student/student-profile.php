<?php
ob_start();
$page_title = 'Patron - Profile';
include '../std-dashboard-header.php';

$selected_id = htmlspecialchars($_GET['id']);
$student_id = $_SESSION['id'];

$sql = "SELECT * FROM users WHERE id='$selected_id'";
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

    if (isset($_GET['delete_user'])) {
        $delete_user_id = htmlspecialchars($_GET['delete_user']);
        $sql12 = "DELETE FROM users WHERE id = '$delete_user_id'";
        $result12 = mysqli_query($conn, $sql12);
        $sql13 = "DELETE FROM subject_teacher_student WHERE student_id = '$delete_user_id'";
        $result13 = mysqli_query($conn, $sql13);
        $sql14 = "DELETE FROM quiz_teacher_student WHERE student_id = '$student_id'";
        $result14 = mysqli_query($conn, $sql14);

        if ($result12) {
            session_destroy();
            session_unset();
            header("Location: ../signup.php");
        } else {
            $error_account = 'Something wrong happened, account not deleted successfully please try again.';
        }
    }
} else {
    header("Location: student-profile.php?id=$student_id");
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
            if ($selected_id == $student_id) { ?>
                <div class="dash-cards col">
                    <div class="card dash-card bg-light mb-3">
                        <div class="card-header">
                            <h3>Settings</h3>
                            <div class="icon mr-auto"><i class="fas fa-cog"></i></div>
                        </div>
                        <div class="card-body settings">

                            <a href="std-edit-profile.php?id=<?php echo $student_id; ?>"><i class="fas fa-user-edit"></i>Edit profile</a>
                            <a href="std-change-password.php?id=<?php echo $student_id; ?>"><i class="fas fa-undo-alt"></i>Change password</a>
                            <a onclick="return confirm('Are you sure deleting account ? \nBy deleting the account all the subjects and quizzes you had joined will be removed, and you will not be able to recover this data anymore!')" href="student-profile.php?id=<?php echo $student_id; ?>&delete_user=<?php echo $student_id; ?>"><i class="fas fa-times-circle"></i>Delete account</a>
                        </div>
                    </div>
                </div>
            <?php  }
            ?>
        </div>
        <?php
        if (($id == $student_id) || ($rule == 'teacher')) { ?>
            <div class="row">
                <div class="dash-cards col-lg-12">
                    <div class="card dash-card bg-light mb-3">
                        <div class="card-header">
                            <h3>Statistics</h3>
                            <div class="icon mr-auto"><i class="fas fa-database"></i></div>

                        </div>
                        <div class="card-body statistics">
                            <?php
                            if ($id == $student_id) {
                                $sql = "SELECT * FROM subject_teacher_student WHERE student_id = '$student_id'";
                                $result = mysqli_query($conn, $sql);
                                $subjects_count = mysqli_num_rows($result);

                                $sql2 = "SELECT * FROM quiz_teacher_student WHERE student_id = '$student_id'";
                                $result2 = mysqli_query($conn, $sql2);
                                $quizzes_count = mysqli_num_rows($result2);
                            ?>
                                <a class="statistics" href="std-quizzes.php"><i class="fas fa-question-circle"></i> Attended &#40;<?php echo $quizzes_count; ?>&#41; quizzes </a>
                                <a class="statistics" href="std-subjects.php"><i class="fas fa-book-open"></i> Joined &#40;<?php echo $subjects_count; ?>&#41; subjects</a>

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
                                            <th scope="col">Instructor</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql3 = "SELECT * FROM subject_teacher_student WHERE student_id = '$student_id'";
                                        $result3 = mysqli_query($conn, $sql3);
                                        $subject_number = 1;
                                        while ($row3 = mysqli_fetch_assoc($result3)) {
                                            $teacher = $row3['teacher_id'];
                                            $subject_id = $row3['subject_id'];

                                            $sql4 = "SELECT * FROM users WHERE id = '$teacher'";
                                            $result4 = mysqli_query($conn, $sql4);
                                            $row4 = mysqli_fetch_assoc($result4);
                                            $teacher_fname = $row4['first_name'];
                                            $teacher_lname = $row4['last_name'];

                                            $sql5 = "SELECT * FROM subjects WHERE id = '$subject_id'";
                                            $result5 = mysqli_query($conn, $sql5);
                                            $row5 = mysqli_fetch_assoc($result5);
                                            $subject_title = $row5['subject_title'];
                                            $sub_id = $row5['subject_id'];
                                            $subject_code = $row5['subject_code'];
                                            $status = $row5['status'];
                                        ?>
                                            <tr>
                                                <td scope="row"><?php echo $subject_number; ?></td>
                                                <td scope="col"><a href="std-view-subject.php?subject_id=<?php echo $subject_id; ?>"><?php echo $subject_title; ?></a></td>
                                                <td scope="col"><?php echo $sub_id; ?></td>
                                                <td scope="col"><?php
                                                                if ($subject_code == '') {
                                                                    echo '-';
                                                                } else {
                                                                    echo $subject_code;
                                                                } ?></td>
                                                <td scope="col" style="text-transform: capitalize"><a href="student-profile.php?id=<?php echo $teacher; ?>"><?php echo $teacher_fname; ?> <?php echo $teacher_lname; ?></a></td>
                                                <td scope="col"><?php
                                                                if ($status == 'public') {
                                                                    $state = '<i class="fas fa-lock-open"></i>Public';
                                                                } elseif ($status == 'private') {
                                                                    $state = '<i class="fas fa-lock"></i>Private';
                                                                }
                                                                echo $state; ?></td>
                                                <td scope="col"><a class="drop" onclick="return confirm('Are you sure deleting subject <?php echo $subject_title; ?> ? \nBy deleting the subject everything related to this subject will be deleted such as quizzes you had attended, and you will not be able to recover this data anymore!')" href="student-profile.php?id=<?php echo $student_id; ?>&delete_subject=<?php echo $subject_id; ?>" style="text-align: center">Drop</a></td>
                                            </tr>
                                        <?php
                                            $subject_number++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <div class="alert alert-info alert-dismissible fade show" role="alert" id="msg">
                                    You can join new subjects for this teacher or drop a subject.
                                </div>

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
                                            <th scope="col">Number of students</th>
                                            <th scope="col">Number of quizzes</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Option</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql6 = "SELECT * FROM subjects WHERE teacher_id = '$id'";
                                        $result6 = mysqli_query($conn, $sql6);
                                        $subject_number = 1;
                                        while ($row6 = mysqli_fetch_assoc($result6)) {
                                            $subject_id = $row6['id'];
                                            $subject_title = $row6['subject_title'];
                                            $sub_id = $row6['subject_id'];
                                            $subject_code = $row6['subject_code'];
                                            $status = $row6['status'];

                                            $sql7 = "SELECT * FROM subject_teacher_student WHERE subject_id = '$subject_id'";
                                            $result7 = mysqli_query($conn, $sql7);
                                            $students_count = mysqli_num_rows($result7);

                                            $sql8 = "SELECT * FROM quiz WHERE subject_id = '$subject_id'";
                                            $result8 = mysqli_query($conn, $sql8);
                                            $quizzes_count = mysqli_num_rows($result8);

                                            $sql9 = "SELECT * FROM subject_teacher_student WHERE subject_id = '$subject_id' AND student_id = '$student_id'";
                                            $result9 = mysqli_query($conn, $sql9);
                                            $row9 = mysqli_fetch_assoc($result9);
                                        ?>
                                            <tr>
                                                <td scope="row"><?php echo $subject_number; ?></td>
                                                <?php
                                                if ($row9) { ?>
                                                    <td scope="row"><a href="std-view-subject.php?subject_id=<?php echo $subject_id; ?>"><?php echo $subject_title; ?></a></td>
                                                <?php  } else { ?>
                                                    <td scope="row"><?php echo $subject_title; ?></td>
                                                <?php  }
                                                ?>

                                                <td scope="row"><?php echo $sub_id; ?></td>
                                                <td scope="row"><?php echo $students_count; ?></td>
                                                <td scope="row"><?php echo $quizzes_count; ?></td>
                                                <td scope="col"><?php
                                                                if ($status == 'public') {
                                                                    $state = '<i class="fas fa-lock-open"></i>Public';
                                                                } elseif ($status == 'private') {
                                                                    $state = '<i class="fas fa-lock"></i>Private';
                                                                }
                                                                echo $state; ?></td>
                                                <?php
                                                if ($row9) { ?>
                                                    <td scope="col"><a class="drop" onclick="return confirm('Are you sure deleting subject <?php echo $subject_title; ?> ? \nBy deleting the subject everything related to this subject will be deleted such as quizzes you had attended, and you will not be able to recover this data anymore!')" href="student-profile.php?id=<?php echo $id; ?>&delete_subject=<?php echo $subject_id; ?>" style="text-align: center">Drop</a></td>
                                                    <?php    } else {
                                                    if ($status == 'public') { ?>
                                                        <td scope="col" style="text-align: center"><a style="color: #fff" class="join" type="button" id="public_join" onclick="public_join(<?php echo $subject_id; ?>, <?php echo $id; ?>)">Join</a></td>
                                                    <?php    } else { ?>
                                                        <td scope="col" style="text-align: center"><a style="color: #fff" class="join" type="button" id="private_join" onclick="private_join(<?php echo $subject_id; ?>, <?php echo $id; ?>)">Join</a></td>
                                                <?php    }
                                                }
                                                ?>

                                            </tr>
                                    <?php
                                            $subject_number++;
                                        }
                                    }
                                    ?>
                        </div>
                    </div>
                </div>

            </div>
        <?php    }
        ?>

    </div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->

<?php include '../std-dashboard-footer.php'; ?>

<script>
    function public_join(subject_id, teacher_id) {
        $.ajax({
            url: 'join.php',
            type: 'GET',
            data: {
                s_id: subject_id,
                t_id: teacher_id
            }
        }).done(function(response) {
            $('#msg').html(response);
            if (response == 'Subject joined successfully, system will redirect you to subject in few seconds') {
                window.location.href = "http://localhost/patron/student/std-view-subject.php?subject_id=" + subject_id;
            }
            if (response == 'You already joined this subject, system will redirect you to subject in few seconds') {
                window.location.href = "http://localhost/patron/student/std-view-subject.php?subject_id=" + subject_id;
            }
        }).fail(function() {
            console.log("error");
        })
    }
</script>

<script>
    function private_join(subject_id, teacher_id) {
        var code = prompt("Please enter subject join code:");
        if (code !== null) {
            $.ajax({
                url: 'private-join.php',
                type: 'GET',
                data: {
                    subject_id: subject_id,
                    teacher_id: teacher_id,
                    join_code: code
                }
            }).done(function(response) {
                $('#msg').html(response);
                if (response == 'Subject joined successfully, system will redirect you to subject in few seconds') {
                    window.location.href = "http://localhost/patron/student/std-view-subject.php?subject_id=" + subject_id;
                }
                if (response == 'You already joined this subject, system will redirect you to subject in few seconds') {
                    window.location.href = "http://localhost/patron/student/std-view-subject.php?subject_id=" + subject_id;
                }
            }).fail(function() {
                console.log("error");
            })
        }
    }
</script>

<script>
    $(".card-body").niceScroll(".card-text", {
        cursorcolor: "#ff7d66",
        cursorwidth: "3px",
        cursorborder: 0,
        cursorborderradius: "3px",
    });
</script>