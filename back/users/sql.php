<?php

#importation des fonctions techniques de la db
require 'back/commun/dbecf.php';

#fonction creation d'un utilisateur en base

function queryCreateUser ($usrName, $usrRoleId, $usrMail, $usrPwd)
{
    $conn=dbConnect();
    $sql="INSERT INTO users (usr_name, usr_rol_id, usr_mail, usr_pw, usr_change_pw) 
          VALUES ('$usrName','$usrRoleId','$usrMail','$usrPwd',1)";    
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}


#Récupération de toutes les infos de tous les users (sauf mdp)

function queryInfoAllUsers ()
{
    $conn=dbConnect();
    $sql="SELECT usr_id, usr_name, usr_mail, usr_rol_id, rol_name
            FROM users, roles
            WHERE usr_rol_id=rol_id";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Récupération de l'user_id et du nom en fonction du mail

function queryInfoUserByMail ($userMail)
{
    $conn=dbConnect();
    $sql="SELECT usr_id, usr_name, usr_mail, usr_rol_id, usr_change_pw
            FROM users 
           WHERE usr_mail='$userMail'";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Modification du Mot de Passe utilisateur

function queryChangePwd ($usr_pw,$usr_id)
{
    $conn=dbConnect();
    $sql="UPDATE users 
             SET usr_pw = '$usr_pw', usr_change_pw = 0 
           WHERE usr_id='$usr_id'";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;

}

#AUTHENTIFICATION DE L'UTILISATEUR 

function queryAuthUser ($usr_mail, $usr_pw)
{
    $conn=dbconnect();
    $sql="SELECT * FROM users
    WHERE usr_mail='$usr_mail'
      AND usr_pw='$usr_pw'";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Recupere le mot de passe crypté

function queryGetPwdByMail ($usr_mail)
{
    $conn=dbconnect();
    $sql="SELECT usr_pw FROM users
        WHERE usr_mail='$usr_mail'";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Récupération de toutes les infos en fonction du role utilisateur

function queryInfoUserByRol ($userRole)
{
    $conn=dbConnect();
    $sql="SELECT usr_id, usr_name, usr_rol_id
            FROM users
           WHERE usr='$userRole'";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}


#Récupération de toutes les infos de tous les roles

function queryAllRoles ()
{
    $conn=dbConnect();
    $sql="SELECT *
            FROM roles";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}


#Supprimer un compte utilisateur

function queryDeleteUser($user_id)
{
    $conn=dbconnect();
    $sql="DELETE FROM users
                WHERE usr_id='$user_id'";
    $res=mysqli_query($conn, $sql);
    dbDisconect($conn);
    return $res;
}


    

?>