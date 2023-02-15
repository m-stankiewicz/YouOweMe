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
        if(!isset($_POST['title']) || is_null($_POST['title']) || empty($_POST['title']))
            $errors[] = "Zgłoszenie musi mieć tytuł";
        if(!isset($_POST['description']) || is_null($_POST['description']) || empty($_POST['description']))
            $errors[] = "Zgłoszenie musi mieć opis";
        if(empty($errors))
        {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $postDAO = new PostDAO($db);
            $postDAO->createPost($title, $description, $user->getId());
            header('Location: dashboard.php');
            exit();

        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utwórz zgłoszenie</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="w-full bg-orange-600 p-4 flex">
        <div class="text-3xl font-bold text-neutral-50 w-1/6 text-center">
            <a href="/">YOM</a>
        </div>
        <div class="text-neutral-50 w-2/3 flex">
            <?php
            if(isset($_SESSION["user"])) { 
                ?>

                <a class="pt-2 mx-4" href="dashboard.php">Posty</a>
                <a class="pt-2 mx-4" href="users.php">Użytkownicy</a>
            <?php } ?>
        </div>
        <div class="text-neutral-50 w-1/6 flex">
            <?php
            if(isset($_SESSION["user"])) { 
                ?>
            <a class="bg-red-600 hover:bg-red-700 py-2 px-3 rounded-lg" href="logout.php">Wyloguj</a>
            <?php
                }
                else
                { ?> 
                
                <a class="bg-green-600 hover:bg-green-700 py-2 px-3 rounded-lg" href="login.php">Zaloguj</a>

            <?php

                }
            ?>
        </div>
    </div>
    <div class="p-5 w-full flex justify-center">
        <div class="w-3/4">
            <h1 class="text-2xl">Utwórz post</h1>
    <form action="createpost.php" method="post">
        <?php 
        foreach($errors as $error)
        {
            echo "<p class='text-red-600'>$error</p>";
        }
        ?>
        <p class="text-lg">Tytuł</p>
        <input class="w-full bg-orange-200 border-2 border-neutral-700 rounded" type="text" name="title" value="<?php if(isset($_POST['title'])) echo($_POST['title']); ?>">
        <p class="text-lg">Treść zgłoszenia</p>
        <textarea class="w-full bg-orange-200 border-2 border-neutral-700 rounded" name="description" id="description" rows="10" placeholder="Mam problem z..."></textarea><?php if(isset($_POST['description'])) echo($_POST['description']); ?><br>
        <button class="bg-orange-500 hover:bg-orange-600 p-2 border-2 border-neutral-100 text-neutral-50 rounded-lg" type="submit">Utwórz</button>
    </form></div></div>
</body>
</html>