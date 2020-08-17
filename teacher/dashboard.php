<?php
$page_title = 'Patron - Home';
include '../dashboard-header.php'; ?>

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
                            <h3>Subjects</h3>
                            <a href="subjects.php">View more ></a>
                        </div>
                        <i class="dash-icon fas fa-book-open"></i>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Here you can create subjects for your students, view and manage all your subjects easly.</p>
                        <a href="create-subject.php">Create new Subject</a>
                    </div>
                </div>
            </div>
            <div class="dash-cards col-lg-4">
                <div class="card dash-card bg-light mb-3">
                    <div class="card-header">
                        <div class="head">
                            <h3>Quizzes</h3>
                            <a href="view-quizzes.php">View more ></a>
                        </div>
                        <i class="dash-icon fas fa-question-circle"></i>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Here you can create unlimited amount of quizzes, and view all your quizzes for all your subjects.</p>
                        <a href="view-quizzes.php">View all quizzes </a>
                    </div>
                </div>
            </div>
            <div class="dash-cards col-lg-4">
                <div class="card dash-card bg-light mb-3">
                    <div class="card-header">
                        <div class="head">
                            <h3>Quizzes Results</h3>
                            <a href="view-results.php">View more ></a>
                        </div>
                        <i class="dash-icon fas fa-chart-pie"></i>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Here you will get all the analysis results for all the quizzes you made for all your subjects.</p>
                        <a href="view-results.php">View results</a>
                    </div>
                </div>
            </div>

        </div>



    </div>
</div> <!-- .cd-content-wrapper -->
</main> <!-- .cd-main-content -->

<?php include '../dashboard-footer.php'; ?>