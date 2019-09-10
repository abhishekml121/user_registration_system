<?php
session_start();
$location = './index.php';

unset($_SESSION['save_user_email_navigation']);
header("Location: " . $location);

?>