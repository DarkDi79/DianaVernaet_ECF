<?php

#importation des fonctions techniques de la db
require 'back/users/sql.php';
require 'back/commun/tools.php';


#AUTHENTIFICATION DE L'UTILISATEUR 

function authentication ($mail, $pwd){
    $resultat=queryGetPwdByMail($mail);
    
    #si mail inexistant
    if (mysqli_num_rows($resultat)==0) {
        return false;
    }
    #recuperation du resultat(un seul résultat car mail unique)
    $row=mysqli_fetch_assoc($resultat);
    #si mot de passe correct
    if(password_verify($pwd,$row["usr_pw"])){
        return true;
    }else{
        #si mot de passe incorrect
        return false;
    }
    
}

#Fonction de récupération de toutes les infos de tous les users

function getInfoAllUsers ()
{
    return queryInfoAllUsers();
}

#Fonction de récupération de toutes les infos de tous les roles

function getAllRoles ()
{
    return queryAllRoles();
}


#Get info User by Mail

function getUserInfoByMail ($userMail){
    $resultat=queryInfoUserByMail ($userMail);
    return mysqli_fetch_assoc($resultat);
}

#Change user PWD by Id

function changeUserPwd ($usr_pw,$usr_id){
    $pwdEncrypted=password_hash($usr_pw, PASSWORD_DEFAULT);
    $res=queryChangePwd ($pwdEncrypted,$usr_id);
    return $res;
}


#Generer un mot de passe aléatoire

function generatePwd($nbCaracteres)
    {
        $password = "";
        for($i = 0; $i < $nbCaracteres; $i++)
        {
            $random = rand(48,122);
            $password .= chr($random);
        }
        return $password;
    }



#create new user

function createNewUser ($usrName, $usrRoleId, $usrMail){

    $pwd=generatePwd(10);    
    $hash=password_hash($pwd, PASSWORD_DEFAULT);
    $res=queryCreateUser ($usrName, $usrRoleId, $usrMail, $hash);

    #envoi mail
    if($res){
    
        $sujet = "Création de votre compte Body Active Fitness";
        $msg = "
            <html>
                <head>
                    <title>Création de votre compte Body Active Fitness</title>
                </head>
                <body>
                    <h1>Bienvenue sur Body Active Fitness !</h1>
                    <p>Nous vous informons que votre compte utilisateur Body Active Fitness a été créé. Pour vous y connecter, merci d'utiliser le mot de passe temporaire : <b>$pwd</b> </p>
                    Il vous sera demandé de modifier votre mot de passe lors de votre première connexion.
                    <p>Vous pouvez accéder à votre espace via ce lien : <a href=\"https://ecf.blackshadowsphoto.com:8081\">Body Active Fitness</a>.</p>
                </body>
            </html>
        ";
        sendMail($usrMail, $sujet, $msg);        
    }

    return $res;
    
}

#supprimer un utilisateur

function deleteUser ($user_id){
    $resultat=queryDeleteUser($user_id);
    return $res;
    SESSION_DESTROY();
    
}

?>

