<?php
    require 'back/commun/session.php';
    checkSession();
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

<!--link bootstrap css-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

<!--modifs perso sur css-->
<link rel="stylesheet" href="style.css">

<!--link bootstrap Javascript-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

<title>Dashboard</title> 

</head>

<body>
<?php
if(isset($_GET["msg"])){
    
    if ($_GET["msg"]=='noPartLink'){
        echo( "<script> alert (\"Vous n'êtes pas encore rattaché à une franchise. Merci de contacter l'équipe technique\"); </script>");
    }else if($_GET["msg"]=='noCentLink'){
        echo( "<script> alert (\"Vous n'êtes pas encore rattaché à une salle. Merci de contacter l'équipe technique\"); </script>");
    }
}

require 'front/menu.php' ;
?>

<div class="container page-overlay" id="wellcome">
    <h4>BODY ACTIVE FITNESS CENTERS</h4>
    <br>
    <?php if($_SESSION["usr_rol_id"]=="TECH"){ ?>
    <p> Bienvenue sur votre page Administrateur! <br>
    <br>
        Si vous voulez créer un nouvel utilisateur, il suffit de cliquer sur Admin <br>
        <br>
        Pour créer ou gerer les franchises et les salles, il suffit de cliquer sur le bouton correspondant en haut de la page <br>
        <br>
        Pour modifier ou vérifier votre profil, rien de plus simple, il suffit de cliquer sur votre profil en haut à droite! <br>        
    </p>
    <?php }
        if($_SESSION["usr_rol_id"]=="PART"){ ?>
    <p> Bienvenue sur votre page Partenaire! <br>
        <br>
        Pour avoir accès à toutes les infos concernant votre franchise il suffit de cliquer sur "Franchises" <br>
        <br>
        Pour voir la liste de vos salles et leurs informations, il suffit de cliquer sur "Salles"<br>
        <br>
        Pour voir votre profil, rien de plus simple,  il suffit de cliquer en haut à droite! <br>        
    </p>
    <?php }
        if($_SESSION["usr_rol_id"]=="CENT"){ ?>
    <p> Bienvenue sur la page de votre Salle! <br>
        <br>
        Pour voir toutes les infos concernant votre salle il suffit de cliquer sur "Salle"<br>
        <br>
        Pour voir votre profil, rien de plus simple, il suffit de cliquer en haut à droite! <br>        
    </p>
    <?php } ?>
</div>

</body>
</html>