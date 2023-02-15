<?php
session_start();
if(isset($_SESSION['user']) && !is_null($_SESSION['user']))
{
    header('Location: dashboard.php');
    exit();
}


require_once __DIR__ . '/../Database/config.php';
require_once __DIR__ . '/../Auth/User.php';
require_once __DIR__ . '/../Auth/UserDAO.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    if (empty($username)) {
        $errors[] = 'Nazwa użytkownika jest wymagana';
    }
    if (empty($password)) {
        $errors[] = 'Hasło jest wymagane';
    }
    if (empty($confirm_password)) {
        $errors[] = 'Potwierdzenie hasła jest wymagane';
    }
    if ($password !== $confirm_password) {
        $errors[] = 'Potwierdzenie hasła nie jest takie samo';
    }

    // Check if user with the same username or email already exists
    $userDAO = new UserDAO($db);
    $existing_user = $userDAO->findByUsername($username);

    if ($existing_user) {
        if ($existing_user->getUsername() === $username) {
            $errors[] = 'Ta nazwa użytkownika jest już zajęta';
        }
    }

    // Create new user and store in database
    if (empty($errors)) {
        $userDAO->saveUser($username, password_hash($password, PASSWORD_BCRYPT), User::roles["User"]);
        header('Location: login.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Zarejestruj się</title>
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
    <h1 class="text-3xl">Zarejestruj się</h1>

    <?php if (!empty($errors)): ?>
        <div>
            <?php foreach ($errors as $error): ?>
                <p><?php echo "<p class='text-red-700'>$error</p>" ?></p>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <form method="POST">
        <div>
            <label class="text-xl" for="username">Nazwa użytkownika:</label><br>
            <input class="bg-orange-200 border-2 border-neutral-700 rounded" type="text" id="username" name="username">
        </div>
        <div>
            <label class="text-xl" for="password">Hasło:</label><br>
            <input class="bg-orange-200 border-2 border-neutral-700 rounded" type="password" id="password" name="password">
        </div>
        <div>
            <label class="text-xl" for="confirm_password">Powtórz hasło:</label><br>
            <input class="bg-orange-200 border-2 border-neutral-700 rounded" type="password" id="confirm_password" name="confirm_password">
        </div><br>
        <button class="bg-orange-500 hover:bg-orange-600 p-2 border-2 border-neutral-100 text-neutral-50 rounded-lg" type="submit">Zarejestruj</button>
    </form></div></div>
</body>

</html>