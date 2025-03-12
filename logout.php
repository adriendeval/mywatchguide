<?php
session_start();
include 'includes/functions.php';

logout();
header('Location: login.php');
exit;
?>