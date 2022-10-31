<?php

require 'back/centers/sql.php';
require 'back/commun/tools.php';

#create new center

function createNewCenter ($ctr_name, $ctr_mail, $ctr_usr_id, $ctr_opt_towel, $ctr_opt_drinks,$ctr_opt_planning, $ctr_opt_food, $ctr_active){

    $res=queryCreateCenter ($ctr_name, $ctr_mail, $ctr_usr_id, $ctr_opt_towel, $ctr_opt_drinks,$ctr_opt_planning, $ctr_opt_food, $ctr_active);
    
    return $res;
    

}

#Récupération des infos partenaire en fonction du User Id
function getCenterByUserId($userId){
    $res=queryGetCenterByUserId($userId);
    return mysqli_fetch_assoc($res);
}

#Récupération des infos des salles rattachées au partenaire (via le user id)
function getCentersByPartnerUserId($partnerUserId){
    return queryGetCentersByPartnerUserId($partnerUserId);     
}

#recupere la liste de tous les centres avec toutes leurs infos
function getAllCentersInfo(){
    return queryGetAllCenters();
}


#Récupération de toutes les infos en fonction du role utilisateur

function getInfoUserByRol($roleId){
    return queryInfoUserByRol ($roleId);

}

#recupere l'id du centre en fonction du mail
function getCenterIdByMail($centerMail){
    $res= queryGetCenterByMail($centerMail);
    $center= mysqli_fetch_assoc($res);
    return $center["ctr_id"];
}

#rattacher le centre à son partenaire
function linkCenterToPartner ($ptr_id, $ctr_id){
    return queryLinkCenterToPartner ($ptr_id, $ctr_id);
}

#recupere la liste de tous les partenaires avec toutes leurs infos
function getAllPartnersInfo(){
    return queryGetAllPartners();
    }

#recupere les infos centre en fonction du CenterId
function getCenterByCtrId($ctrId){
    $res=queryGetCenterByCtrId($ctrId);
    return mysqli_fetch_assoc($res);
}
    

#modification d'un centre
function editCenter($ctr_id, $ctr_name, $ctr_mail, $ctr_usr_id, $ctr_opt_towel, $ctr_opt_drinks, $ctr_opt_planning, $ctr_opt_food, $ctr_active){ 
    return queryEditCenter ($ctr_id, $ctr_name, $ctr_mail, $ctr_usr_id, $ctr_opt_towel, $ctr_opt_drinks, $ctr_opt_planning, $ctr_opt_food, $ctr_active);

}

#recupere les infos du partenaire rattaché à un centre
function getPartnerByCenterId($ctr_id){
    $res=queryGetPartnerByCenterId($ctr_id);
    return mysqli_fetch_assoc($res);
}

#recupere les infos du partenaire rattaché à un centre
function getPartnerMailsByPartnerId($partnerId){
    $res=queryGetPartnerMails($partnerId);
    return mysqli_fetch_assoc($res);
}

#Notification du partenaire en cas de modif et rattachement d'un centre
function notifyPartner($dest,$modif,$center){
    
    if($modif){
        $subject="Modification de votre salle Body Active Fitness";
        $msg = "
            <html>
                <head>
                    <title>Modification de votre salle $center </title>
                </head>
                <body>
                    <h1>Votre salle Body Active Fitness a été modifiée !</h1>
                    <p>Nous vous informons que votre salle Body Active Fitness $center a été modifiée. 
                    <p>Vous pouvez accéder à votre espace via ce lien : <a href=\"https://ecf.blackshadowsphoto.com:8081\">Body Active Fitness</a>.</p>
                </body>
            </html>
        ";
    } else {
        $subject="Création de votre salle Body Active Fitness";
        $msg = "
        <html>
            <head>
                <title>Création de votre salle $center </title>
            </head>
            <body>
                <h1>Votre nouvelle salle Body Active Fitness a été créée !</h1>
                <p>Nous vous informons que votre salle Body Active Fitness $center a bien été créée. 
                <p>Vous pouvez accéder à votre espace via ce lien : <a href=\"https://ecf.blackshadowsphoto.com:8081\">Body Active Fitness</a>.</p>
            </body>
        </html>
        ";
    }    
    
    sendMail($dest,$subject,$msg);
}


?>