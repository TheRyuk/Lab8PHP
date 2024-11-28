<?php
header('Content-Type: application/json; charset=utf-8');

if(!isset($_SESSION['user'])){
  echo json_encode(array("login"=>false));
  die();
}
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('../models/CategoryList.php');
$catList=new CategoryList();    
$catList->getAllFromDatabase($conn);
if($_SERVER['REQUEST_METHOD']=="POST"){
    $catData=json_decode(file_get_contents('php://input'), TRUE);
    $catList->addToDatabase($conn,$catData);
} else if($_SERVER['REQUEST_METHOD']=="PUT"){
    $catData=json_decode(file_get_contents('php://input'), TRUE);
    $catList->updateDatabaseRecord($conn,$catData);
} else if($_SERVER['REQUEST_METHOD']=="DELETE"){
    $catData=json_decode(file_get_contents('php://input'), TRUE);
    $catList->deleteFromDatabaseById($conn,$catData['id']);
}
echo $catList->exportAsJSON();