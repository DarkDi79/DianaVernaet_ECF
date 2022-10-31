<?php 

#chargement des variables techniques mariadb
require 'conf/config.php'; 

#fonction connexion db
function dbConnect (){
    $mydbConnect = mysqli_connect(DBHOST, DBUSER, DBPWD, DBNAME);
    if(!$mydbConnect){
        exit("Connection Failed!".mysqli_connect_error());
    }
    return $mydbConnect;
}

#fonction déconnexion db
function dbDisconnect ($dbSession){
    mysqli_close($dbSession);
}

?>