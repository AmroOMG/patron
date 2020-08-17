<?php
session_start();
include 'inc/db.php';

if (isset($_SESSION['first_name'])) {
  if ($_SESSION['rule'] == 'teacher') {
    header("Location: teacher/dashboard.php");
  } elseif ($_SESSION['rule'] == 'student') {
    header("Location: student/std-dashboard.php");
  }
}

$email = '';
$pass = '';

if (isset($_POST['login'])) {
  $email = htmlspecialchars($_POST['email']);
  $pass = htmlspecialchars($_POST['password']);

  $sql = "SELECT * FROM users WHERE email = '$email'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    $password = sha1($pass);
    if ($row['password'] == $password) {
      $_SESSION['id'] = $row['id'];
      $_SESSION['first_name'] = $row['first_name'];
      $_SESSION['last_name'] = $row['last_name'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['rule'] = $row['rule'];
      $_SESSION['gender'] = $row['gender'];
      $_SESSION['phone'] = $row['phone'];
      $_SESSION['bio'] = $row['bio'];
      $_SESSION['specialization'] = $row['specialization'];

      if ($row['rule'] == 'teacher') {
        header("Location: teacher/dashboard.php");
      } elseif ($row['rule'] == 'student') {
        header("Location: student/std-dashboard.php");
      }
    } else {
      $error = "Sorry, Incorrect password !";
    }
  } else {
    $error = "Sorry, Email is not exist, try to register";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Patron - Login</title>
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
  <link href="css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/sign_style.css" type="text/css" media="all" />
  <!--//Style-CSS -->
</head>

<body>
  <!-- /sginup-section -->
  <section class="w3l-login-6">
    <div class="login-hny">
      <div class="form-content">
        <div class="form-right">
          <div class="overlay">
            <div class="grid-info-form">
              <h2><a href="index.php">PATRON</a></h2>
              <h3>LOGIN</h3>
              <p>
                Patron is an platform that provides integrated,
                educational-leading technology that enables teachers to make
                an online quiz to their students in a modern way and get
                analyzed feedback about the answers of the students.
              </p>
              <h5>Does not have account yet?</h5>
              <a href="signup.php" class="read-more-1 btn">Register now</a>
            </div>
          </div>
        </div>
        <div class="form-left">
          <div class="middle">
            <h4>Login</h4>
            <p>Patron wishes you a good day.</p>
          </div>
          <form action="" method="post" class="signin-form">
            <?php if (isset($error) && !empty($error)) { ?>
              <div class="alert alert-danger" role="alert">
                <i class="far fa-times-circle"></i>
                <?php echo $error; ?>
              </div>
            <?php } ?>
            <div class="form-input">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="" required />
            </div>
            <div class="form-input">
              <label for="pass">Password</label>
              <input type="password" id="pass" name="password" value="<?php echo $pass; ?>" placeholder="" required />
            </div>

            <button class="btn" type="submit" name="login">Login</button>
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