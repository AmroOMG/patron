<?php
session_start();
include '../inc/db.php';

if (!isset($_SESSION['email']) || ($_SESSION['rule'] != 'teacher')) {
    header("Location: ../login.php");
}

$teacher_id = $_SESSION['id'];

$sql = "SELECT * FROM subjects WHERE teacher_id = $teacher_id ";
$result = mysqli_query($conn, $sql);
$subjects_count = mysqli_num_rows($result);

$sql = "SELECT * FROM quiz WHERE teacher_id = $teacher_id ";
$result = mysqli_query($conn, $sql);
$quizzes_count = mysqli_num_rows($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $page_title; ?></title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <meta name="keywords" content="patron online quiz platform forr creating online quiz for students in schools and universities, that helps teachers and students in the education proccess with less effort and cost" />
    <meta name="description" content="We provide integrated, educational-leading technology that enables teachers to make an online quiz to their students in a modern way and get analyzed feedback about the answers of the students." />
    <link rel="icon" href="../images/icon.png">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="../css/all.min.css" rel="stylesheet">
    <link href="../css/nav-style.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard-style.css" type="text/css" media="all" />
</head>

<body>

    <header class="cd-main-header js-cd-main-header">
        <div class="cd-logo-wrapper">
            <h1><a href="../index.php" class="cd-logo">PATRON</a></h1>
        </div>

        <div class="cd-search js-cd-search">
            <form>
                <input class="reset" type="search" placeholder="Search...">
            </form>
        </div>

        <button class="reset cd-nav-trigger js-cd-nav-trigger" aria-label="Toggle menu"><span></span></button>

        <ul class="cd-nav__list js-cd-nav__list">

            <li class="cd-nav__item cd-nav__item--has-children cd-nav__item--account js-cd-item--has-children">

                <a href="teacher-profile.php?id=<?php echo $teacher_id; ?>">
                    <i class="far fa-user-circle"></i>
                    <span><?php echo $_SESSION['first_name']; ?> <?php echo $_SESSION['last_name']; ?></span>
                </a>

                <ul class="cd-nav__sub-list">
                    <li class="cd-nav__sub-item">

                        <a href="teacher-profile.php?id=<?php echo $teacher_id; ?>"> Profile</a>
                    </li>
                    <li class="cd-nav__sub-item">

                        <a href="../logout.php?logout-submit=logout">Logout</a>
                    </li>
                    <!-- other list items here -->
                </ul>
            </li>
        </ul>
    </header> <!-- .cd-main-header -->

    <main class="cd-main-content">
        <nav class="cd-side-nav js-cd-side-nav">
            <ul class="cd-side__list js-cd-side__list">
                <li class="cd-side__label"><span><i class="fas fa-tachometer-alt"></i> Dashboard</span></li>
                <li class="cd-side__item cd-side__item--has-children cd-side__item--overview js-cd-item--has-children">
                    <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>


                </li>

                <li class="cd-side__item cd-side__item--has-children cd-side__item--notifications cd-side__item--selected js-cd-item--has-children">

                    <a href="subjects.php"><i class="fas fa-book-open"></i> Subjects<span class="cd-count"><?php echo $subjects_count; ?></span></a>

                    <ul class="cd-side__sub-list">
                        <li class="cd-side__sub-item"><a href="subjects.php"><i class="fas fa-server"></i> View subjects</a></li>
                        <li class="cd-side__sub-item"><a href="create-subject.php"><i class="fas fa-plus-circle"></i> Create subject</a></li>
                        <!-- other list items here -->
                    </ul>
                </li>

                <li class="cd-side__item cd-side__item--has-children cd-side__item--notifications cd-side__item--selected js-cd-item--has-children">

                    <a href="view-quizzes.php"><i class="fas fa-question-circle"></i> Quizzes<span class="cd-count"><?php echo $quizzes_count; ?></span></a>

                    <ul class="cd-side__sub-list">
                        <li class="cd-side__sub-item"><a href="view-quizzes.php"><i class="fas fa-server"></i> View quizzes</a></li>
                        <!--  <li class="cd-side__sub-item"><a href="create-quiz.php"><i class="fas fa-plus-circle"></i> Create quiz</a></li> -->
                        <!-- other list items here -->
                    </ul>
                </li>

                <li class="cd-side__item cd-side__item--has-children cd-side__item--overview js-cd-item--has-children">
                    <a href="view-results.php"><i class="fas fa-chart-pie"></i> Analysis results</a>


                </li>
                <!-- other list items here -->
            </ul>

            <!-- other unordered lists here -->
        </nav>