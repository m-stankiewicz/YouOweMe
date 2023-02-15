<?php
    include '../Auth/User.php';
    include '../Auth/UserDao.php';
    include '../Database/config.php';
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
    $UserDAO = new UserDAO($db);
    $user = $UserDAO->findById($_SESSION['user']->getId());
    $_SESSION['user'] = $user;
    if($_SESSION['user']->getId() == $_GET['id'])
    {
        header('Location: users.php');
        exit();
    }
    if ($_SESSION['user']->getRole()!=User::roles["Admin"])
    {
        header('Location: dashboard.php');
        exit();
    }
    $userDAO = new UserDAO($db);
    $user = $userDAO->findById($_GET['id']);
    if(!$user)
    {
        header('Location: users.php');
        exit();
    }
    $newRole = $user->getRole() == User::roles["Admin"] ? User::roles["User"] : User::roles["Admin"];
    $userDAO->updateRole($user, $newRole);
    header('Location: users.php');
    exit();
?>

