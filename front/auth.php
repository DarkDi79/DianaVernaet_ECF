   
<?php

require 'back/commun/session.php';

#connexion
if (isset($_GET["action"])) {
    if ($_GET["action"]=="connect") {
        if (isset ($_POST["submit"])) {
            #importation des fonctions utilisateur
            require 'back/users/users.php';
            $usermail=$_POST["usermail"];
            $password=$_POST["password"];
            
            if (authentication ($usermail, $password)){
                connectSession($usermail);
            }else{
                header("Location: /front/login.php?msg=wronglogin");
                exit();
            }
            
        }
    #déconnexion
    }else if($_GET["action"]=="disconnect"){
        disconnectSession();
    }    
}


?>