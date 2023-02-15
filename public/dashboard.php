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
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<?php    
    $user = $_SESSION['user'];
    ?>
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
    <div class="p-5 w-full">
        <div class="w-full flex justify-center">
            <table class="table-auto rounded-lg w-3/4">
                <tr class="bg-gradient-to-b from-orange-500 to-orange-400">
                    <th class="text-left">Tytuł</th>
                    <th class="text-left">Data utworzenia</th>
                    <th class="text-left">Autor</th>
                    <th class="text-left">Akcje</th>
                </tr>
                <?php
                $isEven = false;
                $PostDAO = new PostDAO($db);
                if($user->getRole() == User::roles["Admin"])
                    $posts = $PostDAO->findAll();
                else
                    $posts = $PostDAO->findAllByUserId($user->getId());
                foreach($posts as $post)
                {   
                    echo("<tr class='". ($isEven ? "bg-zinc-200 hover:bg-orange-300" : "bg-zinc-100 hover:bg-orange-300") ."'>");
                    $isEven =! $isEven;
                    $title = $post->getTitle();
                    $id = $post->getId();
                    echo("<a href='post.php?id=$id'><td>$title</td>");
                    $dateTime = $post->getCreateTime();
                    echo("<td>$dateTime</td></a>");
                    $authorName = $post->getAuthorName();
                    echo("<td>$authorName</td></a>");
                    echo("<td><a href='post.php?id=$id'>Pokaż</a></td>");
                    echo("</tr>");
                }
                ?>
            </table>
        </div>
    </div>
    <div class="w-full flex justify-center">
        <div class="w-3/4">
            <a href="createpost.php"><button class="p-2 bg-orange-500 hover:bg-orange-500 rounded-lg text-neutral-50 ml-4">Utwórz zgłoszenie</button></a>
        </div>
    </div>
    
</body>
</html>
