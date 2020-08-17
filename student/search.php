<?php
session_start();
include '../inc/db.php';

$search = $_GET['text'];
$student_id = $_SESSION['id'];

$sql = "SELECT * FROM subjects WHERE subject_title LIKE '%$search%' OR subject_id = '$search'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $subject_number = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $subject_id = $row['id'];
        $subject_title = $row['subject_title'];
        $sub_id = $row['subject_id'];
        $status = $row['status'];
        $teacher_id = $row['teacher_id'];

        $sql2 = "SELECT * FROM users WHERE id = '$teacher_id'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $teacher_fname = $row2['first_name'];
        $teacher_lname = $row2['last_name'];

        $sql3 = "SELECT * FROM subject_teacher_student WHERE subject_id = '$subject_id'";
        $result3 = mysqli_query($conn, $sql3);
        $students_count = mysqli_num_rows($result3);

        $sql4 = "SELECT * FROM subject_teacher_student WHERE subject_id = '$subject_id' AND student_id = '$student_id'";
        $result4 = mysqli_query($conn, $sql4);
        $row4 = mysqli_fetch_assoc($result4);
?>
        <tr>
            <td scope="row"><?php echo $subject_number; ?></td>
            <?php
            if ($row4) { ?>
                <td scope="col"><a href="std-view-subject.php?subject_id=<?php echo $subject_id; ?>"><?php echo $subject_title; ?></a></td>
            <?php    } else { ?>
                <td scope="col"><?php echo $subject_title; ?></td>
            <?php    }
            ?>

            <td scope="col"><?php echo $sub_id; ?></td>
            <td scope="col" style="text-transform: capitalize"><a href="student-profile.php?id=<?php echo $teacher_id; ?>"><?php echo $teacher_fname; ?> <?php echo $teacher_lname; ?></a></td>
            <td scope="col"><?php echo $students_count; ?></td>
            <td scope="col"><?php
                            if ($status == 'public') {
                                $state = '<i class="fas fa-lock-open"></i>Public';
                            } elseif ($status == 'private') {
                                $state = '<i class="fas fa-lock"></i>Private';
                            }
                            echo $state; ?></td>

            <?php
            if ($row4) { ?>
                <td scope="col"><a class="drop" onclick="return confirm('Are you sure deleting subject <?php echo $subject_title; ?> ? \nBy deleting the subject everything related to this subject will be deleted such as quizzes you had attended, and you will not be able to recover this data anymore!')" href="join-subject.php?delete=<?php echo $subject_id; ?>">Drop</a></td>
                <?php    } else {
                if ($status == 'public') { ?>
                    <td scope="col"><a style="color: #fff" class="join" type="button" id="public_join" onclick="public_join(<?php echo $subject_id; ?>, <?php echo $teacher_id; ?>)">Join</a></td>
                <?php    } else { ?>
                    <td scope="col"><a style="color: #fff" class="join" type="button" id="private_join" onclick="private_join(<?php echo $subject_id; ?>, <?php echo $teacher_id; ?>)">Join</a></td>
            <?php    }
            }
            ?>

        </tr>

<?php $subject_number++;
    }
} else {
    echo 'No Results found for your search : ' . $search;
}

include '../std-dashboard-footer.php';
