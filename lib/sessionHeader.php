<?php
try{
    if(!isset($_SESSION['userID'])){
        header('Location: /user/Login');
    }
}catch (Exception $e){
    header('Location: /user/Login');
}
?>