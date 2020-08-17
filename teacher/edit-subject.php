<?php
ob_start();
$page_title = 'Patron - Edit Subject';
include '../dashboard-header.php';

$id = htmlspecialchars($_GET['subject_id']);
$teach_id = $_SESSION['id'];
$sql = "SELECT * FROM subjects WHERE id = '$id' AND teacher_id =' $teach_id' ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $subject_title = $row['subject_title'];
    $subject_id = $row['subject_id'];
    $subject_description = $row['description'];
    $status = $row['status'];
    $subject_code = $row['subject_code'];

    if (isset($_POST['edit'])) {
        $subject_title = htmlspecialchars($_POST['subject_title']);
        $subject_id = htmlspecialchars($_POST['subject_id']);
        $subject_description = htmlspecialchars($_POST['subject_description']);

        if (isset($_POST['private']) && $status == 'public') {
            $status = 'private';
            $subject_code = rand(1000, 9999);
        } elseif ((!isset($_POST['private'])) && $status == 'private') {
            $status = 'public';
            $subject_code = '';
        } elseif (isset($_POST['private']) && $status == 'private') {
            $status = 'private';
            $subject_code = $subject_code;
        } elseif ((!isset($_POST['private'])) && $status == 'public') {
            $status = 'public';
            $subject_code = '';
        }
        $sql2 = "SELECT * FROM subjects WHERE (subject_title = '$subject_title' || subject_id = '$subject_id') AND teacher_id= $teacher_id ";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        if (($row2['subject_title'] == $row['subject_title']) || ($row2['subject_id'] == $row['subject_id'])) {
            $sql3 = "UPDATE subjects SET subject_title='$subject_title', subject_id='$subject_id', description='$subject_description', status='$status', subject_code='$subject_code' WHERE id='$id'";
            if (mysqli_query($conn, $sql3)) {
                $success = "Subject updated successfully.";
                header("Location: view-subject.php?subject_id=$id");
            } else {
                $error = 'Sorry something wrong happened, Subject not updated !';
            }
        } elseif ($row2) {
            $error = 'Subject name or id is already exists in your subjects';
        } else {
            $sql3 = "UPDATE subjects SET subject_title='$subject_title', subject_id='$subject_id', description='$subject_description', status='$status', subject_code='$subject_code' WHERE id='$id'";
            if (mysqli_query($conn, $sql3)) {
                $success = "Subject updated successfully.";
                header("Location: view-subject.php?subject_id=$id");
            } else {
                $error = 'Sorry something wrong happened, Subject not updated !';
            }
        }
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
                        <h3>Edit Subject</h3>

                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="create row">
            <div class="col ">
                <form method="post">
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
                    <div class="form-group row">
                        <label for="Subject-title" class="col-sm-2 col-form-label">Subject title</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="subject_title" value="<?php echo $subject_title; ?>" id="Subject-title" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Subject-id" class="col-sm-2 col-form-label">Subject id</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="subject_id" value="<?php echo $subject_id; ?>" id="Subject-id" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Subject-description" class="col-sm-2 col-form-label">Subject description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="subject_description" id="Subject-description" required><?php echo $subject_description; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Privacy" class="col-sm-2 col-form-label">Privacy</label>
                        <div class="col-sm-10">
                            <div class="custom-control custom-switch">
                                <?php
                                if ($status == 'private') {
                                    $checked_attr = 'checked';
                                } else {
                                    $checked_attr = '';
                                }
                                ?>
                                <input type="checkbox" class="custom-control-input" name="private" id="Private" <?php echo $checked_attr; ?>>
                                <label class="custom-control-label" for="Private">Private</label>
                                <span>*Private means students can join subject only via subject join code, else any student can join subject.</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-sm-12 text-right">
                            <button type="submit" name="edit" class="btn btn-primary">Edit Subject</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->

<?php include '../dashboard-footer.php'; ?>