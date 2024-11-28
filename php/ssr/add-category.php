<?php

session_start();

if(!isset($_SESSION['user'])){
    header('Location:login.php');
}
require_once('../dbconnect.php');
require_once('../models/CategoryList.php');
$catList=new CategoryList();    
$catList->getAllFromDatabase($conn);
$idContent='';
$nameContent='';
$descriptoinContent='';
if(isset($_GET['id'])){
    $data=$catList->getItemById($_GET['id']);
    $idContent=$data['id'];
    $nameContent=$data['name'];
    $descriptoinContent=$data['description'];
}
if(isset($_POST['name'])){
    if($_POST['id']==""){
        $catList->addToDatabase($conn,array('name'=>$_POST['name'],'description'=>$_POST['description']));
    } else{
        $catList->updateDatabaseRecord($conn,array('id'=>$_POST['id'],'name'=>$_POST['name'],'description'=>$_POST['description']));
    }

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
            <h1>Додати категорію</h1>
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
                <form method="POST">
                    <p>
                        <input class="form-input" name="name" value='<?php echo $nameContent; ?>' type="text" placeholder="Назва категорії" required/>
                    </p>
                    <p>
                        <input class="form-input" name="description" value="<?php echo $descriptoinContent; ?>" type="text" placeholder="Опис категорії" required/>
                    </p>
                    <input type="hidden" value="<?php echo $idContent; ?>" name="id"/>
                    <p>
                        <button class="btn btn-success" type="submit">Додати</button>
                    </p>
                </form>
            </div>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>