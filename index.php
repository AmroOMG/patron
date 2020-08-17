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

if (isset($_POST['subscribe'])) {
    $subscribe_email = htmlspecialchars($_POST['EMAIL']);

    $sql = "SELECT * FROM subscribers WHERE (email = '$subscribe_email')";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
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
<html lang="en">

<head>
    <title>Patron - Online Quiz Platform</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <meta name="keywords" content="patron online quiz platform forr creating online quiz for students in schools and universities, that helps teachers and students in the education proccess with less effort and cost" />
    <meta name="description" content="We provide integrated, educational-leading technology that enables teachers to make an online quiz to their students in a modern way and get analyzed feedback about the answers of the students." />
    <link rel="icon" href="images/icon.png">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!-- Fonts -->
    <!--
    <link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700" rel="stylesheet">
-->
    <!-- //Fonts -->
    <script>
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
</head>

<body>
    <!-- home -->
    <div id="home">
        <!-- banner -->
        <div class="top_w3pvt_main container">

            <!-- nav -->
            <div class="nav_w3pvt text-center ">
                <!-- nav -->
                <nav class="lavi-wthree">
                    <div id="logo">
                        <h1> <a class="navbar-brand" href="index.php">Patron</a>
                        </h1>
                    </div>

                    <label for="drop" class="toggle">Menu</label>
                    <input type="checkbox" id="drop" />
                    <ul class="menu mr-auto">
                        <li class="active"><a href="index.php">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li>
                            <!-- First Tier Drop Down -->
                            <label for="drop-2" class="toggle">Drop Down<span class="fa fa-angle-down" aria-hidden="true"></span> </label>
                            <a href="#">Platform <span class="fa fa-angle-down" aria-hidden="true"></span></a>
                            <input type="checkbox" id="drop-2" />
                            <ul>
                                <li><a href="#features">Features</a>
                                </li>
                                <li><a href="#services">Services</a>
                                </li>
                                <li><a href="#team">Team</a>
                                </li>
                                <li><a href="#test">Testimonials</a>
                                </li>

                            </ul>
                        </li>
                        <li><a href="contact.php" target="_blank">Contact</a>
                            <?php
                            if (isset($_SESSION['email'])) {
                                if ($_SESSION['rule'] == 'teacher') { ?>
                        <li class="log-vj ml-lg-5">
                            <a href="teacher/dashboard.php" target="_blank"><span class="far fa-user-circle" aria-hidden="true"></span>
                                <?php echo $_SESSION['first_name']; ?> </a>
                        </li>
                    <?php  } elseif ($_SESSION['rule'] == 'student') { ?>
                        <li class="log-vj ml-lg-5">
                            <a href="student/std-dashboard.php" target="_blank"><span class="far fa-user-circle" aria-hidden="true"></span>
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
        <!-- banner slider -->
        <div id="homepage-slider" class="st-slider">
            <input type="radio" class="cs_anchor radio" name="slider" id="play1" checked="" />
            <input type="radio" class="cs_anchor radio" name="slider" id="slide1" />
            <input type="radio" class="cs_anchor radio" name="slider" id="slide2" />
            <input type="radio" class="cs_anchor radio" name="slider" id="slide3" />
            <div class="images">
                <div class="images-inner">
                    <div class="image-slide">
                        <div class="banner-w3pvt-1">
                            <div class="overlay-wthree"></div>

                        </div>
                    </div>
                    <div class="image-slide">
                        <div class="banner-w3pvt-2">
                            <div class="overlay-wthree"></div>
                        </div>
                    </div>
                    <div class="image-slide">
                        <div class="banner-w3pvt-3">
                            <div class="overlay-wthree"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="labels">
                <div class="fake-radio">
                    <label for="slide1" class="radio-btn"></label>
                    <label for="slide2" class="radio-btn"></label>
                    <label for="slide3" class="radio-btn"></label>
                </div>
            </div>
            <!-- banner-w3ls-info -->
            <div class="banner-w3ls-info">
                <div class="content-bg-1 one-bg">
                    <span class="fa fa-lightbulb-o" aria-hidden="true"></span>
                    <h3 class="ban-text">
                        Creative Quiz Pattern
                    </h3>
                </div>
                <div class="content-bg-1 two-bg">
                    <span class="fa fa-bolt"></span>
                    <h3 class="ban-text">
                        Quick Quiz Creating &amp; Editing
                    </h3>
                </div>
                <div class="content-bg-1 third-bg">
                    <span class="fas fa-chart-pie" aria-hidden="true"></span>
                    <h3 class="ban-text">
                        Quiz Results Analysis
                    </h3>
                </div>
            </div>
            <!-- //banner-w3ls-info -->
        </div>
        <!-- //banner slider -->
    </div>
    <!-- //banner -->

    <!-- //home -->

    <!-- about -->
    <section class="about py-5">
        <div class="container py-md-5">
            <div class="about-w3ls-info text-center mx-auto" id="about">
                <h3 class="tittle-wthree pt-md-5 pt-3">About Patron</h3>
                <p class="sub-tittle mt-3 mb-sm-5 mb-4">Patron is an platform that provides integrated, educational-leading technology that enables teachers to make an online quiz to their students in a modern way and get analyzed feedback about the answers of the students.</p>
                <!--                <a href="single.html" class="btn btn-primary submit">Read More</a>-->
            </div>
        </div>
    </section>
    <!-- //about -->
    <!-- /features -->
    <div class="welcome py-5" id="features">
        <div class="container py-xl-5 py-lg-3">
            <div class="row">
                <div class="col-lg-5 welcome-left">
                    <p>What We Provide</p>
                    <h3 class="tittle-wthree mt-2 mb-3">We Rank the Best
                        Quizzes on the Web</h3>

                    <p class="mt-4 pr-lg-5">The fast &amp; visual way to quiz your students by creating classes with question banks and managing is easily, and everything your need to make an online quiz and analyze the students answers.</p>
                </div>
                <div class="col-lg-7 welcome-right text-center mt-lg-0 mt-5">
                    <div class="row">

                        <div class="col-sm-4 service-1-w3ls serve-gd2">
                            <div class="serve-grid mt-4">
                                <span class="fas fa-file-invoice s2"></span>
                                <p class="mt-2">Quizzes</p>
                            </div>
                            <div class="serve-grid mt-4">
                                <span class="fas fa-user-graduate s1"></span>
                                <p class="mt-2">Students </p>
                            </div>
                        </div>
                        <div class="col-sm-4 service-1-w3ls serve-gd3">
                            <div class="serve-grid mt-4">
                                <span class="fas fa-briefcase s4"></span>
                                <p class="mt-2">Trainers</p>
                            </div>
                            <div class="serve-grid mt-4">
                                <span class="fas fa-school s5"></span>
                                <p class="text-li mt-2">Schools </p>
                            </div>
                            <div class="serve-grid mt-4">
                                <span class="fas fa-university s6"></span>
                                <p class="mt-2">Universities </p>
                            </div>
                        </div>
                        <div class="col-sm-4 service-1-w3ls serve-gd2">
                            <div class="serve-grid mt-4">
                                <span class="fas fa-server s3"></span>
                                <p class="mt-2">Data mining </p>
                            </div>
                            <div class="serve-grid mt-4">
                                <span class="fas fa-chalkboard-teacher s7"></span>
                                <p class="mt-2">Literature</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //features -->

    <!-- services -->
    <section class="services text-center py-5">
        <div class="container py-md-5" id="services">
            <h3 class="tittle-wthree text-center">Patron Services</h3>
            <p class="sub-tittle text-center mt-4 mb-sm-5 mb-4">Everything your need to make an online quiz and analyze the students answers.</p>
            <div class="row ser-sec-1">
                <div class="col-md-4 ser-w3pvt-gd-wthree">
                    <div class="icon">
                        <span class="fa fa-lightbulb-o s1"></span>
                    </div>
                    <!-- Icon ends here -->
                    <div class="service-content">
                        <h5> New Classes</h5>
                        <p class="serp">
                            Create a new class for your students to join it.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 ser-w3pvt-gd-wthree">
                    <div class="icon">
                        <span class="fas fa-database s4"></span>
                    </div>
                    <!-- Icon ends here -->
                    <div class="service-content">
                        <h5>Question Bank</h5>
                        <p class="serp">
                            Manage your class question bank by adding topics and questions.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 ser-w3pvt-gd-wthree">
                    <div class="icon">
                        <span class="fa fa-question-circle s3"></span>
                    </div>
                    <!-- .Icon ends here -->
                    <div class="service-content">
                        <h5>New quizzes</h5>
                        <p class="serp">
                            Create new quiz for your students in any topic and questions.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row ser-sec-1">
                <div class="col-md-4 ser-w3pvt-gd-wthree">
                    <div class="icon">
                        <span class="fab fa-hotjar s6"></span>
                    </div>
                    <!-- Icon ends here -->
                    <div class="service-content">
                        <h5>Powerful platform</h5>
                        <p class="serp">
                            You can deliver online quizzes that adds real value to your educational operation.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 ser-w3pvt-gd-wthree">
                    <div class="icon">
                        <span class="fab fa-creative-commons-nc s5"></span>
                    </div>
                    <!-- Icon ends here -->
                    <div class="service-content">
                        <h5>Totally Free</h5>
                        <p class="serp">
                            You and your students can regest in Patron Platform totally free.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 ser-w3pvt-gd-wthree">
                    <div class="icon">
                        <span class="fas fa-running s6"></span>
                    </div>
                    <!-- .Icon ends here -->
                    <div class="service-content">
                        <h5>Quick &amp; Easy Use</h5>
                        <p class="serp">
                            It’s simple to deliver impactful, accessible quizzes with Patron..
                        </p>
                    </div>
                </div>
            </div>
            <div class="row ser-sec-1">
                <div class="col-md-4 ser-w3pvt-gd-wthree border-bottom-0 bottom-vj-gds">
                    <div class="icon">
                        <span class="fas fa-medkit s3"></span>
                    </div>
                    <!-- Icon ends here -->
                    <div class="service-content">
                        <h5>Support Students</h5>
                        <p class="serp">
                            We are trying to support students to have the quizzes online with lower effort &amp; cost.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 ser-w3pvt-gd-wthree border-bottom-0 bottom-vj-gds">
                    <div class="icon">
                        <span class="fas fa-info s2"></span>
                    </div>
                    <!-- Icon ends here -->
                    <div class="service-content">
                        <h5>Help Trainers</h5>
                        <p class="serp">
                            Trainers also can use this platform to quiz their trainees to asset their levels.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 ser-w3pvt-gd-wthree border-bottom-0">
                    <div class="icon">
                        <span class="fas fa-chart-pie s7"></span>
                    </div>
                    <!-- .Icon ends here -->
                    <div class="service-content">
                        <h5>Data analysis</h5>
                        <p class="serp">
                            Patron deliver you a full analyzing on the answers of the students.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- //services -->
    <!--/mid-content-->
    <!--
    <section class="last-content py-5">
        <div class="container py-md-3 text-center">
            <div class="last-lavi-inner-content px-lg-5">
                <h3 class="mb-4 tittle-wthree">Get started with <span>Online </span> Education !</h3>
                <p class="px-lg-5">Sed ut perspiciatis unde omnis natus error dolor volup tatem ed accus antium dolor emque
                    laudantium, totam rem aperiam, eaqu ipsa quae ab illo quasi architi ecto beatae vitae dicta
                    sunt dolor ipsum.</p>
                <div class="buttons mt-md-4 mt-3">
                    <a href="#apply" class="btn btn-default">Apply Now</a>
                    <a href="contact.html" class="btn btn1"> Hire Us </a>
                </div>
            </div>
        </div>
    </section>
-->
    <section class="section-middle py-5" id="bottom">
        <div class="container py-lg-5">
            <div class="row about-main">
                <div class="col-lg-6 about-text-grid1 text-left">
                    <div class="title-desc">
                        <h4><span></span>Get started</h4>
                        <h3 class="main-title-w3pvt text-capitalize my-4"> Join With Us. We will make the best Education together!</h3>
                    </div>

                </div>
                <div class="col-lg-6 about-right mt-lg-0 mt-4">
                    <p class="">The fast &amp; visual way to quiz your students by creating classes with question banks and managing is easily, and everything your need to make an online quiz and analyze the students answers.</p>
                    <!--                    <hr>-->
                    <p>Create your classroom now! Hurry up. it's totally for Free</p>
                    <div class="mt-4">
                        <a href="signup.php" target="_blank">Sign up</a>
                        <a href="login.php" target="_blank">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--//mid-content-->

    <!-- gallery -->
    <!--
    <div class="gallery py-5 text-center" id="gallery">
        <div class="container py-md-5">
            <h3 class="tittle-wthree text-center">Our Gallery</h3>
            <p class="sub-tittle text-center mt-3 mb-sm-5 mb-4">Sed do eiusmod tempor incididunt ut labore et
                dolore
                magna
                aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
            <div class="row no-gutters">
                <div class="col-md-6 gal-img">
                    <a href="#gal1"><img src="images/g1.jpg" alt="Gallery Image" class="img-fluid"></a>
                </div>
                <div class="col-md-3 gal-img">
                    <a href="#gal2"><img src="images/g2.jpg" alt="Gallery Image" class="img-fluid"></a>
                </div>
                <div class="col-md-3 gal-img">
                    <a href="#gal3"><img src="images/g3.jpg" alt="Gallery Image" class="img-fluid"></a>
                </div>


                <div class="col-md-3 gal-img ml-auto">
                    <a href="#gal5"><img src="images/g5.jpg" alt="Gallery Image" class="img-fluid"></a>
                </div>
                <div class="col-md-3 gal-img mr-auto">
                    <a href="#gal6"><img src="images/g6.jpg" alt="Gallery Image" class="img-fluid"></a>
                </div>
                <div class="col-md-6 gal-img">
                    <a href="#gal4"><img src="images/g4.jpg" alt="Gallery Image" class="img-fluid"></a>
                </div>
            </div>
-->


    <!-- gallery popups -->
    <!-- popup-->
    <!--
            <div id="gal1" class="pop-overlay animate">
                <div class="popup">
                    <img src="images/g1.jpg" alt="Popup Image" class="img-fluid" />
                    <p class="mt-4">Nulla viverra pharetra se, eget pulvinar neque pharetra ac int. placerat placerat
                        dolor.</p>
                    <a class="close" href="#gallery">&times;</a>
                </div>
            </div>
-->
    <!-- //popup -->
    <!-- popup-->
    <!--
            <div id="gal2" class="pop-overlay animate">
                <div class="popup">
                    <img src="images/g2.jpg" alt="Popup Image" class="img-fluid" />
                    <p class="mt-4">Nulla viverra pharetra se, eget pulvinar neque pharetra ac int. placerat placerat
                        dolor.</p>
                    <a class="close" href="#gallery">&times;</a>
                </div>
            </div>
-->
    <!-- //popup -->
    <!-- popup-->
    <!--
            <div id="gal3" class="pop-overlay animate">
                <div class="popup">
                    <img src="images/g3.jpg" alt="Popup Image" class="img-fluid" />
                    <p class="mt-4">Nulla viverra pharetra se, eget pulvinar neque pharetra ac int. placerat placerat
                        dolor.</p>
                    <a class="close" href="#gallery">&times;</a>
                </div>
            </div>
-->
    <!-- //popup3 -->
    <!-- popup-->
    <!--
            <div id="gal4" class="pop-overlay animate">
                <div class="popup">
                    <img src="images/g4.jpg" alt="Popup Image" class="img-fluid" />
                    <p class="mt-4">Nulla viverra pharetra se, eget pulvinar neque pharetra ac int. placerat placerat
                        dolor.</p>
                    <a class="close" href="#gallery">&times;</a>
                </div>
            </div>
-->
    <!-- //popup -->
    <!-- popup-->
    <!--
            <div id="gal5" class="pop-overlay animate">
                <div class="popup">
                    <img src="images/g5.jpg" alt="Popup Image" class="img-fluid" />
                    <p class="mt-4">Nulla viverra pharetra se, eget pulvinar neque pharetra ac int. placerat placerat
                        dolor.</p>
                    <a class="close" href="#gallery">&times;</a>
                </div>
            </div>
-->
    <!-- //popup -->
    <!-- popup-->
    <!--
            <div id="gal6" class="pop-overlay animate">
                <div class="popup">
                    <img src="images/g6.jpg" alt="Popup Image" class="img-fluid" />
                    <p class="mt-4">Nulla viverra pharetra se, eget pulvinar neque pharetra ac int. placerat placerat
                        dolor.</p>
                    <a class="close" href="#gallery">&times;</a>
                </div>
            </div>
-->
    <!-- //popup -->
    <!-- //gallery popups -->
    <!--
        </div>
        </div>
-->
    <!-- //gallery -->

    <!-- team -->
    <section class="team py-5" id="team">
        <div class="container py-xl-5 py-lg-3">
            <div class="heading-grid text-center">
                <h3 class="tittle text-center heading mb-5">Patron Team</h3>
            </div>
            <div class="row inner-sec-w3layouts-w3pvt-lauinfo justify-content-center">
                <div class="col-md-4 col-sm-6">
                    <div class="team-grids text-center">
                        <img src="images/team1.jpg" class="img-fluid" alt="">
                        <div class="social-icons-section">
                            <a class="fac" href="https://www.facebook.com/amrosalama.awesome" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="twitter" href="https://twitter.com/amroOMG" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="google" href="https://www.instagram.com/amro_salama/" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="team-info">
                            <div class="caption">
                                <h4>Amro Salama</h4>
                                <h6>Software Engineer</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mt-sm-0 mt-5">
                    <div class="team-grids text-center">
                        <img src="images/ahmed.jpg" class="img-fluid" alt="">
                        <div class="social-icons-section">
                            <a class="fac" href="#" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="twitter" href="#" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="google" href="#" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="team-info">
                            <div class="caption">
                                <h4>Amro Salama</h4>
                                <h6>Software Engineer</h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- team -->

    <!-- /apply-->
    <section class="apply-main py-5" id="apply">
        <div class="container py-md-5">
            <div class="row">
                <div class="col-lg-7 apply-info px-lg-5">
                    <h3 class="tittle-wthree apply-hd text-white mb-lg-5 mb-3">Create your classroom now! Hurry up. it's totally for Free</h3>
                    <div class="row wthree-stats-inf">
                        <div class="col-6 stats_w3pvt_counter_grid mt-3">
                            <div class="d-flex">
                                <p class="counter">758</p>
                                <p class="para-w3pvt">classes</p>
                            </div>
                        </div>
                        <div class="col-6 stats_w3pvt_counter_grid mt-3">
                            <div class="d-flex">
                                <p class="counter">600</p>
                                <p class="para-w3pvt">Teachers</p>
                            </div>
                        </div>
                        <div class="col-6 stats_w3pvt_counter_grid mt-3">
                            <div class="d-flex">
                                <p class="counter">2422</p>
                                <p class="para-w3pvt">Students</p>
                            </div>
                        </div>
                        <div class="col-6 stats_w3pvt_counter_grid mt-3">
                            <div class="d-flex">
                                <p class="counter">2025</p>
                                <p class="para-w3pvt">Quizzes</p>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-lg-5 login p-md-5 p-4 mx-auto bg-white mw-100">
                    <h5 class="text-center mb-4">Join Us Now</h5>
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
                        <div class="form-group">
                            <label for="fn">First name</label>

                            <input type="text" class="form-control" name="first_name" value="<?php echo $first_name; ?>" placeholder="" required id="fn">
                        </div>
                        <div class="form-group">
                            <label for="ln">Last name</label>
                            <input type="text" class="form-control" name="last_name" value="<?php echo $last_name; ?>" placeholder="" required id="ln">
                        </div>

                        <div class="form-group">
                            <label for="em">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="" required id="em">
                        </div>

                        <div class="form-group mb-4">
                            <label class="mb-2" for="pass">Password</label>
                            <input type="password" class="form-control" name="password" value="<?php echo $pass; ?>" placeholder="" required id="pass">
                        </div>

                        <div class="form-group mb-4">
                            <label class="mb-4" id="rule">account rule</label>
                            <br>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="Teacher" name="rule" value="teacher" class="custom-control-input" required>
                                <label class="custom-control-label" for="Teacher">Teacher</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="Student" name="rule" value="student" class="custom-control-input" required>
                                <label class="custom-control-label" for="Student">Student</label>
                            </div>
                        </div>

                        <button type="submit" name="signin" class="btn btn-primary submit mb-4">Register</button>

                    </form>

                </div>
            </div>
        </div>
    </section>
    <!-- //apply -->
    <!-- testimonials -->
    <section class="testimonials py-5" id="test">
        <div class="container py-xl-5 py-lg-3">
            <h3 class="tittle-wthree text-center">Testimonials</h3>
            <p class="sub-tittle text-center mt-4 mb-sm-5 mb-4">This is why we do what we do.</p>
            <div class="row">
                <div class="col-lg-4 testimonials_grid mt-3">
                    <div class="p-lg-5 p-4 testimonials-gd-vj">
                        <p class="sub-test"><span class="fa fa-quote-left s4" aria-hidden="true"></span> Patron platform is excellent choice for teachers and trainers, it's quick and easy to use.
                        </p>
                        <div class="row mt-4">
                            <div class="col-3 testi-img-res">
                                <img src="images/te1.jpg" alt=" " class="img-fluid" />
                            </div>
                            <div class="col-9 testi_grid">
                                <h5 class="mb-2">Eng.Mohamed Naji</h5>
                                <p>web developer</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 testimonials_grid mt-3">
                    <div class="p-lg-5 p-4 testimonials-gd-vj">
                        <p class="sub-test"><span class="fa fa-quote-left s4" aria-hidden="true"></span> one of the greatest online educational platforms, its quick and easy to use and provide data analysis.
                        </p>
                        <div class="row mt-4">
                            <div class="col-3 testi-img-res">
                                <img src="images/te3.jpg" alt=" " class="img-fluid" />
                            </div>
                            <div class="col-9 testi_grid">
                                <h5 class="mb-2">Dane Walker</h5>
                                <p>Trainer</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 testimonials_grid mt-3">
                    <div class="p-lg-5 p-4 testimonials-gd-vj">
                        <p class="sub-test"><span class="fa fa-quote-left s4" aria-hidden="true"></span>I have used patron, and it's so much good and quick in use.
                        </p>
                        <div class="row mt-4">
                            <div class="col-3 testi-img-res">
                                <img src="images/te2.jpg" alt=" " class="img-fluid" />
                            </div>
                            <div class="col-9 testi_grid">
                                <h5 class="mb-2">Dr.Ahmed Rami</h5>
                                <p>IT Teacher</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <!-- //testimonials -->

    <!-- footer -->
    <footer class="py-5">
        <div class="container py-sm-3">
            <div class="row footer-grids">
                <div class="col-lg-3 col-sm-6 mb-lg-0 mb-sm-5 mb-4">
                    <h2 class="brand"> <a class="navbar-brand mb-3" href="index.php">patron</a>
                    </h2>
                    <p class="mb-3">Patron is an platform that provides integrated, educational-leading technology that enables teachers to make an online quiz to their students in a modern way and get analyzed feedback about the answers of the students.</p>
                    <h5>Trusted by <span>500+ People</span> </h5>
                </div>
                <div class="col-lg-3 col-sm-6 mb-md-0 mb-sm-5 mb-4">
                    <h4 class="mb-4">Address Info</h4>
                    <p><span class="fa mr-2 fa-map-marker"></span>Gaza <span>Palestine.</span></p>
                    <p class="phone py-2"><span class="fa mr-2 fa-phone"></span> &#40;+972&#41; 0599626639 </p>
                    <p><span class="fa mr-2 fa-envelope"></span><a href="mailto:amrosalama66@gmail.com">amrosalama66@gmail.com</a></p>
                </div>
                <div class="col-lg-2 col-sm-6 mb-lg-0 mb-sm-5 mb-4">
                    <h4 class="mb-4">Quick Links</h4>
                    <ul>
                        <li><a href="#about">About us</a></li>
                        <li class="my-2"><a href="#features">Features</a></li>
                        <li><a href="#services">Services</a></li>
                        <li class="mt-2"><a href="#team">Team</a></li>
                        <li class="mt-2"><a href="#test">Testimonials</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <h4 class="mb-4">Subscribe Us</h4>
                    <p class="mb-3">Subscribe to our newsletter</p>
                    <form action="" method="post" class="d-flex newsletter-w3pvt">

                        <input type="email" id="email" name="EMAIL" placeholder="Enter your email here" required="">
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

        <p>© 2020 PATRON. All rights reserved

        </p>
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
            emulatetouch: true,
            scrollspeed: 80,
            mousescrollstep: 80,
            cursordragontouch: true
        });
    </script>
//nice scroll-->
</body>

</html>