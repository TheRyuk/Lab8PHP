<?php
require_once('../dbconnect.php');
require_once('../models/CategoryList.php');
session_start();
if(!isset($_SESSION['user'])){
    header('Location:login.php');
}

$catList=new CategoryList();    
$catList->getAllFromDatabase($conn);
if((isset($_GET['action']))&&$_GET['action']=='delete'){
    $catList->deleteFromDatabaseById($conn,$_GET['id']);
    $catList->saveToFile();
    header('Location: ./category-list.php');
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
            <h2>Система керування контентом</h2>
            <h1>Список категорій</h1>
            <nav class="navbar-nav d-flex flex-row">
                <li class="nav-item"><a class="nav-item" href="category-list.php">Список категорій</a></li>
                <li class="nav-item"><a class="nav-item" href="add-category.php">Додати категорію</a></li>
                <li class="nav-item"><a class="nav-item" href="command-list.php">Список команд</a></li>
                <li class="nav-item"><a class="nav-item" href="add-command.php">Додати команду</a></li>
                <li class="nav-item"><a class="nav-item" href="example-list.php">Список прикладів</a></li>
                <li class="nav-item"><a class="nav-item" href="add-example.php">Додати приклад</a></li>
                <li class="nav-item"><a class="nav-item" href="logout.php">Вийти</a></li>
            </nav>

            <div class="mt-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Назва категорії</th>
                            <th>Опис</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody><?php echo $catList->exportAsTableData();?></tbody>
                </table>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>