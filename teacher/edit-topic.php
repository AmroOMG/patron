<?php
ob_start();
$page_title = 'Patron - Edit Topic';
include '../dashboard-header.php';

$id = htmlspecialchars($_GET['subject_id']);
$topic_id = htmlspecialchars($_GET['topic_id']);
$teach_id = $_SESSION['id'];

$sql = "SELECT * FROM topics WHERE id = '$topic_id' AND teacher_id = '$teach_id' ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $topic_title = $row['topic_title'];

    $sql2 = "SELECT * FROM subjects WHERE id= $id";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $subject_title = $row2['subject_title'];

    if (isset($_POST['edit'])) {
        $topic_title = htmlspecialchars($_POST['topic_title']);

        $sql3 = "SELECT * FROM topics WHERE subject_id = '$id' AND topic_title='$topic_title'";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_assoc($result3);
        if ($row3) {
            $error = "Topic title is already exists in your subject topics !";
        } else {
            $sql4 = "UPDATE topics SET topic_title='$topic_title' WHERE id='$topic_id'";
            if (mysqli_query($conn, $sql4)) {
                $success = "Topic updated successfully.";
                header("Location: view-topic.php?subject_id=$id&topic_id=$topic_id");
            } else {
                $error = 'Sorry something wrong happened, Topic not updeted !';
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
                        <h3><span><?php echo $subject_title; ?></span><br>Edit Topic</h3>
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
                        <label for="topic" class="col-sm-2 col-form-label">Topic title</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="topic_title" value="<?php echo $topic_title; ?>" id="topic" required>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-sm-12 text-right">
                            <button type="submit" name="edit" class="btn btn-primary">Edit Topic</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->

<?php include '../dashboard-footer.php'; ?>