<?php
    require 'back/commun/session.php';
    session_start();

    if(isset($_GET["msg"])){
        if ($_GET["msg"]=='firstConn'){
            echo( "<script> alert (\"Première connexion: veuillez modifier votre mot de passe\"); </script>");
        }
    }

    if (isset ($_POST["saveNewPwd"])) {
        #importation des fonctions utilisateur
        require 'back/users/users.php';
        $password=$_POST["passwordOne"];
        $res=changeUserPwd ($password,$_SESSION["usr_id"]);
        if ($res){
            $_SESSION["usr_change_pw"]=0;
            echo( "<script> alert (\"Le mot de passe a bien été modifié\"); </script>");
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
<link rel="stylesheet" href="style.css">

<!--link bootstrap Javascript-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


<script>
    //fonction pour verifier la correspondance des MDP
    function checkPassword(){
        var passwordOne=document.getElementById('passwordOne').value;
        var confirmPassword=document.getElementById('confirmPassword').value;
        
        if (passwordOne!=confirmPassword){
            document.getElementById('unmatchingPwd').style.color='red';
            document.getElementById('unmatchingPwd').innerHTML='Les mots de passe ne correspondent pas';
            document.getElementById('saveNewPwd').disabled=true;
            document.getElementById('saveNewPwd').style.opacity=(0.4);
        }else{
            document.getElementById('unmatchingPwd').style.color='blue';
            document.getElementById('unmatchingPwd').innerHTML='Les mots de passe correspondent';
            document.getElementById('saveNewPwd').disabled=false;
            document.getElementById('saveNewPwd').style.opacity=(1);
        }
    }
</script>

<title>Profil</title> 

</head>

<body>
<?php
require 'front/menu.php' ;
?>

<!--formulaire de modification du nom ou du mot de passe-->

<form action="/front/profil.php?msg=ok" method="post">
    <div class= "container page-overlay" Id="MonProfil">
        <h3>Mon Profil</h3>
        <div class="mb-2">
            <label class="text">Prénom </label>
            <input type="text" id="prenom" name="prenom" readonly class="form-control-plaintext" placeholder=<?php echo ($_SESSION["usr_name"]);?>>
        </div>
        <div class="mb-2">
            <label name="EMailutilisateur">Votre E-Mail</label>
            <input type="text" readonly class="form-control-plaintext" placeholder=<?php echo ($_SESSION["usr_mail"]);?>>
        </div>
        <div class="mb-2">
            <label class="form-label">Mot de Passe</label>
            <input onkeyup="checkPassword()" type="password" id="passwordOne" name="passwordOne" class="form-control" placeholder="mot de passe"  required >
        </div>
        <div class="mb-2">
            <label class="form-label">Confirmation du Mot de Passe</label>
            <input onkeyup="checkPassword()" type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirmer le mot de passe" required >
        </div>
        <span id="unmatchingPwd"></span>
        <div class="col-12">
            <button type= "submit" class="btn btn-primary" id="saveNewPwd" name="saveNewPwd">Enregistrer</button>
        </div>
    </div>
</form>


</body>
</html>