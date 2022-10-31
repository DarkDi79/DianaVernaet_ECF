<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
<!--link bootstrap css-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

<!--inserer ici les modifs perso sur css-->
<link rel="stylesheet" href="style.css">

<!--link bootstrap Javascript-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

<script>
    function testAlert(message)
        {
            alert(message);
        }
</script>

<title>Authentification</title> 

</head>
<body>
<?php
if(isset($_GET["msg"])){
    $erreurconn=$_GET["msg"];
    if ($erreurconn=='wronglogin'){
        echo( "<script> testAlert (\"Merci de vérifier votre nom utilisateur et/ou mot de passe\"); </script>");
    }else if($erreurconn=='expire'){
        echo( "<script> testAlert (\"Session expirée - Veuillez vous reconnecter\"); </script>");
    }else if($erreurconn=='disconnect'){
        echo( "<script> testAlert (\"Vous êtes déconnecté\"); </script>");
    }
}
?>


<div class="header">
    <h1> BODY ACTIVE FITNESS CENTERS</h1>
</div>
<div class="container page-overlay" id="msgConn"> 
    <h2>Veuillez vous connecter</h2>
    </div>
<!--formulaire de connexion-->
<form action="/front/auth.php?action=connect" method="post">
    <div class="container page-overlay">
        <h3>Connexion</h3>
        <div class="mb-2">
            <label for="connexion" class="form-label">Email </label>
            <input type="email" class="form-control" placeholder="name@example.com" name="usermail" required >
        </div>
        <div class="mb-2">
            <label for="connexion" class="form-label">Mot de Passe</label>
            <input type="password" class="form-control" placeholder="mot de passe" name="password" required >
        </div>
        <div class="col-12">
            <button type= "submit" class="btn btn-primary" name="submit">Valider</button>
        </div>
</form>



</body>
</head>