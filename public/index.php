<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YOM - helpdesk system</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="w-full bg-orange-600 p-4 flex">
        <div class="text-3xl font-bold text-neutral-50 w-1/6 text-center">
            <a href="/">YOM</a>
        </div>
        <div class="text-neutral-50 w-2/3 flex">
            <?php
            session_start(); 
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
            <h1 class="font-bold text-4xl">System do helpdesku - YOM</h1>
            <div class="text-xl">"Yom" to system do helpdesku umożliwiający łatwą i efektywną obsługę zgłoszeń. Dzięki niemu użytkownicy mogą przesyłać zgłoszenia i otrzymywać odpowiedzi od pracowników helpdesku, a ci ostatni mają możliwość zarządzania zgłoszeniami.</div>
        </div>
    </div>
    </body>
</html>