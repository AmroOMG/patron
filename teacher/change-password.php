<?php
ob_start();
$page_title = 'Patron - Profile';
include '../dashboard-header.php';

$selected_id = htmlspecialchars($_GET['id']);
$teacher_id = $_SESSION['id'];

if ($selected_id == $teacher_id) {
    $sql = "SELECT * FROM users WHERE id = '$teacher_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $password = $row['password'];


    if (isset($_POST['change'])) {
        $old_pass = htmlspecialchars($_POST['old_password']);
        $old_password = sha1($old_pass);
        $new_password = htmlspecialchars($_POST['new_password']);
        $re_new_password = htmlspecialchars($_POST['re_new_password']);

        if ($new_password != $re_new_password) {
            $error = 'Sorry, New password dose not match the repeated new password !';
        } else {
            if ($old_password != $password) {
                $error = 'Sorry, you entered incorrect password !';
            } else {
                $new_pass = sha1($new_password);
                $sql = "UPDATE users SET password = '$new_pass' WHERE id = '$teacher_id'";
                if (mysqli_query($conn, $sql)) {
                    $success = "Password changed successfully.";
                } else {
                    $error = 'Sorry something wrong happened, password did not changed !';
                }
            }
        }
    }
} else {
    header("Location: change-password.php?id=$teacher_id");
}

?>
<div class="cd-content-wrapper">
    <!-- main content here -->
    <div class="container-fluid no-gutters">
        <div class="row no-gutters">
            <div class="col">
                <div class="hero hero-subject">
                    <div class="layout">
                        <h3>Change password</h3>

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
                    <div class="form-group ">
                        <label for="old">Current password</label>
                        <input type="password" class="form-control" id="old" name="old_password" required>
                    </div>
                    <div class="form-group ">
                        <label for="new">New password</label>
                        <input type="password" class="form-control" id="new" name="new_password" required>
                    </div>
                    <div class="form-group ">
                        <label for="re-new">Repeat new password</label>
                        <input type="password" class="form-control" id="re-new" name="re_new_password" required>
                    </div>
                    <div class="form-group row ">
                        <div class="col-sm-12 text-right">
                            <button type="submit" name="change" class="btn btn-primary">Change password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->

<?php include '../dashboard-footer.php'; ?>