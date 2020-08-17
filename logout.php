<?php
session_start();
include 'inc/db.php';

if (isset($_GET['logout-submit']) && $_GET['logout-submit'] == 'logout') {
    session_destroy();
    session_unset();
    header("Location: login.php");
}
