<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
require_once('../dbconnect.php');
session_start();
if(str_contains($_SERVER['REQUEST_URI'],'categories')){
    require_once('../controllers/CategoryController.php');
} else if(str_contains($_SERVER['REQUEST_URI'],'examples')){
    require_once('../controllers/ExampleController.php');
} else if(str_contains($_SERVER['REQUEST_URI'],'commands')){
    require_once('../controllers/CommandController.php');
} else if(str_contains($_SERVER['REQUEST_URI'],'profile')){
    require_once('../controllers/ProfileController.php');
}
?>