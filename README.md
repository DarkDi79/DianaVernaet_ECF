# ECF BODY ACTIVE FITNESS CENTERS


Application web permettant à l'equipe technique du groupe, de gerer les franchisés et leurs structures
et d'offrir une interface d'information en lecture pour les franchises et leurs structures

## Structure :
```
 |-back             #répertoire contenant l'ensemble des fichiers back (modèle et contrôleur)
 |  |-centers       #répertoire contenant les fonctions et les requêtes des centres (salles)
 |  |-commun        #répertoire contenant les fonctions communes au back (session et connexion sql)
 |  |-partners      #répertoire contenant les fonctions et les requêtes des partenaires (franchises)
 |  |-users         #répertoire contenant les fonctions et les requêtes des utilisateurs (back admin)
 |-conf             #répertoire contenant les fichiers de configuration de l'application
 |-docs             #répertoire contenant la documentation de l'application 
 |-front            #répertoire contenant l'ensemble des fichiers front (vue)
 |  |-centers       #répertoire contenant les écrans de gestion des centres (salles)
 |  |-images        #répertoire contenant les images utilisées sur le site 
 |  |-partners      #répertoire contenant les écrans de gestion des partenaires (franchises) 
 |  |-users         #répertoire contenant les écrans de gestion des utilisateurs (front admin) 
```

## Procédure de déploiement

### Pré-requis
* un serveur Web (Apache, NGINX...)
* une base de données MariaDB ou MySQL
* un compte d'accès avec les droits ALL PRIVILEGES sur la base de données
* les services PHP et Postfix

### Création de la structure de la base de données
Se connecter à la base de données avec le compte ALL PRIVILEGES et executer le script `/conf/deployDB.sql`

### Déploiement des sources applicatives
Copier l'ensemble des fichiers du projet à la racine de votre serveur web

### Configuration de l'application
Modifier le fichier `/conf/config.php` pour qu'il corresponde à votre environnement
```php
<?php
    #DB configuration
    define('DBHOST','myhost');    #serveur base de données
    define('DBUSER','myuser');    #utilisateur de la base de données
    define('DBPWD','mypassword'); #mot de passe de l'utilisateur de la base de données
    define('DBNAME','mydb');      #nom de la base de données
?>
```
## Auteur

Diana Vernaët - diana.vernaet@gmail.com