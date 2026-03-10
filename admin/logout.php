<?php
require_once '../config/auth.php';

// Logout user
logoutAdmin();

// Redirect to login page
header('Location: ../login.php');
exit;
?>
