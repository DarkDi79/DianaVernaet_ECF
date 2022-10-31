<?php

require 'back/partners/sql.php';


#create new partner

function createNewPartner ($ptr_name, $ptr_mail,$ptr_usr_id, $ptr_opt_towel, $ptr_opt_drinks,$ptr_opt_planning, $ptr_opt_food, $ptr_active ){

    $res=queryCreatePartner ($ptr_name, $ptr_mail, $ptr_usr_id, $ptr_opt_towel, $ptr_opt_drinks,$ptr_opt_planning, $ptr_opt_food, $ptr_active);
    
    return $res;
    

}


#Récupération de toutes les infos en fonction du role utilisateur

function getInfoUserByRol($roleId){
    return queryInfoUserByRol ($roleId);

}

#Récupération des infos partenaire en fonction du User Id
function getPartnerByUserId($userId){
    $res=queryGetPartnerByUserId($userId);
    return mysqli_fetch_assoc($res);
}

#recupere la liste de tous les partenaires avec toutes leurs infos
function getAllPartnersInfo(){
    return queryGetAllPartners();
    }

#recupere les infos partenaire en fonction du PartnerId
function getPartnerByPtrId($ptrId){
    $res=queryGetPartnerByPtrId($ptrId);
    return mysqli_fetch_assoc($res);
}
    
#modification d'un partenaire
function editPartner($ptr_id, $ptr_name, $ptr_mail, $ptr_usr_id, $ptr_opt_towel, $ptr_opt_drinks, $ptr_opt_planning, $ptr_opt_food, $ptr_active){ 
    return queryEditPartner ($ptr_id, $ptr_name, $ptr_mail, $ptr_usr_id, $ptr_opt_towel, $ptr_opt_drinks, $ptr_opt_planning, $ptr_opt_food, $ptr_active);

}

#update options - heritage
function applyHeritageToCenter ($ptr_id, $ptr_opt_towel, $ptr_opt_drinks, $ptr_opt_planning, $ptr_opt_food, $ptr_active){
    $retour=true;
    $centers=queryGetCentersByPartnerId($ptr_id);
    while($row=mysqli_fetch_assoc($centers)){
        $optionTowel=$row["ctr_opt_towel"];
        $optionDrinks= $row["ctr_opt_drinks"];
        $optionPlanning=$row["ctr_opt_planning"];
        $optionFood=$row["ctr_opt_food"];
        $optionActive=$row["ctr_active"];
        if($ptr_opt_towel==0){$optionTowel=0;}
        if($ptr_opt_drinks==0){$optionDrinks=0;}
        if($ptr_opt_planning==0){$optionPlanning=0;}
        if($ptr_opt_food==0){$optionFood=0;}
        if($ptr_active==0){$optionActive=0;}
        if(!queryUpdateCenterOptions ($row["ctr_id"], $optionTowel, $optionDrinks,$optionPlanning, $optionFood, $optionActive)){
            $retour=false;
        }
    }
    return $retour;
}

?>




















































































































































