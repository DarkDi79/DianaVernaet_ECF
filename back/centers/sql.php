<?php

#importation des fonctions techniques de la db
require 'back/commun/dbecf.php';

#Création compte Salle

function queryCreateCenter ($ctr_name, $ctr_mail, $ctr_usr_id, $ctr_opt_towel, $ctr_opt_drinks,$ctr_opt_planning, $ctr_opt_food, $ctr_active)
{
    $conn=dbConnect();
    $sql="INSERT INTO centers (ctr_name, ctr_usr_id, ctr_mail, ctr_opt_towel, ctr_opt_drinks, ctr_opt_planning, ctr_opt_food, ctr_active) 
          VALUES ('$ctr_name', '$ctr_usr_id', '$ctr_mail', '$ctr_opt_towel', '$ctr_opt_drinks','$ctr_opt_planning', '$ctr_opt_food','$ctr_active' )";    
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Activer/desactiver une Salle

function queryOnOffCenter ($ctr_id, $ctr_active)
{
    $conn=dbConnect();
    echo("Connexion : ".mysqli_stat($conn)."</br>");
    $sql="UPDATE centers SET ctr_active= '$ctr_active' 
           WHERE ctr_id= '$ctr_id'";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Activer/Desactiver une option Salle 

function queryOnOffOptionsCenter ($ctr_id, $ctr_opt_towel, $ctr_opt_drinks,$ctr_opt_planning, $ctr_opt_food)
{
    $conn=dbConnect();
    echo("Connexion :".mysqli_stat($conn)."</br>");
    $sql="UPDATE centers SET ctr_opt_towel= '$ctr_opt_towel', ctr_opt_drinks='$ctr_opt_drinks', ctr_opt_planning='$ctr_opt_planning', ctr_opt_food='$ctr_opt_food'
           WHERE ctr_id= '$ctr_id'";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Detacher la Salle du Partenaire

function queryUnlinkCenterToPartner($ctr_id)

{
    $conn=dbConnect();
    echo("Connexion :".mysqli_stat($conn)."</br>");
    $sql="DELETE FROM ptr_to_ctr
             WHERE ptc_ctr_id='$ctr_id'";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Rattachement Salle - Partenaire

function queryLinkCenterToPartner ($ptr_id, $ctr_id)
{
    $conn=dbConnect();
    $sql="INSERT INTO ptr_to_ctr (ptc_ptr_id, ptc_ctr_id) VALUES ($ptr_id,$ctr_id)";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Supprimer un compte Salle

function queryDeleteCenter ($ctr_id)
{
    $conn=dbconnect();
    echo("Connexion :".mysqli_stat($conn)."</br>");
    $sql="DELETE FROM centers
                WHERE ctr_id = '$ctr_id'";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Liste de toutes les salles

function queryGetAllCenters()
{
    $conn=dbconnect();
    $sql="SELECT * 
            FROM users, centers
           WHERE usr_rol_id='CENT' AND usr_id=ctr_usr_id";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}


#Liste des mails des partenaires

function queryGetPartnerMails($partnerId)
{
    $conn=dbconnect();
    $sql="SELECT ptr_mail, usr_mail
            FROM partners, users
            WHERE ptr_usr_id=usr_id
            AND ptr_id = $partnerId";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}
#Récupération de toutes les infos en fonction du role utilisateur

function queryInfoUserByRol ($userRole)
{
    $conn=dbConnect();
    $sql="SELECT *
            FROM users
           WHERE usr_rol_id='$userRole'";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Récuperation des infos du centre en fonction de son user Id

function queryGetCenterByUserId($userId)
{
    $conn=dbconnect();
    $sql="SELECT * 
            FROM centers
           WHERE ctr_usr_id=$userId";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}


#Récuperation des infos du centre en fonction de son mail

function queryGetCenterByMail($mailCenter)
{
    $conn=dbconnect();
    $sql="SELECT * 
            FROM centers
           WHERE ctr_mail='$mailCenter'";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Liste de tous les partenaires

function queryGetAllPartners()
{
    $conn=dbconnect();
    $sql="SELECT * 
            FROM users, partners
           WHERE usr_rol_id='PART' AND usr_id=ptr_usr_id";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}


#Récuperation des infos du centre en fonction de son Center Id

function queryGetCenterByCtrId($ctrId)
{
    $conn=dbconnect();
    $sql="SELECT * 
            FROM centers
           WHERE ctr_id=$ctrId";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}


#Modifier Partenaire

function  queryEditCenter ($ctr_id, $ctr_name, $ctr_mail, $ctr_usr_id, $ctr_opt_towel, $ctr_opt_drinks, $ctr_opt_planning, $ctr_opt_food, $ctr_active)
{
    $conn=dbConnect();
    $sql="UPDATE centers 
             SET ctr_name='$ctr_name', ctr_mail='$ctr_mail', ctr_usr_id=$ctr_usr_id, ctr_opt_towel= $ctr_opt_towel, ctr_opt_drinks=$ctr_opt_drinks, ctr_opt_planning=$ctr_opt_planning, ctr_opt_food=$ctr_opt_food, ctr_active=$ctr_active
           WHERE ctr_id= $ctr_id";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#recuperations du partenaire rattachés à un centre

function queryGetPartnerByCenterId($ctr_id){
    $conn=dbConnect();
    $sql="SELECT * FROM partners, ptr_to_ctr, users 
           WHERE ptr_id=ptc_ptr_id
             AND usr_id=ptr_usr_id
             AND ptc_ctr_id=$ctr_id";
     $res=mysqli_query($conn,$sql);
     dbDisconnect ($conn);
     return $res;

}


#recuperations des salles rattachées à un partenaire (via le user id)

function queryGetCentersByPartnerUserId($partnerUserId){
    $conn=dbConnect();
    $sql="SELECT ctr_id, ctr_name, ctr_mail, ctr_opt_towel, ctr_opt_drinks, ctr_opt_planning, ctr_opt_food, ctr_active, usr_name, usr_mail, ptr_name, ptr_mail
            FROM centers, ptr_to_ctr, partners, users
            WHERE ptc_ctr_id=ctr_id
            AND ptc_ptr_id=ptr_id
            AND ctr_usr_id=usr_id
            AND ptr_usr_id=$partnerUserId";
     $res=mysqli_query($conn,$sql);
     dbDisconnect ($conn);
     return $res;

}

?>