<?php
ob_start();
$page_title = 'Patron - Analysis Result';
include '../dashboard-header.php';

$teacher_id = $_SESSION['id'];

?>
<div class="cd-content-wrapper">
    <!-- main content here -->
    <div class="container-fluid no-gutters">
        <div class="row no-gutters">
            <div class="col">
                <div class="hero hero-subject">
                    <div class="layout">
                        <h3><span>Subject title</span><br>Analysis result</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col">
                </div>
            </div>
        </div>
    </div> <!-- .cd-content-wrapper -->
</div>
</main> <!-- .cd-main-content -->

<?php include '../dashboard-footer.php'; ?>