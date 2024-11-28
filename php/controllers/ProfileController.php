<?php
header('Content-Type: application/json; charset=utf-8');

require_once('../dbconnect.php');
if($_SERVER['REQUEST_METHOD']=="POST"){
    $paramData=json_decode(file_get_contents('php://input'), TRUE);
    if(isset($paramData['login'])){
        $stmt = $conn->prepare("SELECT * FROM users WHERE login=? AND password=MD5(?);");
        $stmt->bind_param("ss", $login,$password);
        $login=$paramData['login'];
        $password=$paramData['password'];
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id,$login,$password);
        if ($stmt->num_rows > 0) {
        while($row = $stmt->fetch()) {
            $_SESSION['user']=$login;
            echo json_encode(array("login"=>true));
        } 
        $stmt->free_result();
        }else{
            echo json_encode(array("login"=>false));
        }
    }
        
} else {
    if(isset($_GET['action'])){
        if($_GET['action']=='logout'){
            session_destroy();
            echo json_encode(array("login"=>false));
        }
    } else if(!isset($_SESSION['user'])){
        echo json_encode(array("login"=>false));
    } else{
        echo json_encode(array("login"=>true));
    }
}