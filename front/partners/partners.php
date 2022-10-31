<?php
    require 'back/commun/session.php';
    checkSession();
    require 'back/partners/partners.php';

    #si action bouton valider : créer le partenaire
    if(isset($_POST["creer"])){        

        if(isset($_POST["checkTowel"])){ $towel=1; } else { $towel=0; }
        if(isset($_POST["checkDrinks"])){ $drinks=1; } else { $drinks=0; }
        if(isset($_POST["checkPlanning"])){ $planning=1; } else { $planning=0; }
        if(isset($_POST["checkFood"])){ $food=1; } else { $food=0; }
        if(isset($_POST["actif"])){ $actif=1; } else { $actif=0; }

        $res = createNewPartner ($_POST["nompart"], $_POST["mail"], $_POST["userId"], $towel, $drinks, $planning, $food, $actif);  
        
        if($res==true){
            echo ("<script> alert(\"Le Partenaire ".$_POST["nompart"]." a été créé\");</script>");
        }
        else{
            echo ("<script> testAlert(\"La création a achoué\");</script>");
        }

    }
    #si action bouton modifier
    if(isset($_POST["modifier"])){        
        if(isset($_POST["checkTowel"])){ $towel=1; } else { $towel=0; }
        if(isset($_POST["checkDrinks"])){ $drinks=1; } else { $drinks=0; }
        if(isset($_POST["checkPlanning"])){ $planning=1; } else { $planning=0; }
        if(isset($_POST["checkFood"])){ $food=1; } else { $food=0; }
        if(isset($_POST["actif"])){ $actif=1; } else { $actif=0; }

        $res = editPartner ( $_POST["selectedPartId"],$_POST["nompart"], $_POST["mail"],$_POST["userId"],$towel, $drinks, $planning, $food, $actif); 
            
        #modif options centre heritage
        $heritage = applyHeritageToCenter ($_POST["selectedPartId"], $towel, $drinks, $planning, $food, $actif);
        
        if($res==true && $heritage==true ){
            echo ("<script> alert(\"La franchise ".$_POST["nompart"]." a bien été modifiée\");</script>");
        }
        else if( $heritage==false){
            echo ("<script> alert(\"La mise à jour de l'héritage a achoué\");</script>");
        }
        else{
            echo ("<script> alert(\"La modification a achoué\");</script>");
        }
    }

    #listes
    if($_SESSION["usr_rol_id"]=="TECH"){
        #si bouton crayon edit
        if(isset($_GET["editPart"])){
            $partnerInfo= getPartnerByPtrId($_GET["editPart"]);
        }
        #recupere tous les users avec le role PART (pour liste deroulante)
        $allPartnersUsers= getInfoUserByRol("PART");

        #recupere la liste de tous les partenaires avec toutes leurs infos
        $allPartnersInfo = getAllPartnersInfo();

    }else if($_SESSION["usr_rol_id"]=="PART"){
        #recupere les infos du partenaire en fonction de l'utilisateur PART connecté
        $infosPartner = getPartnerByUserId($_SESSION["usr_id"]);  
        
        #redirection vers dashboard si pas de partenaire rattaché au user
        if(!$infosPartner){            
            header("Location: /front/dashboard.php?msg=noPartLink");
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

<!--barre de recherche-->
<script>
    $(document).ready(function(){
        $("#lookFor").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#listingPartners tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>


<!--fonction tri tableau-->
<script>
$(function() {
  $("#listeAllPartners").tablesorter();
});
    </script>

<!--fonction confirm pour pop up-->
<script>
    function validerEdit(){
        return confirm("Etes-vous sur de vouloir modifier la franchise?");
    }
</script>



<title>Franchises</title> 

</head>

<body>
<?php
require 'front/menu.php' ;
?>


<!--creation d'un nouveau partenaire-->


<hr class="hr">
<form action="/front/partners/partners.php" method="post"  >
    <input type="hidden" name="create" value="create">
    <div class="container page-overlay" id="creationUserPartner">
        <h5>
            <?php
                if ($_SESSION["usr_rol_id"]=="TECH"){
                    if(isset($_GET["editPart"])){echo("MODIDIER UNE FRANCHISE");}
                    else{echo("CREER UNE NOUVELLE FRANCHISE");}
                }
                else if ($_SESSION["usr_rol_id"]=="PART"){echo("VOS INFORMATIONS FRANCHISE");}
                
            ?>
        </h5>
        <!--Nom-->
        <div class="form-group"> 
            <label style="margin-bottom:10px" class="text">Nom de la Franchise </label>
            <?php
                if ($_SESSION["usr_rol_id"]=="TECH"){
                    if((isset($_GET["editPart"]))){?> <input type="text" required="vital" class="form-control" name="nompart" id="nompart" value="<?php echo ($partnerInfo["ptr_name"]);?>" > <?php } 
                        else{?> <input type="text" required="vital" class="form-control" name="nompart" id="nompart">
                        <?php }
                }else if ($_SESSION["usr_rol_id"]=="PART"){?> <input type="text" readonly class="form-control-plaintext" placeholder=
                        <?php echo ($infosPartner["ptr_name"]);
                        ?> > <?php }
            ?>
        </div>
        <!--Mail-->
        <div class="form-group"> 
            <label style="margin-bottom:10px" class="text">Mail de la Franchise</label>
            <?php
                if ($_SESSION["usr_rol_id"]=="TECH"){
                    if((isset($_GET["editPart"]))){?> <input type="text" required="vital" class="form-control" name="mail" id="mailPart" value="<?php echo ($partnerInfo["ptr_mail"]);?>" > <?php }                 
                    else{?> <input type="email" required="vital" class="form-control" name="mail" id="mailPart"> 
                    <?php }
                }else if ($_SESSION["usr_rol_id"]=="PART"){?> <input type="email" readonly class="form-control-plaintext" placeholder=<?php echo ($infosPartner["ptr_mail"]);?> > <?php }
            ?>
        </div> 
        <!--boutons switch-->
        <div class="form-check form-switch">
            <label class="form-check-label">Option Serviette</label>
            <?php
                if ($_SESSION["usr_rol_id"]=="TECH"){
                    $towelStatus="";
                    if((isset($_GET["editPart"]))){
                        if($partnerInfo["ptr_opt_towel"]==1){
                            $towelStatus="checked";
                        }
                    }
                    echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkTowel\" id=\"checkTowel\" ".$towelStatus.">"); 
                }
                else if ($_SESSION["usr_rol_id"]=="PART"){
                    $towelStatus="";
                    if($infosPartner["ptr_opt_towel"]==1){
                        $towelStatus="checked";
                    }
                    echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkTowel\" id=\"checkTowel\" ".$towelStatus. " disabled>");
                }
            ?>
        </div>
        <div class="form-check form-switch">
            <label class="form-check-label">Option Boissons</label>
            <?php
                if ($_SESSION["usr_rol_id"]=="TECH"){
                    $drinkStatus="";
                    if((isset($_GET["editPart"]))){
                        if($partnerInfo["ptr_opt_drinks"]==1){
                            $drinkStatus="checked";
                        }
                    }
                    echo ("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkDrinks\" id=\"checkDrinks\" ".$drinkStatus. " >");
                }
                else if ($_SESSION["usr_rol_id"]=="PART"){
                    $drinkStatus="";
                    if($infosPartner["ptr_opt_drinks"]==1){
                        $drinkStatus="checked";
                    }
                    echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkDrinks\" id=\"checkDrinks\" ".$drinkStatus. " disabled>");
                }
            ?>
        </div>
        <div class="form-check form-switch">
            <label class="form-check-label">Gestion Planning</label>
            <?php
                if ($_SESSION["usr_rol_id"]=="TECH"){
                    $planningStatus="";
                    if((isset($_GET["editPart"]))){
                        if($partnerInfo["ptr_opt_planning"]==1){
                            $planningStatus="checked";
                        }
                    }
                    echo( "<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkPlanning\" id=\"checkPlanning\" ".$planningStatus. " >");
                }
                else if ($_SESSION["usr_rol_id"]=="PART"){
                    $planningStatus="";
                    if($infosPartner["ptr_opt_planning"]==1){
                        $planningStatus="checked";
                    }
                    echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkPlanning\" id=\"checkPlanning\" ".$planningStatus. " disabled>");
                }
            ?>
        </div>
        <div class="form-check form-switch">
            <label class="form-check-label">Option encas</label>
            <?php
                if ($_SESSION["usr_rol_id"]=="TECH"){
                    $foodStatus="";
                    if((isset($_GET["editPart"]))){
                        if($partnerInfo["ptr_opt_food"]==1){
                            $foodStatus="checked";
                        }
                    }
                    echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkFood\" id=\"checkFood\" ".$foodStatus. ">");
                }
                else if ($_SESSION["usr_rol_id"]=="PART"){
                    $foodStatus="";
                    if($infosPartner["ptr_opt_food"]==1){
                        $foodStatus="checked";
                    }
                    echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"checkFood\" id=\"checkFood\" ".$foodStatus. " disabled>");
                }
            ?>
        </div>
        
        <!--liste deroulante-->
        
        <?php if ($_SESSION["usr_rol_id"]=="TECH"){?>
            <div> 
                <label class="form-check-label" >Gérant: </label>    
                <select name="userId" id="userId">
            <?php
                    while($user=mysqli_fetch_assoc($allPartnersUsers)){
                        $selectedPart="";
                        if((isset($_GET["editPart"]))){
                            if($user["usr_id"]==$partnerInfo["ptr_usr_id"]){
                                $selectedPart="selected";
                            }
                        }
                        echo ("<option value=\"".$user["usr_id"]."\" ".$selectedPart.">".$user["usr_name"]." - ".$user["usr_mail"]."</option>");
                    }
                ?>
            </select>
        </div>

        <!--Actif/inactif-->        
        <div class="form-check form-switch">
            <label class="form-check-label" >Active</label>
            <?php
                if ($_SESSION["usr_rol_id"]=="TECH"){
                    $actifStatus="";
                    if((isset($_GET["editPart"]))){
                        if($partnerInfo["ptr_active"]==1){
                            $actifStatus="checked";
                        }
                    }
                echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"actif\" id=\"actif\" ".$actifStatus. ">");
                }
                else if ($_SESSION["usr_rol_id"]=="PART"){
                    $actifStatus="";
                    if($infosPartner["ptr_active"]==1){
                        $actifStatus="checked";
                    }
                    echo("<input type=\"checkbox\" class=\"form-check-input\" role=\"switch\" name=\"actif\" id=\"actif\" ".$actifStatus. " disabled>");
                }
            ?>
        </div>
        <!--bouton creer ou modifier-->
        <div class="button" >
            <?php 
                if((isset($_GET["editPart"]))){
                    echo("<button type=\"submit\" onclick=\"return validerEdit()\" class=\"btn btn-outline-success\" name=\"modifier\" id=\"modifier\" style=\"margin:5px 0px\">Modifier</button>");
                }
                else {
                    echo("<button type=\"submit\" class=\"btn btn-outline-success\" name=\"creer\" id=\"creer\" style=\"margin:5px 0px\">Creer</button>");
                } ?>
        </div>
        <?php
            if((isset($_GET["editPart"]))){ 
                echo("<input type=\"hidden\" name=\"selectedPartId\" value=".$partnerInfo["ptr_id"].">");
            }
        } ?>
    </div>
</form>

<?php
    $icon = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-chevron-expand\" viewBox=\"0 0 16 16\">
    <path fill-rule=\"evenodd\" d=\"M3.646 9.146a.5.5 0 0 1 .708 0L8 12.793l3.646-3.647a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 0-.708zm0-2.292a.5.5 0 0 0 .708 0L8 3.207l3.646 3.647a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 0 0 0 .708z\"/>
    </svg>";
    $check = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-check-lg\" viewBox=\"0 0 16 16\">
    <path d=\"M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z\"/></svg>";
?>

<!--Liste de tous les partenaires -->
<?php if ($_SESSION["usr_rol_id"]=="TECH"){?>
    <div class="table-responsive" id="allPartners"> 
        <input type="text" class="form-control" id="lookFor" placeholder="Rechercher une Franchise..." >
        <table class="table tablesorter table-striped " id="listeAllPartners" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th scope="col"><?php echo $icon; ?>Id Franchise</th>
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
            <tbody id="listingPartners">
                <?php 
                    while($ptrInfo=mysqli_fetch_assoc($allPartnersInfo)){
                        if($ptrInfo["ptr_active"]==1) {$etat="Oui";}
                        else {$etat="Non";}
                        echo ("<tr>");
                        echo("<th scope=\"row\">".$ptrInfo["ptr_id"]."</th>");
                        echo("<td>".$ptrInfo["ptr_name"]."</td>");
                        echo("<td>".$ptrInfo["ptr_mail"]."</td>");
                        if($ptrInfo["ptr_opt_towel"]==1){echo("<td>".$check."</td>");}else{echo("<td></td>");}
                        if($ptrInfo["ptr_opt_drinks"]==1){echo("<td>".$check."</td>");}else{echo("<td></td>");}
                        if($ptrInfo["ptr_opt_planning"]==1){echo("<td>".$check."</td>");}else{echo("<td></td>");}
                        if($ptrInfo["ptr_opt_food"]==1){echo("<td>".$check."</td>");}else{echo("<td></td>");}           
                        echo("<td>".$etat."</td>");
                        echo("<td> 
                                <a class=\"btn btn-outline-secondary\" href=\"/front/partners/partners.php?editPart=".$ptrInfo["ptr_id"]."\" role=\"button\">
                                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-pencil\" viewBox=\"0 0 16 16\">
                                        <path d=\"M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z\"/>
                                    </svg>
                                </a></td>");
                        echo("</tr>");
                    }
                ?>
            </tbody>
        </table>
    </div>
<?php } ?>


</body>
</html>