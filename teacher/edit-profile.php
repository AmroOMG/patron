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

    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    $gender = $row['gender'];
    $phone = $row['phone'];
    $bio = $row['bio'];
    $specialization = $row['specialization'];

    if (isset($_POST['update'])) {
        $first_name = htmlspecialchars($_POST['first_name']);
        $last_name = htmlspecialchars($_POST['last_name']);
        if (isset($_POST['gender'])) {
            $gender = htmlspecialchars($_POST['gender']);
        } else {
            $gender = 'not defined';
        }
        $phone = htmlspecialchars($_POST['phone']);
        $bio =  htmlspecialchars($_POST['bio']);
        $specialization = htmlspecialchars($_POST['specialization']);

        if (isset($_FILES['image'])) {
            $image = $_FILES['image'];
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $image_name = $email . time() . "." . $ext;
            move_uploaded_file($image['tmp_name'], '../images/users/' . $image_name);
        }

        $sql2 = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', gender = '$gender', phone = '$phone', bio = '$bio', specialization = '$specialization', image = '$image_name' WHERE id = '$teacher_id'";
        if (mysqli_query($conn, $sql2)) {
            $success = "Profile edited successfully.";
        } else {
            $error = 'Sorry something wrong happened, Profile not edited !';
        }
    }
} else {
    header("Location: edit-profile.php?id=$teacher_id");
}

?>

<div class="cd-content-wrapper">
    <!-- main content here -->
    <div class="container-fluid no-gutters">
        <div class="row no-gutters">
            <div class="col">
                <div class="hero hero-subject">
                    <div class="layout">
                        <h3>Edit Profile</h3>

                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="create row">
            <div class="col ">
                <form method="post" enctype="multipart/form-data">
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
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="fn">First name</label>
                            <input type="text" style="text-transform: capitalize" class="form-control" id="fn" name="first_name" value="<?php echo $first_name; ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ln">Last name</label>
                            <input type="text" style="text-transform: capitalize" class="form-control" id="ln" name="last_name" value="<?php echo $last_name; ?>" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" value="<?php echo $email; ?>" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="Gender">Gender</label>
                            <br>
                            <div class="custom-control custom-radio custom-control-inline">
                                <?php
                                if ($gender == 'male') {
                                    $attr = 'checked';
                                } else {
                                    $attr = '';
                                }
                                ?>
                                <input type="radio" id="male" name="gender" value="male" class="custom-control-input" <?php echo $attr; ?> />
                                <label class="custom-control-label radio" for="male">Male</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <?php
                                if ($gender == 'female') {
                                    $attr = 'checked';
                                } else {
                                    $attr = '';
                                }
                                ?>
                                <input type="radio" id="female" name="gender" value="female" class="custom-control-input" <?php echo $attr; ?> />
                                <label class="custom-control-label radio" for="female">Female</label>
                            </div>
                            <!--
                            <select id="Gender" class="form-control" name="gender">
                                <option selected>Your gender is...</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
-->
                        </div>
                        <div class="form-group col-md-4">
                            <label for="specialization">Specialization</label>
                            <input type="text" class="form-control" id="specialization" placeholder="e.g: Software engineering" name="specialization" value="<?php echo $specialization; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="phone">Phone number</label>
                            <input type="text" class="form-control" id="phone" placeholder="059 **** ***" name="phone" value="<?php echo $phone; ?>">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="Bio">Bio</label>
                        <textarea class="form-control" id="Bio" placeholder="Tell people about yourself" name="bio"><?php echo $bio; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Profile image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <div class="form-group row ">
                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-primary" name="update">Update profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->

<?php include '../dashboard-footer.php'; ?>