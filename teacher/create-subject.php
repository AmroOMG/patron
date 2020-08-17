<?php
ob_start();
$page_title = 'Patron - Create Subject';
include '../dashboard-header.php';

$subject_title = '';
$subject_id = '';
$subject_description = '';

if (isset($_GET['create'])) {
    $subject_title = htmlspecialchars($_GET['subject_title']);
    $subject_id = htmlspecialchars($_GET['subject_id']);
    $subject_description = htmlspecialchars($_GET['subject_description']);
    $creation_date = date("Y/m/d");
    $teacher_id = $_SESSION['id'];

    if (isset($_GET['private'])) {
        $status = 'private';
        $subject_code = rand(1000, 9999);
    } else {
        $status = 'public';
        $subject_code = '';
    }

    $sql = "SELECT * FROM subjects WHERE (subject_title = '$subject_title' || subject_id = '$subject_id') AND teacher_id= $teacher_id ";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $error = 'Subject name or id is already exists in your subjects';
    } else {
        $sql = "INSERT INTO subjects (subject_title,subject_id,subject_code,status,description,creation_date,teacher_id) VALUES ('$subject_title','$subject_id','$subject_code','$status','$subject_description','$creation_date','$teacher_id')";
        if (mysqli_query($conn, $sql)) {
            $success = "New Subject added successfully.";
            $sql2 = "SELECT id FROM subjects WHERE teacher_id=$teacher_id ORDER BY id DESC LIMIT 1";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $sub_id = $row2['id'];
            header("Location: view-subject.php?subject_id=$sub_id");
        } else {
            $error = 'Sorry something wrong happened, Subject not added !';
        }
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
                        <h3>Create Subject</h3>

                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="create row">
            <div class="col ">
                <form method="get">
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
                                <input type="checkbox" class="custom-control-input" name="private" id="Private" checked>
                                <label class="custom-control-label" for="Private">Private</label>
                                <span>*Private means students can join subject only via subject join code, else any student can join subject.</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-sm-12 text-right">
                            <button type="submit" name="create" class="btn btn-primary">Create Subject</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->
<?php include '../dashboard-footer.php'; ?>