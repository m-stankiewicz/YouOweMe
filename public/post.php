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
    
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $postDAO = new PostDAO($db);
        $post = $postDAO->findById($id);
        if(!$post || ($_SESSION['user']->getId()!=$post->getUserId() && $_SESSION['user']->getRole() != User::roles["Admin"]))
        {
            header('Location: dashboard.php');
            exit();
        }

        $commentsDAO = new PostCommentDAO($db);
        $comments = $commentsDAO->findAllById($id);
        
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title><?php echo $post->getTitle(); ?></title>
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
    <div class="p-5 w-full">
        <div class="w-full flex justify-center">
            <div class="w-3/4">
                <div class="bg-orange-200 p-5 rounded-lg border-neutral-500 border-2">
                    <div class="text-3xl"><?php echo $post->getTitle() ?></div>
                    <div class="text-lg"><b>Autor:</b> <?php echo $post->getAuthorName() ?></div>
                    <div class="text-lg"><b>Data utworzenia:</b> <?php echo $post->getCreateTime() ?></div>
                    <p class="text-xl"><b>Opis</b></p>
                    <div class="text-lg"><?php echo nl2br($post->getDescription()) ?></div>
                </div><br><br>
                <div>
                <h1 class="text-3xl">Komentarze</h1>
                <?php
                    $counter = 0;
                    foreach($comments as $comment)
                    {
                        echo "<div class='bg-orange-200 p-5 rounded-lg border-neutral-500 border-2'>
                            <p>#".++$counter."</p>
                            <p><b>Autor: </b>". $comment->getAuthorName()."</p>
                            <p><b>Data: </b>". $comment->getCreateTime()."</p>
                            <p><b>Treść: </b></p>
                            <div>".nl2br($comment->getDescription())."
                            </div>
                        </div><br>";
                    }
                ?>

                <div>
                    <form action="createcomment.php" method="POST">
                        <p>Dodaj komentarz:</p>
                        <input type="hidden" name="post_id" value="<?php echo $post->getId() ?>">
                        <textarea name="comment" class="bg-orange-100 border-2 border-neutral-600 rounded-lg placeholder-black" cols="130"  rows="10" placeholder="Twój komentarz..."></textarea><br>
                        <button class="bg-orange-500 hover:bg-orange-600 text-neutral-50 p-4 rounded-lg" type="submit">Dodaj komentarz</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

        <?php
    }

?>