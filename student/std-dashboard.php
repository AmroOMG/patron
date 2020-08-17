<?php
$page_title = 'Patron - Home';
include '../std-dashboard-header.php'; ?>

<div class="cd-content-wrapper">
    <!-- main content here -->
    <div class="container-fluid no-gutters">
        <div class="row no-gutters">


            <div class="col">
                <div class="hero hero-dashboard">
                    <div class="layout">
                        <h3>Hi <span><?php echo $_SESSION['first_name']; ?></span></h3>
                        <p>we wish you having a good day.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">

            <div class="dash-cards col-lg-4">
                <div class="card dash-card bg-light mb-3">
                    <div class="card-header">
                        <div class="head">
                            <h3>Join Subject</h3>
                            <a href="join-subject.php">Join Subject ></a>
                        </div>
                        <i class="dash-icon fas fa-plus-circle"></i>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Here you can join any subject by searching its name or id, enter its join code if it's a private subject.</p>
                        <a href="join-subject.php">Join new Subject</a>
                    </div>
                </div>
            </div>
            <div class="dash-cards col-lg-4">
                <div class="card dash-card bg-light mb-3">
                    <div class="card-header">
                        <div class="head">
                            <h3>Subjects</h3>
                            <a href="std-subjects.php">View more ></a>
                        </div>
                        <i class="dash-icon fas fa-book-open"></i>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Here you can view all the subjects that you had joined and view any subject details.</p>
                        <a href="join-subject.php">Join new subject</a>
                    </div>
                </div>
            </div>
            <div class="dash-cards col-lg-4">
                <div class="card dash-card bg-light mb-3">
                    <div class="card-header">
                        <div class="head">
                            <h3>Quizzes</h3>
                            <a href="std-quizzes.php">View more ></a>
                        </div>
                        <i class="dash-icon fas fa-question-circle"></i>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Here you can view all quizzes for all subjects you had joined, to attened any quiz in it's time.</p>
                        <a href="std-quizzes.php">View quizzes</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->

<?php include '../std-dashboard-footer.php'; ?>