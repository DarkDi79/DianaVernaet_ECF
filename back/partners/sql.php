<?php

#importation des fonctions techniques de la db
require 'back/commun/dbecf.php';

#CREATION COMPTE PARTENAIRE

function queryCreatePartner ($ptr_name, $ptr_mail, $ptr_usr_id, $ptr_opt_towel, $ptr_opt_drinks,$ptr_opt_planning, $ptr_opt_food, $ptr_active)
{
    $conn=dbConnect();
    $sql="INSERT INTO partners (ptr_name, ptr_mail, ptr_usr_id, ptr_opt_towel, ptr_opt_drinks, ptr_opt_planning, ptr_opt_food, ptr_active) 
               VALUES ('$ptr_name', '$ptr_mail', $ptr_usr_id, $ptr_opt_towel, $ptr_opt_drinks,$ptr_opt_planning, $ptr_opt_food, $ptr_active)";    
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}


#ACTIVER/DESACTIVER UN PARTENAIRE

function queryOnOffPartner ($ptr_id, $ptr_active)
{
    $conn=dbConnect();
    $sql="UPDATE partners SET ptr_active= '$ptr_active' 
           WHERE ptr_id= '$ptr_id'";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Modifier Partenaire

function queryEditPartner ($ptr_id, $ptr_name, $ptr_mail, $ptr_usr_id, $ptr_opt_towel, $ptr_opt_drinks, $ptr_opt_planning, $ptr_opt_food, $ptr_active)
{
    $conn=dbConnect();
    $sql="UPDATE partners 
             SET ptr_name='$ptr_name', ptr_mail='$ptr_mail', ptr_usr_id=$ptr_usr_id, ptr_opt_towel= $ptr_opt_towel, ptr_opt_drinks=$ptr_opt_drinks, ptr_opt_planning=$ptr_opt_planning, ptr_opt_food=$ptr_opt_food, ptr_active=$ptr_active
           WHERE ptr_id= $ptr_id";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Supprimer un compte Partenaire 

function queryDeletePartner ($ptr_id)
{
    $conn=dbconnect();
    $sql="DELETE FROM partners
                WHERE ptr_id = $ptr_id";
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

#Récuperation des infos du partenaire en fonction de son user Id

function queryGetPartnerByUserId($userId)
{
    $conn=dbconnect();
    $sql="SELECT * 
            FROM partners
           WHERE ptr_usr_id=$userId";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Récupération de toutes les infos en fonction du role utilisateur

function queryInfoUserByRol ($userRole)
{
    $conn=dbConnect();
    $sql="SELECT usr_id, usr_name, usr_mail
            FROM users
           WHERE usr_rol_id='$userRole'";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}


#Récuperation des infos du partenaire en fonction de son Partner Id

function queryGetPartnerByPtrId($ptrId)
{
    $conn=dbconnect();
    $sql="SELECT * 
            FROM partners
           WHERE ptr_id=$ptrId";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#Update options - heritage

function queryUpdateCenterOptions ($ctr_id, $ctr_opt_towel, $ctr_opt_drinks,$ctr_opt_planning, $ctr_opt_food, $ctr_active)
{
    $conn=dbConnect();
    $sql="UPDATE centers SET ctr_opt_towel= $ctr_opt_towel, ctr_opt_drinks=$ctr_opt_drinks, ctr_opt_planning=$ctr_opt_planning, ctr_opt_food=$ctr_opt_food, ctr_active=$ctr_active
           WHERE ctr_id= $ctr_id";
    $res=mysqli_query($conn,$sql);
    dbDisconnect ($conn);
    return $res;
}

#recuperations des centres rattachés à un partenaire

function queryGetCentersByPartnerId($ptr_id){
    $conn=dbConnect();
    $sql="SELECT * FROM centers, ptr_to_ctr 
           WHERE ctr_id=ptc_ctr_id AND ptc_ptr_id=$ptr_id";
     $res=mysqli_query($conn,$sql);
     dbDisconnect ($conn);
     return $res;

}


?>