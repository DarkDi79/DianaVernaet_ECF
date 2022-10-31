<?php
    require 'back/commun/session.php';
    checkSession();
    require 'back/centers/centers.php';

    #si action bouton valider : créer le centre
    if(isset($_POST["creer"])){
    
        #Initialisation des options
        if(isset($_POST["checkTowel"])){ $towel=1; } else { $towel=0; }
        if(isset($_POST["checkDrinks"])){ $drinks=1; } else { $drinks=0; }
        if(isset($_POST["checkPlanning"])){ $planning=1; } else { $planning=0; }
        if(isset($_POST["checkFood"])){ $food=1; } else { $food=0; }
        if(isset($_POST["actif"])){ $actif=1; } else { $actif=0; }
    
        #creation centre
        $res = createNewCenter ($_POST["nomcentre"], $_POST["mail"], $_POST["userId"], $towel, $drinks, $planning, $food, $actif);        
        
        #Récupérer l'id du nouveau centre
        $centerId = getCenterIdByMail($_POST["mail"]);

        #rattachement au partenaire
        $resLink=linkCenterToPartner ($_POST["partnerId"], $centerId);
        
        if($res==true && $resLink==true ){
            $mails=getPartnerMailsByPartnerId($_POST["partnerId"]);   
            $dest= $mails["ptr_mail"].", ".$mails["usr_mail"];
            notifyPartner($dest,false,$_POST["nomcentre"]);
            echo ("<script> alert(\"Le Centre ".$_POST["nomcentre"]." a été créé et rattaché à sa franchise\");</script>");
        }
        else if($res==false) {
            echo ("<script> alert(\"La création et son rattachement à la franchise ont échoué \");</script>");
        }
        else{echo ("<script> alert(\"Le rattachement à la franchise a échoué \");</script>");}
    }

    #si action bouton modifier
    if(isset($_POST["modifier"])){        
        if(isset($_POST["checkTowel"])){ $towel=1; } else { $towel=0; }
        if(isset($_POST["checkDrinks"])){ $drinks=1; } else { $drinks=0; }
        if(isset($_POST["checkPlanning"])){ $planning=1; } else { $planning=0; }
        if(isset($_POST["checkFood"])){ $food=1; } else { $food=0; }
        if(isset($_POST["actif"])){ $actif=1; } else { $actif=0; }

        #modif centre
        $res = editCenter ( $_POST["selectedCentId"],$_POST["nomcentre"], $_POST["mail"],$_POST["userId"],$towel, $drinks, $planning, $food, $actif); 
        #rattachement au partenaire
        $resLink=true;
        if($_POST["selectedCentPartnerId"]!=$_POST["partnerId"]){
            $resLink=linkCenterToPartner ($_POST["partnerId"], $_POST["selectedCentId"]);
        }

        if($res==true && $resLink==true){
            $mails=getPartnerMailsByPartnerId($_POST["partnerId"]);   
            $dest= $mails["ptr_mail"].", ".$mails["usr_mail"];
            notifyPartner($dest,true,$_POST["nomcentre"]);
            echo ("<script> alert(\"Le Centre ".$_POST["nomcentre"]." a bien été modifié\");</script>");
        }
        else if($res==false) {
            echo ("<script> alert(\"La création et son rattachement à la franchise a échoué \");</script>");
        }
        else{
            echo ("<script> alert(\"Le rattachement à la franchise a échoué\");</script>");
        }
    }


    #listes
    if($_SESSION["usr_rol_id"]=="TECH"){
        #si bouton crayon "edit"
        if(isset($_GET["editCent"])){
            $centerInfo= getCenterByCtrId($_GET["editCent"]);
            $partnerInfo= getPartnerByCenterId($_GET["editCent"]);
        }
        #recupere tous les users avec le role CENT (pour liste deroulante)
        $allCentersUsers = getInfoUserByRol("CENT");

        #recupere la liste de tous les centres avec toutes leurs infos
        $allCentersInfo = getAllCentersInfo();
        
        #recupere la liste de tous les partenaires avec toutes leurs infos
        $allPartnersInfo = getAllPartnersInfo();
        
    }else if($_SESSION["usr_rol_id"]=="PART"){
        #recupere les infos du centre en fonction de l'utilisateur PART connecté
        $allCentersInfo = getCentersByPartnerUserId($_SESSION["usr_id"]);
        
        #redirection vers dashboard si pas de centre rattaché au user
        if(!$allCentersInfo){            
            header("Location: /front/dashboard.php?msg=noCentLink");
            exit();
        }

        $centerInfo = mysqli_fetch_assoc($allCentersInfo);
        mysqli_data_seek($allCentersInfo, 0);

        if(isset($_GET["viewCent"])){
            $centerInfo= getCenterByCtrId($_GET["viewCent"]);
            $partnerInfo= getPartnerByCenterId($_GET["viewCent"]);
        }

    }else if($_SESSION["usr_rol_id"]=="CENT"){
        #recupere les infos du centre en fonction de l'utilisateur CENT connecté
        $centerInfo = getCenterByUserId($_SESSION["usr_id"]);

        #redirection vers dashboard si pas de centre rattaché au user
        if(!$centerInfo){            
            header("Location: /front/dashboard.php?msg=noCentLink");
            exit();
        }
    }
    


?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

<!--link bootstrap css-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

<!--modifs perso sur css-->
<link rel="stylesheet" href="/front/style.css">

<!--link bootstrap Javascript-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

<!--link Ajax-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- load jQuery and tablesorter scripts -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js.js"></script>
<script type="text/javascript" src="https://mottie.github.io/tablesorter/js/jquery.tablesorter.js"></script>

<!-- tablesorter widgets -->
<script type="text/javascript" src="https://mottie.github.io/tablesorter/js/jquery.tablesorter.widgets.js"></script>


<script>
    //fonction pour mettre à jour les options en fonction de la selection du partenaire (pour héritage)
    function updateOptions(){
        
        //verif si en mode modif
        var edit=document.getElementById('modifier');

        //recuperation des options du partenaire selectionné (depuis champs cachés)
        var towel=document.getElementById('partnerId').value + "_towel";
        var drinks=document.getElementById('partnerId').value + "_drinks";
        var planning=document.getElementById('partnerId').value + "_planning";
        var food=document.getElementById('partnerId').value + "_food";
        
        //initialisation du bouton de l'option serviettes
        if (document.getElementById(towel).value==1){
            document.getElementById('checkTowel').disabled = false;
            if (edit==null){ document.getElementById('checkTowel').checked = true; }
        } else {
            document.getElementById('checkTowel').disabled = true;
            document.getElementById('checkTowel').checked = false;
        }
        //initialisation du bouton de l'option boissons
        if (document.getElementById(drinks).value==1){
            document.getElementById('checkDrinks').disabled = false;
            if (edit==null){ document.getElementById('checkDrinks').checked = true; }
        } else {
            document.getElementById('checkDrinks').disabled = true;
            document.getElementById('checkDrinks').checked = false;
        }
        //initialisation du bouton de l'option planning
        if (document.getElementById(planning).value==1){
            document.getElementById('checkPlanning').disabled = false;
            if (edit==null){ document.getElementById('checkPlanning').checked = true; }
        } else {
            document.getElementById('checkPlanning').disabled = true;
            document.getElementById('checkPlanning').checked = false;
        }
        //initialisation du bouton de l'option encas
        if (document.getElementById(food).value==1){
            document.getElementById('checkFood').disabled = false;
            if (edit==null){ document.getElementById('checkFood').checked = true; }
        } else {
            document.getElementById('checkFood').disabled = true;
            document.getElementById('checkFood').checked = false;
        }        
    }
</script>  

<!--barre de recherche-->
<script>
    $(document).ready(function(){
        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#listingSalles tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<!--fonction tri tableau-->
<script>
$(function() {
  $("#listeAllCenters").tablesorter();
});
    </script>

<!--fonction confirm pour pop up-->
<script>
    function validerEdit(){
        return confirm("Etes-vous sur de vouloir modifier le centre?");
    }
</script>


<title>Salles</title> 

</head>

<body onload="updateOptions()">
<?php
require 'front/menu.php' ;
?>

<!--creation d'un nouveau centre-->


<hr class="hr">
<form action="/front/centers/centers.php" method="post">
    <input type="hidden" name="create" value="create">
    <div class="container page-overlay" id="creationUserCenter">
        <h5>
            <?php
                if ($_SESSION["usr_rol_id"]=="TECH"){
                    if (isset($_GET["editCent"])) {echo("MODIFIER UNE SALLE");}
                    else {echo("CREER UNE NOUVELLE SALLE");}
                }
                else if ($_SESSION["usr_rol_id"]=="CENT"){echo("LES INFORMATIONS DE VOTRE SALLE");}
                else if ($_SESSION["usr_rol_id"]=="PART"){echo("LES INFORMATIONS DE VOS SALLES");}
            ?>
        </h5>
        <!--Nom-->
        <div class="form-group">
            <label style="margin-bottom:10px" class="text">Nom de la salle</label>
            <?php
                if ($_SESSION["usr_rol_id"]=="TECH"){
                    if((isset($_GET["editCent"]))){
                        ?> <input type="text" required="vital" class="form-control" name="nomcentre" id="nomcentre" value="<?php echo ($centerInfo["ctr_name"]);?>" > <?php } 
                    else{?> <input type="text" required="vital" class="form-control" name="nomcentre" id="nomcentre"> 
                    <?php }
                }else if ($_SESSION["usr_rol_id"]=="CENT" || $_SESSION["usr_rol_id"]=="PART"){
                    ?> <input type="text" readonly class="form-control-plaintext" placeholder="<?php echo ($centerInfo["ctr_name"]);?> "> 
            <?php }?>
        </div>
        <!--Mail-->
        <div class="form-group">
            <label style="margin-bottom:10px" class="text">Mail de la salle</label>
            <?php
                if ($_SESSION["usr_rol_id"]=="TECH"){
                    if((isset($_GET["editCent"]))){?> <input type="text" required="vital" class="form-control" name="mail" id="mail" value="<?php echo ($centerInfo["ctr_mail"]);?>" > <?php } 
                    else{?> <input type="email" required="vital" class="form-control" name="mail" id="mail"> 
                    <?php }
                }else if ($_SESSION["usr_rol_id"]=="CENT" || $_SESSION["usr_rol_id"]=="PART"){?> <input type="email" readonly class="form-control-plaintext" placeholder="<?php echo ($centerInfo["ctr_mail"]);?> "> 
            <?php }?>
        </div>
        <!--boutons switch-->
        <div class="form-check form-switch">
            <label class="form-check-label" >Option Serviette</label>
            <?php
                if ($_SESSION["usr_rol_id"]=="TECH"){ 
                    $towelStatus="";
                    if((isset($_GET["editCent"]))){
                        if($centerInfo["ctr_opt_towel"]==1){
                            $towelStatus="checked";
                        }
                    }
                    echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkTowel\" id=\"checkTowel\" ".$towelStatus.">"); 
                }
                else if ($_SESSION["usr_rol_id"]=="CENT"  || $_SESSION["usr_rol_id"]=="PART"){
                    $towelStatus="";
                    if($centerInfo["ctr_opt_towel"]==1){
                        $towelStatus="checked";
                    }
                    echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkTowel\" id=\"checkTowel\" ".$towelStatus. " disabled>");
                }
            ?> 
        </div>
        <div class="form-check form-switch">
            <label class="form-check-label" >Option Boissons</label>
            <?php
                    if ($_SESSION["usr_rol_id"]=="TECH"){ 
                        $drinkStatus="";
                        if((isset($_GET["editCent"]))){
                            if($centerInfo["ctr_opt_drinks"]==1){
                                $drinkStatus="checked";
                            }
                        }
                        echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkDrinks\" id=\"checkDrinks\" ".$drinkStatus.">"); 
                    }
                    else if ($_SESSION["usr_rol_id"]=="CENT"  || $_SESSION["usr_rol_id"]=="PART"){
                        $drinkStatus="";
                        if($centerInfo["ctr_opt_drinks"]==1){
                            $drinkStatus="checked";
                        }
                        echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkDrinks\" id=\"checkDrinks\" ".$drinkStatus. " disabled>");
                    }
            ?>
        </div>
        <div class="form-check form-switch">
            <label class="form-check-label" >Gestion Planning</label>
            <?php
                if ($_SESSION["usr_rol_id"]=="TECH"){ 
                    $planningStatus="";
                    if((isset($_GET["editCent"]))){
                        if($centerInfo["ctr_opt_planning"]==1){
                            $planningStatus="checked";
                        }
                    }
                    echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkPlanning\" id=\"checkPlanning\" ".$planningStatus.">"); 
                }
                else if ($_SESSION["usr_rol_id"]=="CENT"  || $_SESSION["usr_rol_id"]=="PART"){
                    $planningStatus="";
                    if($centerInfo["ctr_opt_planning"]==1){
                        $planningStatus="checked";
                    }
                    echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkPlanning\" id=\"checkPlanning\" ".$planningStatus. " disabled>");
                }
            ?>
        </div>
        <div class="form-check form-switch">
            <label class="form-check-label" >Option Encas</label>
            <?php
                if ($_SESSION["usr_rol_id"]=="TECH"){ 
                    $foodStatus="";
                    if((isset($_GET["editCent"]))){
                        if($centerInfo["ctr_opt_food"]==1){
                            $foodStatus="checked";
                        }
                    }
                    echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkFood\" id=\"checkFood\" ".$foodStatus.">"); 
                }
                else if ($_SESSION["usr_rol_id"]=="CENT"  || $_SESSION["usr_rol_id"]=="PART"){
                    $foodStatus="";
                    if($centerInfo["ctr_opt_food"]==1){
                        $foodStatus="checked";
                    }
                    echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkFood\" id=\"checkFood\" ".$foodStatus. " disabled>");
                }
            ?>
        </div>
        
        <?php 
            if ($_SESSION["usr_rol_id"]=="PART" ){
                if((isset($_GET["viewCent"]))){            
                    echo("<label class=\"form-check-label\" >Manager: ".$partnerInfo["usr_name"]." - ".$partnerInfo["usr_mail"]."</label><p>");
                    echo("<label class=\"form-check-label\" >Franchise: ".$partnerInfo["ptr_name"]." - ".$partnerInfo["ptr_mail"]."</label>");            
                } else {
                    echo("<label class=\"form-check-label\" >Manager: ".$centerInfo["usr_name"]." - ".$centerInfo["usr_mail"]."</label><p>");
                    echo("<label class=\"form-check-label\" >Franchise: ".$centerInfo["ptr_name"]." - ".$centerInfo["ptr_mail"]."</label>");  
                }
            }
        ?>
        <!--Actif/inactif-->        
        <div class="form-check form-switch">
            <label class="form-check-label" >Active</label>
            <?php
                if ($_SESSION["usr_rol_id"]=="TECH"){
                    $actifStatus="";
                    if((isset($_GET["editCent"]))){
                        if($centerInfo["ctr_active"]==1){
                            $actifStatus="checked";
                        }
                    }
                    echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"actif\" id=\"actif\" ".$actifStatus. ">");
                }
                else if ($_SESSION["usr_rol_id"]=="CENT" || $_SESSION["usr_rol_id"]=="PART"){
                    $actifStatus="";
                    if($centerInfo["ctr_active"]==1){
                        $actifStatus="checked";
                    }
                    echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"actif\" id=\"actif\" ".$actifStatus. " disabled>");
                }
            ?>
        </div>


        <!--liste deroulante User salle-->                
        <?php if ($_SESSION["usr_rol_id"]=="TECH" ){?>
        <div> 
            <label class="form-check-label" >Manager: </label>
            <select name="userId" id="userId">
            <?php
                    while($user=mysqli_fetch_assoc($allCentersUsers)){
                        $selectedCent="";
                        if((isset($_GET["editCent"]))){
                            if($user["usr_id"]==$centerInfo["ctr_usr_id"]){
                                $selectedCent="selected";
                            }
                        }
                        echo ("<option value=\"".$user["usr_id"]."\" ".$selectedCent.">".$user["usr_name"]." - ".$user["usr_mail"]."</option>");
                    }
                ?>
            </select>
            <label class="form-check-label" >Franchise : </label>
            <?php
                #création de champs cachés contenant les options de chaque partenaire
                while($options=mysqli_fetch_assoc($allPartnersInfo)){
                    echo ("<input type=\"hidden\"  id=\"".$options["ptr_id"]."_towel\" value=\"".$options["ptr_opt_towel"]."\" />");
                    echo ("<input type=\"hidden\"  id=\"".$options["ptr_id"]."_drinks\" value=\"".$options["ptr_opt_drinks"]."\" />");
                    echo ("<input type=\"hidden\"  id=\"".$options["ptr_id"]."_planning\" value=\"".$options["ptr_opt_planning"]."\" />");
                    echo ("<input type=\"hidden\"  id=\"".$options["ptr_id"]."_food\" value=\"".$options["ptr_opt_food"]."\" />");
                }
            ?>
            <!--liste deroulante partenaires-->
            <select name="partnerId" id="partnerId" onchange="updateOptions()">
            <?php
                #remise à l'indice 0 du curseur 
                mysqli_data_seek($allPartnersInfo, 0);
                #création des options de la liste déroulante des partenaires
                while($part=mysqli_fetch_assoc($allPartnersInfo)){
                    $selectedPart="";
                    if((isset($_GET["editCent"]))){
                        if($part["ptr_id"]==$partnerInfo["ptr_id"]){
                            $selectedPart="selected";
                        }
                    }
                    echo ("<option value=\"".$part["ptr_id"]."\" ".$selectedPart.">".$part["ptr_name"]." - ".$part["ptr_mail"]."</option>");
                }
            ?>
            </select>
        </div>
        
        <!--bouton creer ou modifier-->
        <div class="button" >
            <?php 
                if((isset($_GET["editCent"]))){
                    echo("<button type=\"submit\" onclick=\"return validerEdit()\" class=\"btn btn-outline-success\" name=\"modifier\" id=\"modifier\" style=\"margin:5px 0px\">Modifier</button>");
                }
                else {
                    echo("<button type=\"submit\" class=\"btn btn-outline-success\" name=\"creer\" id=\"creer\" style=\"margin:5px 0px\">Creer</button>");
                } ?>
        </div>
        <?php
            if((isset($_GET["editCent"]))){ 
                echo("<input type=\"hidden\" name=\"selectedCentId\" value=".$centerInfo["ctr_id"].">");
                echo("<input type=\"hidden\" name=\"selectedCentPartnerId\" value=".$partnerInfo["ptr_id"].">");                
            }
        } ?>
    </div>
</form>

<?php if ($_SESSION["usr_rol_id"]=="TECH" || $_SESSION["usr_rol_id"]=="PART"){ ?>

<?php
    $icon = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-chevron-expand\" viewBox=\"0 0 16 16\">
    <path fill-rule=\"evenodd\" d=\"M3.646 9.146a.5.5 0 0 1 .708 0L8 12.793l3.646-3.647a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 0-.708zm0-2.292a.5.5 0 0 0 .708 0L8 3.207l3.646 3.647a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 0 0 0 .708z\"/>
    </svg>";
    $check = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-check-lg\" viewBox=\"0 0 16 16\">
    <path d=\"M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z\"/></svg>";
?>
<!--Liste de toutes les salles-->

<div class="table-responsive" id="allCenters"> 
    <input type="text" class="form-control" id="search" placeholder="Rechercher une Salle...">
    <table class="table table-striped tablesorter" id="listeAllCenters" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th scope="col"><?php echo $icon; ?>Id Salle</th>
                <th scope="col"><?php echo $icon; ?>Prenom</th>
                <th scope="col"><?php echo $icon; ?>Mail</th>
                <th scope="col"><?php echo $icon; ?>Option Serviette</th>
                <th scope="col"><?php echo $icon; ?>Option Boissons</th>
                <th scope="col"><?php echo $icon; ?>Option Planning</th>
                <th scope="col"><?php echo $icon; ?>Option Encas</th>
                <th scope="col"><?php echo $icon; ?>Active</th>
                <th scope="col"><?php echo $icon; ?>Modifier</th>
            </tr>
        </thead>
        <tbody id=listingSalles>
        <?php 
            while($ctrInfo=mysqli_fetch_assoc($allCentersInfo)){
                if($ctrInfo["ctr_active"]==1) {$etat="Oui";}
                else {$etat="Non";}
                echo ("<tr>");
                echo("<th scope=\"row\">".$ctrInfo["ctr_id"]."</th>");
                echo("<td>".$ctrInfo["ctr_name"]."</td>");
                echo("<td>".$ctrInfo["ctr_mail"]."</td>");
                if($ctrInfo["ctr_opt_towel"]==1){echo("<td>".$check."</td>");}else{echo("<td></td>");}
                if($ctrInfo["ctr_opt_drinks"]==1){echo("<td>".$check."</td>");}else{echo("<td></td>");}
                if($ctrInfo["ctr_opt_planning"]==1){echo("<td>".$check."</td>");}else{echo("<td></td>");}
                if($ctrInfo["ctr_opt_food"]==1){echo("<td>".$check."</td>");}else{echo("<td></td>");}   
                echo("<td>".$etat."</td>");
                if($_SESSION["usr_rol_id"]=="TECH") {
                    echo("<td>
                            <a class=\"btn btn-outline-secondary\" href=\"/front/centers/centers.php?editCent=".$ctrInfo["ctr_id"]."\" role=\"button\">
                                <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-pencil\" viewBox=\"0 0 16 16\">
                                    <path d=\"M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z\"/>
                                </svg>
                            </a>
                        </td>");
                    echo("</tr>");
                } else if ($_SESSION["usr_rol_id"]=="PART"){
                    echo("<td>
                            <a class=\"btn btn-outline-secondary\" href=\"/front/centers/centers.php?viewCent=".$ctrInfo["ctr_id"]."\" role=\"button\">
                            <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-eye\" viewBox=\"0 0 16 16\">
                                <path d=\"M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z\"/>
                                <path d=\"M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z\"/>
                            </svg>
                            </a>
                        </td>");
                echo("</tr>");
                }
            }
        ?>
        </tbody>
    </table>
</div>

<?php } ?>

</body>
</html>