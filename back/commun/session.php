<?php

#fonction de connexion

function connectSession($mail){
    session_start();
    /*recuperation des informations utilisateur : userid nom mail role
    mettre les infos utilisateur en variable de session*/
    $row=getUserInfoByMail($mail);
    $_SESSION["usr_id"]=$row["usr_id"];
    $_SESSION["usr_name"]=$row["usr_name"];
    $_SESSION["usr_mail"]=$row["usr_mail"];
    $_SESSION["usr_rol_id"]=$row["usr_rol_id"];
    $_SESSION["usr_change_pw"]=$row["usr_change_pw"];

    header("Location: /front/dashboard.php");
    exit();
}


#fonction qui va vérifier si la variable de session user id est bien initialisée

function checkSession(){
    session_start();
    if(!isset($_SESSION["usr_id"])){
        header("Location: /front/login.php?msg=expire");
        exit();
    }
    if($_SESSION["usr_change_pw"]==1 ){
        header("Location: /front/profil.php?msg=firstConn");
        exit();
    }
}
    

#fonction qui supprime la session

function disconnectSession(){
    session_destroy();
    header("Location: /front/login.php?msg=disconnect");
    exit();
}








?>