<?php
$page_title = 'Patron - Join subject';
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

?>

<div class="cd-content-wrapper">
    <!-- main content here -->
    <div class="container-fluid no-gutters">
        <div class="row no-gutters">
            <div class="col">
                <div class="hero hero-subject">
                    <div class="layout">
                        <h3>Search for Subjects</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="add row">
            <div class="col">
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search for subject name or id" aria-label="Search" id="search">
                </form>
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
                <div class="alert alert-info alert-dismissible fade show" role="alert" id="msg">
                    search for subject title or subject id
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Subject title</th>
                            <th scope="col">Subject id</th>
                            <th scope="col">Instructor name</th>
                            <th scope="col">Participants</th>
                            <th scope="col">Status</th>
                            <th scope="col">Option</th>
                        </tr>
                    </thead>

                    <tbody id="result">


                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->



<?php include '../std-dashboard-footer.php'; ?>

<script>
    $(document).ready(function() {

        $('#public_join').click(function(event) {
            event.preventDefault();
        });
        $('#private_join').click(function(event) {
            event.preventDefault();
        });
        $('#search').submit(function(event) {
            event.preventDefault();
        });
    });
</script>

<script>
    $('#search').keyup(function() {
        var q = $('#search').val();
        if (q.length >= 2) {
            $.ajax({
                url: 'search.php',
                type: 'GET',
                data: {
                    text: q
                }
            }).done(function(response) {
                $('#result').html(response);
            }).fail(function() {
                console.log("error");
            })
        } else {
            $('#result').html("");
        }
    })
</script>

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