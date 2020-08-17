<?php
session_start();
include 'inc/db.php';

$first_name = '';
$last_name  = '';
$email      = '';
$pass       = '';


if (isset($_POST['signin'])) {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name  = htmlspecialchars($_POST['last_name']);
    $email      = htmlspecialchars($_POST['email']);
    $pass       = htmlspecialchars($_POST['password']);
    $rule       = htmlspecialchars($_POST['rule']);

    $sql = "SELECT * FROM users WHERE (email = '$email')";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $error = "Email is already exists, try to login";
    } else {
        $password = sha1($pass);
        $sql = "INSERT INTO users (first_name,last_name,email,password,rule) VALUES ('$first_name','$last_name','$email','$password','$rule')";
        if (mysqli_query($conn, $sql)) {
            $success = "Thank you for registering in Patron platform.";

            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $_SESSION['id'] = $row['id'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['rule'] = $row['rule'];
            $_SESSION['gender'] = $row['gender'];
            $_SESSION['phone'] = $row['phone'];
            $_SESSION['bio'] = $row['bio'];
            $_SESSION['specialization'] = $row['specialization'];

            if ($rule == 'teacher') {
                header("Location: teacher/dashboard.php");
            } elseif ($rule == 'student') {
                header("Location: student/std-dashboard.php");
            }
        } else {
            $error = "Sorry, failed to register !";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Patron - Signup</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="UTF-8" />
    <meta name="keywords" content="patron online quiz platform forr creating online quiz for students in schools and universities, that helps teachers and students in the education proccess with less effort and cost" />
    <meta name="description" content="We provide integrated, educational-leading technology that enables teachers to make an online quiz to their students in a modern way and get analyzed feedback about the answers of the students." />
    <link rel="icon" href="images/icon.png" />
    <script>
        addEventListener(
            "load",
            function() {
                setTimeout(hideURLbar, 0);
            },
            false
        );

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- //Meta tag Keywords -->
    <!--/Style-CSS -->
    <!--    <link rel="stylesheet" href="css/bootstrap.css">-->
    <link href="css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sign_style.css" type="text/css" media="all" />
    <!--//Style-CSS -->
</head>

<body>
    <!-- /sginup-section -->
    <section class="w3l-login-6">
        <div class="login-hny">
            <div class="form-content">
                <div class="form-right ">
                    <div class="overlay">
                        <div class="grid-info-form">
                            <h2><a href="index.php">PATRON</a></h2>
                            <h3>CREATE ACCOUNT</h3>
                            <p>
                                Patron is an platform that provides integrated,
                                educational-leading technology that enables teachers to make
                                an online quiz to their students in a modern way and get
                                analyzed feedback about the answers of the students.
                            </p>
                            <h5>Already have account?</h5>
                            <a href="login.php" class="read-more-1 btn">Login</a>
                        </div>
                    </div>
                </div>
                <div class="form-left">
                    <div class="middle">
                        <h4>Join Us</h4>
                        <p>Create Your Account, It's Free.</p>
                    </div>
                    <form action="" method="post" class="signin-form">
                        <?php if (isset($error) && !empty($error)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="far fa-times-circle"></i>
                                <?php echo $error; ?>
                            </div>
                        <?php } elseif (isset($success) && !empty($success)) { ?>
                            <div class="alert alert-success" role="alert">
                                <i class="far fa-check-circle"></i>
                                <?php echo $success; ?>
                            </div>
                        <?php } ?>
                        <div class="form-input">
                            <label for="fn">First Name</label>
                            <input type="text" id="fn" name="first_name" value="<?php echo $first_name; ?>" placeholder="" required />
                        </div>
                        <div class="form-input">
                            <label for="ln">Last Name</label>
                            <input type="text" id="ln" name="last_name" value="<?php echo $last_name; ?>" placeholder="" required />
                        </div>
                        <div class="form-input">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="" required />
                        </div>
                        <div class="form-input">
                            <label for="pass">Password</label>
                            <input type="password" id="pass" name="password" value="<?php echo $pass; ?>" placeholder="" required />
                        </div>
                        <label for="rule">Account Rule</label>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="teacher" name="rule" value="teacher" class="custom-control-input" required />
                            <label class="custom-control-label radio" for="teacher">Teacher</label>
                            <input type="radio" id="student" name="rule" value="student" class="custom-control-input" required />
                            <label class="custom-control-label radio" for="student">Student</label>
                        </div>

                        <!--
                        <label class="container">I agree to <a href="#">Conditions</a> of Use and <a href="#">Privacy</a>
                            <input type="checkbox">
                            <span class="checkmark"></span>
                        </label>
-->
                        <button class="btn" type="submit" name="signin">Create account</button>
                    </form>
                    <div class="copy-right text-center">
                        <p>
                            © 2020 <a href="index.php" target="_blank">PATRON</a>. All
                            rights reserved
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- //sginup-section -->

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>

    <script>
        $("html").niceScroll({
            cursorcolor: "#ff7d66",
            cursorwidth: "7px",
            cursorborder: 0,
            cursorborderradius: "3px",
        });
    </script>
</body>

</html>