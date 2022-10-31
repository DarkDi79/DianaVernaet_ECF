<?php
    require 'back/commun/session.php';
    require 'back/users/users.php';
    checkSession();

    $allUsers = getInfoAllUsers();
    $allRoles = getAllRoles();

    #si action bouton valider : créer l'utilisateur

   
    if(isset($_POST["creer"])){
        
        $res = createNewUser ($_POST["prenom"], $_POST["roles"], $_POST["mail"]);        
        
        if($res==true){
            echo ("<script> alert(\"L'utilisateur ".$_POST["prenom"]." a été créé\");</script>");
        }
        else{
            echo ("<script> testAlert(\"La création a achoué\");</script>");
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
        $("#lookUp").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#listing tr").filter(function() {
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




<title>Administrateurs</title> 

</head>

<body>
<?php
require 'front/menu.php' ;
?>

<!--creation d'un nouvel les utilisateur-->


<hr class="hr">
<form action="/front/users/users.php" method="post">
    <input type="hidden" name="create" value="create">
    <div class="container page-overlay" id="creationUser">
    <h5>AJOUTER UN NOUVEL UTILISATEUR</h5>
        <div class="form-group">
            <label style="margin-bottom:10px" class="text">Prénom</label>
            <input type="text" required="vital" class="form-control" name="prenom" id="prenom">
        </div>
        <div class="form-group">
            <label style="margin-bottom:10px" class="text">Mail</label>
            <input type="email" required="vital" class="form-control" name="mail" id="mail">
        </div>
        <div class="form-group">
            <label style="margin-bottom:10px margin-top:20px" class="text">Role</label>
            <select name="roles" id="roles">
                <?php
                    while($role=mysqli_fetch_assoc($allRoles)){
                        echo ("<option value=\"".$role["rol_id"]."\">".$role["rol_name"]."</option>");
                    }
                ?>
            </select>
        </div>
        <div class="button">
            <button type=submit class="btn btn-outline-success" name="creer" style="margin:5px 0px">Creer</button>
        </div>

</div>
</form>

<!--Liste de tous les partenaires et salles-->
<?php
    $icon = "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-chevron-expand\" viewBox=\"0 0 16 16\">
    <path fill-rule=\"evenodd\" d=\"M3.646 9.146a.5.5 0 0 1 .708 0L8 12.793l3.646-3.647a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 0-.708zm0-2.292a.5.5 0 0 0 .708 0L8 3.207l3.646 3.647a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 0 0 0 .708z\"/>
    </svg>"
?>
<div class="table-responsive" id="listeAllUsers"> 
    <input type="text" class="form-control" id="lookUp"  placeholder="Rechercher...">
    <table class="table tablesorter table-striped" id="listeAllPartners" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th scope="col"><?php echo $icon; ?>Id Utilisateur</th>
                <th scope="col"><?php echo $icon; ?>Prenom</th>
                <th scope="col"><?php echo $icon; ?>Mail</th>
                <th scope="col"><?php echo $icon; ?>Role</th>
                
            </tr>
        </thead>
        <tbody id="listing">
        <?php
            while($users=mysqli_fetch_assoc($allUsers)){
                echo ("<tr>");
                echo("<th scope=\"row\">".$users["usr_id"]."</th>");
                echo("<td>".$users["usr_name"]."</td>");
                echo("<td>".$users["usr_mail"]."</td>");
                echo("<td>".$users["rol_name"]."</td>");
                echo("</tr>");
            }
        ?>
        </tbody>
    </table>
</div>



</body>
</html>