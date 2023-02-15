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

    if ($_SESSION['user']->getRole()!=User::roles["Admin"])
    {
        header('Location: dashboard.php');
        exit();
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Użytkownicy</title>
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
<?php    
    $user = $_SESSION['user'];
    ?>
    <div class="p-5 w-full">
        <div class="w-full flex justify-center">
            <table class="table-auto rounded-lg w-3/4">
                <tr class="bg-gradient-to-b from-orange-500 to-orange-400">
                    <th class="text-left">Użytkownik</th>
                    <th class="text-left">Rola</th>
                    <th class="text-left">Akcje</th>
                </tr>
                <?php
                $isEven = false;
                $PostDAO = new UserDAO($db);
                $users = $PostDAO->findAllUsers();
                foreach($users as $user)
                {   
                    echo("<tr class='". ($isEven ? "bg-zinc-200 hover:bg-orange-300" : "bg-zinc-100 hover:bg-orange-300") ."'>");
                    $isEven =! $isEven;
                    $id = $user->getId();
                    $username = $user->getUsername();
                    echo("<td>$username</td>");
                    $role = $user->getRole() == User::roles["Admin"] ? "Admin" : ($user->getRole() == User::roles["User"] ? "User" : "Błąd bazy danych");
                    echo("<td>$role</td>");
                    echo("<td><a href='manageuser.php?id=$id'>Zmień rolę</a></td>");
                    echo("</tr>");
                }
                ?>
            </table>
        </div>
    </div>
    
</body>
</html>
