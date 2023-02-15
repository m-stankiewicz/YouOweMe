<?php
    include '../Auth/User.php';
    include '../Auth/UserDAO.php';
    include '../Database/config.php';
    include '../Helpdesk/PostCommentDAO.php';
    include '../Helpdesk/PostDAO.php';
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
    $UserDAO = new UserDAO($db);
    $user = $UserDAO->findById($_SESSION['user']->getId());
    $_SESSION['user'] = $user;
    
?>

<?php
    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        
        if(!isset($_POST['comment']) || is_null($_POST['comment']) || empty($_POST['comment']))
        {
            header('Location: dashboard.php');
            exit();
        }
        
        $postDAO = new PostDAO($db);
        $post = $postDAO->findById($_POST['post_id']);
        if(!$post || $post->getUserId()!=$user->getId() && $user->getRole() != User::roles["Admin"])
        {
            header('Location: dashboard.php');
            exit();
        }
        $description = $_POST['comment'];
        $postCommentDAO = new PostCommentDAO($db);
        $postCommentDAO->createComment($description, $_POST['post_id'], $user->getId());
        header("Location: post.php?id=".$_POST['post_id']);
        exit();
    }
    header("Location: post.php?id=".$_POST['post_id']);
    exit();


?>