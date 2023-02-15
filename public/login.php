<?php
    session_start();
    if(isset($_SESSION['user']) && !is_null($_SESSION['user']))
        {
            header('Location: dashboard.php');
            exit();
        }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php
    require_once '../Auth/UserDAO.php';
    require_once '../Auth/User.php';
    require_once '../Database/config.php';

    $userDAO = new UserDAO($db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $userDAO->findByUsername($username);

        if ($user && password_verify($password, $user->getPassword())) {
            $_SESSION['user'] = $user;
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Nieprawidłowy login lub hasło';
        }
    }
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
    
    
    <?php 
        if(isset($error))
            echo "<p class='text-red-700'>$error</p>"
    ?>
    <div class="p-5 w-full flex justify-center">
        <div class="w-3/4">
            <h2 class="text-3xl">Login</h2><br>
            <form method="post">
                <label class="text-xl" for="username">Nazwa użytkownika:</label><br>
                <input class="bg-orange-200 border-2 border-neutral-700 rounded" type="text" id="username" name="username" required><br>
                <label class="text-xl" for="password">Hasło:</label><br>
                <input class="bg-orange-200 border-2 border-neutral-700 rounded" type="password" id="password" name="password" required><br><br>
                <button class="bg-orange-500 hover:bg-orange-600 p-2 border-2 border-neutral-100 text-neutral-50 rounded-lg" type="submit">Zaloguj się!</button>
            </form>
            <p class="text-lg">Nie masz jeszcze konta? <a class="text-orange-600 hover:text-orange-800" href="register.php">Zarejestruj się!</a></p>
        </div>
    </div>
</body>
</html>