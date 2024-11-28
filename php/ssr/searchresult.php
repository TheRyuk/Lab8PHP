<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if(!isset($_SESSION['user'])){
    header('Location:login.php');
}
require_once('../dbconnect.php');
require_once('../models/CommandList.php');
require_once('../models/CategoryList.php');
$commandList=new CommandList(); 

if($_SERVER['REQUEST_METHOD']=="GET" && isset($_GET['query'])){
    $commandList->getBySearchQuery($conn,$_GET['query']);
} else{
    $commandList->getAllFromDatabase($conn);
}
if((isset($_GET['action']))&&$_GET['action']=='delete'){
    $commandList->deleteFromDatabaseById($conn,$_GET['id']);
    header('Location: ./command-list.php');
}
?>
<html>
    <head>
        <title>Content Management System</title>
        <meta charset="utf-8"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="../assets/style.css" rel="stylesheet"/>
    </head>
    <body>
    <div class="container">
            <h1>Результати пошуку</h1>
            <h1>Список команд</h1>
            <nav class="navbar-nav d-flex flex-row">
                <li class="nav-item"><a class="nav-item" href="category-list.php">Список категорій</a></li>
                <li class="nav-item"><a class="nav-item" href="add-category.php">Додати категорію</a></li>
                <li class="nav-item"><a class="nav-item" href="command-list.php">Список команд</a></li>
                <li class="nav-item"><a class="nav-item" href="add-command.php">Додати команду</a></li>
                <li class="nav-item"><a class="nav-item" href="example-list.php">Список прикладів</a></li>
                <li class="nav-item"><a class="nav-item" href="add-example.php">Додати приклад</a></li>
                <li class="nav-item"><a class="nav-item" href="logout.php">Вийти</a></li>
            </nav>
        <form action="./searchresult.php" method="GET">
                    <input type="search" name="query" required/>
                    <input type="submit" value="Пошук"/>
                </form>
            <div class="mt-3">
                <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Назва команди</th>
                            <th>Опис</th>
                            <th>Категорія</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody><?php echo $commandList->exportAsTableData();?></tbody>
                </table>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>