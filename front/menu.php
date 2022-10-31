<!--link bootstrap css-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

<!--modifs perso sur css-->
<link rel="stylesheet" href="style.css">

<!--link bootstrap Javascript-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


<!--Fonctions date et salutations-->
<script>
    function hour(){
        var time = new Date();
        return time.getHours()+1;
    }
    function today() {
        var d = new Date();
        return d.getDate()+"/"+(d.getMonth()+1)+"/"+d.getFullYear();
    }
    function hello(){
        if(hour()>17){
            return "Bonsoir";
        }else{
            return "Bonjour";
        }
    }   
    
</script>

<div class="header" >
    <h1> BODY ACTIVE FITNESS CENTERS </h1>
</div>

<header class="p-3 container-fluid sticky-top">
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify content-lg-start ">
            <!--bouton home-->
            <a class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none" style="margin-right:10px" href="/front/dashboard.php"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                    <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                </svg>
            </a>
            <!--elements du menu-->        
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <?php if($_SESSION["usr_rol_id"]=="TECH"){ ?>
                    <li>
                        <a class="nav-item px-2 btn btn-outline-primary" href="/front/users/users.php">Admin</a>                    
                    </li>
                        <?php }
                        if($_SESSION["usr_rol_id"]=="TECH"||$_SESSION["usr_rol_id"]=="PART"){ ?>
                    <li>
                    <a class="nav-item px-2 btn btn-outline-primary" style="margin-left:10px" href="/front/partners/partners.php">Franchises</a>
                    </li>
                    <?php } ?>
                    <li>
                    <a class="nav-item px-2 btn btn-outline-primary" style="margin-left:10px" href="/front/centers/centers.php">Salle</a>
                    </li>
            </ul>
                <!--salutations-->
            <div class="text-end" style="margin-right:10px">
                <script>document.write(hello());
                </script>
            <!--prenom de l'utilisateur-->
                <?php echo ($_SESSION["usr_name"]);?>
            <!--date-->
                <script>document.write(today());
                </script>
            </div>
            <!--bouton profil utilisateur-->
            <div class="text-end" >
                <a href="/front/profil.php">
                <button class="nav-link btn btn-primary"style="margin-right:10px" > 
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="black" class="bi bi-person-badge" viewBox="0 0 16 16">
                        <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                        <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492V2.5z"/>
                    </svg> 
                </button>    
                </a>
            </div>   
            <!--bouton deconnexion-->
            <div class="text-end">
                <a href="/front/auth.php?action=disconnect" >
                    <button class="nav-link btn btn-success" style="margin-right:10px">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="black" class="bi bi-power" viewBox="0 0 16 16">
                            <path d="M7.5 1v7h1V1h-1z"/>
                            <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/>
                        </svg>
                    </button>
                </a>
            </div>
        </div>
    </div>
    </header>