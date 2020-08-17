<?php
session_start();
include 'inc/db.php';

if (isset($_POST['send'])) {
  $name    = htmlspecialchars($_POST['name']);
  $email   = htmlspecialchars($_POST['email']);
  $message = htmlspecialchars($_POST['message']);

  $sql = "INSERT INTO messages (name,email,message) VALUES ('$name','$email','$message')";
  if (mysqli_query($conn, $sql)) {
    $success = "Thank you for contact us.";
  } else {
    $error = "Sorry, failed to send message !";
  }
}

if (isset($_POST['subscribe'])) {
  $subscribe_email = htmlspecialchars($_POST['EMAIL']);

  $sql = "SELECT * FROM subscribers WHERE email = '$subscribe_email'";
  $result = mysqli_query($conn, $sql);

  if ($row = mysqli_fetch_assoc($result)) {
    $error = "";
  } else {
    $sql = "INSERT INTO subscribers (email) VALUES ('$subscribe_email')";
    if (mysqli_query($conn, $sql)) {
      $success = "";
    } else {
      $error = "";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
  <title>Patron - contact us</title>
  <!-- Meta tag Keywords -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />
  <meta name="keywords" content="patron online quiz platform forr creating online quiz for students in schools and universities, that helps teachers and students in the education proccess with less effort and cost" />
  <meta name="description" content="We provide integrated, educational-leading technology that enables teachers to make an online quiz to their students in a modern way and get analyzed feedback about the answers of the students." />
  <link rel="icon" href="images/icon.png" />
  <link rel="stylesheet" href="css/bootstrap.css" />
  <link href="css/font-awesome.css" rel="stylesheet" />
  <link href="css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
  <!-- Fonts -->
  <!--    <link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet">-->
  <!--    <link href="//fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">-->
  <!--    <link href="//fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700" rel="stylesheet">-->

  <!-- //Fonts -->
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
</head>

<body>
  <!-- home -->
  <div id="home" class="inner-w3pvt-page">
    <div class="overlay-innerpage">
      <!-- banner -->
      <div class="top_w3pvt_main container">
        <!-- nav -->
        <div class="nav_w3pvt text-center ">
          <!-- nav -->
          <nav class="lavi-wthree">
            <div id="logo">
              <h1><a class="navbar-brand" href="index.php">Patron</a></h1>
            </div>

            <label for="drop" class="toggle">Menu</label>
            <input type="checkbox" id="drop" />
            <ul class="menu mr-auto">
              <li class="active"><a href="index.php">Home</a></li>
              <li><a href="index.php#about">About</a></li>
              <li>
                <!-- First Tier Drop Down -->
                <label for="drop-2" class="toggle">Drop Down<span class="fa fa-angle-down" aria-hidden="true"></span>
                </label>
                <a href="#">Platform
                  <span class="fa fa-angle-down" aria-hidden="true"></span></a>
                <input type="checkbox" id="drop-2" />
                <ul>
                  <li><a href="index.php#features">Features</a></li>
                  <li><a href="index.php#services">Services</a></li>
                  <li><a href="index.php#team">Team</a></li>
                  <li><a href="index.php#test">Testimonials</a></li>
                </ul>
              </li>
              <li><a href="contact.php">Contact</a></li>
              <?php
              if (isset($_SESSION['email'])) {
                if ($_SESSION['rule'] == 'teacher') { ?>
                  <li class="log-vj ml-lg-5">
                    <a href="dashboard.php" target="_blank"><span class="far fa-user-circle" aria-hidden="true"></span>
                      <?php echo $_SESSION['first_name']; ?> </a>
                  </li>
                <?php  } elseif ($_SESSION['rule'] == 'student') { ?>
                  <li class="log-vj ml-lg-5">
                    <a href="std-dashboard.php" target="_blank"><span class="far fa-user-circle" aria-hidden="true"></span>
                      <?php echo $_SESSION['first_name']; ?> </a>
                  </li>
                <?php } ?>

              <?php } else { ?>
                <li class="log-vj ml-lg-5">
                  <a href="login.php" target="_blank"><span class="far fa-user-circle" aria-hidden="true"></span>
                    login</a>
                </li>
              <?php  }
              ?>

            </ul>
          </nav>
          <!-- //nav -->
        </div>
      </div>
      <!-- //nav -->
    </div>
    <!-- //banner -->
  </div>
  <!-- //home -->

  <!-- about -->
  <section class="about py-5">
    <div class="container py-md-5">
      <h3 class="tittle-wthree text-center">Contact Us</h3>
      <p class="sub-tittle text-center mt-4 mb-sm-5 mb-4">
        To ask a question, or just say "hello", contact us in any convenient way.
      </p>
      <div class="row">
        <div class="col-lg-6 contact-info-left">
          <ul class="list-unstyled w3ls-items">
            <li>
              <div class="row mt-5">
                <div class="col-3">
                  <div class="con-icon">
                    <span class="fa fa-home"></span>
                  </div>
                </div>
                <div class="col-9">
                  <h6>Address</h6>
                  <p>
                    patron <br />Gaza Strip, <br />Palestine.
                  </p>
                </div>
              </div>
            </li>

            <li>
              <div class="row mt-5">
                <div class="col-3">
                  <div class="con-icon">
                    <span class="fa fa-envelope"></span>
                  </div>
                </div>
                <div class="col-9">
                  <h6>Email</h6>
                  <a href="mailto:amrosalama66@gmail.com">amrosalama66@gmail.com</a>
                </div>
              </div>
            </li>
            <li>
              <div class="row mt-5">
                <div class="col-3">
                  <div class="con-icon">
                    <span class="fa fa-phone"></span>
                  </div>
                </div>
                <div class="col-9">
                  <h6>Phone</h6>
                  <p> &#40;+972&#41; 0599626639</p>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="col-lg-6 contact-right-wthree-info login">
          <h5 class="text-center mb-4"></h5>
          <form action="" method="post">
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
            <div class="form-group mt-4">
              <label>Name</label>

              <input type="text" class="form-control" id="validationDefault01" name="name" placeholder="" required />
            </div>
            <div class="form-group mt-4">
              <label>Eamil</label>
              <input type="email" class="form-control" id="validationDefault02" name="email" placeholder="" required />
            </div>

            <div class="form-group mt-4">
              <label class="mb-2">Message</label>
              <textarea class="form-control" name="message" placeholder="" required></textarea>
            </div>
            <button type="submit" name="send" class="btn btn-primary submit mb-4">
              Submit
            </button>
          </form>
        </div>
      </div>

      <div class="map-wthree mt-5 p-2">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d52882.19044114099!2d34.449345956635476!3d31.497104023071895!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14fd7f054e542767%3A0x7ff98dc913046392!2sGaza!5e0!3m2!1sen!2sin!4v1585078141250!5m2!1sen!2sin" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
      </div>
    </div>
  </section>
  <!-- //about -->

  <!-- footer -->
  <footer class="py-5">
    <div class="container py-sm-3">
      <div class="row footer-grids">
        <div class="col-lg-3 col-sm-6 mb-lg-0 mb-sm-5 mb-4">
          <h2 class="brand">
            <a class="navbar-brand mb-3" href="index.php">patron</a>
          </h2>
          <p class="mb-3">
            Patron is an platform that provides integrated,
            educational-leading technology that enables teachers to make an
            online quiz to their students in a modern way and get analyzed
            feedback about the answers of the students.
          </p>
          <h5>Trusted by <span>500+ People</span></h5>
        </div>
        <div class="col-lg-3 col-sm-6 mb-md-0 mb-sm-5 mb-4">
          <h4 class="mb-4">Address Info</h4>
          <p>
            <span class="fa mr-2 fa-map-marker"></span>Gaza
            <span>Palestine.</span>
          </p>
          <p class="phone py-2">
            <span class="fa mr-2 fa-phone"></span> &#40;+972&#41; 0599626639
          </p>
          <p>
            <span class="fa mr-2 fa-envelope"></span><a href="mailto:amrosalama66@gmail.com">amrosalama66@gmail.com</a>
          </p>
        </div>
        <div class="col-lg-2 col-sm-6 mb-lg-0 mb-sm-5 mb-4">
          <h4 class="mb-4">Quick Links</h4>
          <ul>
            <li><a href="index.php#about">About us</a></li>
            <li class="my-2"><a href="index.php#features">Features</a></li>
            <li><a href="index.php#services">Services</a></li>
            <li class="mt-2"><a href="index.php#team">Team</a></li>
            <li class="mt-2"><a href="index.php#test">Testimonials</a></li>
          </ul>
        </div>
        <div class="col-lg-4 col-sm-6">
          <h4 class="mb-4">Subscribe Us</h4>
          <p class="mb-3">Subscribe to our newsletter</p>
          <form action="" method="post" class="d-flex newsletter-w3pvt">
            <input type="email" id="email" name="EMAIL" placeholder="Enter your email here" required />
            <button type="submit" name="subscribe" class="btn">Subscribe</button>
          </form>
          <div class="icon-social mt-4">
            <a href="https://www.facebook.com/amrosalama.awesome" target="_blank" class="button-footr">
              <span class="fab fa-facebook-f mx-2"></span>
            </a>
            <a href="https://twitter.com/amroOMG" target="_blank" class="button-footr">
              <span class="fab fa-twitter mx-2"></span>
            </a>
            <a href="https://www.instagram.com/amro_salama/" target="_blank" class="button-footr">
              <span class="fab fa-instagram mx-2"></span>
            </a>

            <a href="https://aboutme.google.com/u/0/?referer=gplus" target="_blank" class="button-footr">
              <span class="fab fa-google-plus-g mx-2"></span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- //footer -->
  <!-- copyright -->
  <div class="copy_right p-3 d-flex justify-content-around">
    <p>© 2020 PATRON. All rights reserved</p>
    <!-- move top -->
    <div class="move-top">
      <a href="#home" class="move-top">
        <span class="fa fa-angle-double-up mt-3" aria-hidden="true"></span>
      </a>
    </div>
    <!-- move top -->
  </div>
  <!-- //copyright -->

  <!--
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
  //nice scroll -->
</body>

</html>