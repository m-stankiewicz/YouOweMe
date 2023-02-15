<?php
session_start();
require_once '../Auth/LogoutController.php';

$logoutController = new LogoutController();
$logoutController->logout();

header('Location: login.php');
exit();
?>