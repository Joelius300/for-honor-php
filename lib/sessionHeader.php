<?php
//This simply checks if the user is logged in and if not he is redirected to the login page
//included everywhere except in login and register form

try{
    if(!isset($_SESSION['userID'])){
        header('Location: /user/Login');
    }
}catch (Exception $e){
    header('Location: /user/Login');
}
?>