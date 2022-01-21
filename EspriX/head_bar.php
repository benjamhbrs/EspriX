<?php

# le fichier qui contient la bare de navigation qui se trouve constamment 
# en haut de l'écran


if ($_SESSION["connected"]) {
    $is_connected_str = "true";
} else {
    $is_connected_str = "false";
}

# on stocke dans une variable javascript le fait que l'utilisateur est connecté
# pour reutiliser cela dans mon_js/index.js et pouvoir par exemple masquer sign up
# si l'utilsateur est deja connecté
echo "<script> var connected = $is_connected_str; </script>";

/* Vu que la bare de navigation est accessible depuis plusieurs sous page
(meme si en pratique on est toujours chez index.php, mais on utilise toto),
quand on se login, sign up ou log out, on a envie de rester sur la page actuelle.
Le code qui suit se charge de conserver l'URL (le GET) mais en le modifiant 
un chouilla pour que l'action (login ...) soit bien prise en compte.

Ces urls seront donnes aux boutons concernés dans la bare de navigation.*/

$copy_GET = $_GET;
$copy_GET["action"] = "tente_login";
$tente_login_url = "index.php?" . http_build_query($copy_GET);
$copy_GET["action"] = "sign_up";
$sign_up_url = "index.php?" . http_build_query($copy_GET);
$copy_GET["action"] = "disconnect";
$disconnect_url = "index.php?" . http_build_query($copy_GET);


function connect_user($pseudo)
{
    $_SESSION["connected"] = true;
    $_SESSION["pseudo"] = $pseudo;
    echo "<script> var connected = true; </script>";
}

function disconnect_user()
{
    $_SESSION["connected"] = false;
    unset($_SESSION["pseudo"]);
    echo "<script> var connected = false; </script>";
}
?>


<!--Le code html de la bare de navigation.
A noter que du php intervient aux niveaux de certaines urls.
Cf le commentaire ci dessus.-->
<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top" syle='position:fixed;width:100%'>
    <a class="navbar-brand" href="index.php">ExpriX</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php?todo=afficher_textes"><span>Les textes</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?todo=ecrire_texte"><span>Ecrire</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?todo=mes_textes"><span>Mes textes</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?todo=inspiration"><span>Inspiration</span></a>
            </li>
            <li class="nav-item dropdown" id="sign_in_component">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sign in
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <form method="post" action=<?php echo "'$tente_login_url'"; ?>>
                        <input class="dropdown-item" type="text" name="login" placeholder="Login" />
                        <input class="dropdown-item" type="password" name="password" placeholder="Password" />
                        <input class="dropdown-item" type="submit" value="Submit" />
                    </form>
                </div>
            </li>

            <li class="nav-item dropdown" id="sign_up_component">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sign up
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                    <form method="post" action=<?php echo "'$sign_up_url'"; ?>>
                        <input class="dropdown-item" type="text" name="pseudo" placeholder="Pseudo" />
                        <input class="dropdown-item" type="text" name="promo" placeholder="Promo" />

                        <input class="dropdown-item" type="password" name="password_1" placeholder="Password" />
                        <input class="dropdown-item" type="password" name="password_2" placeholder="Confirm password" />
                        <input class="dropdown-item" type="submit" value="Confirm" />
                    </form>
                </div>
            </li>

            <li class="nav-item" id="disconnect_button">
                <a class="nav-link" href=<?php echo "'$disconnect_url'"; ?>>Sign out</a>
            </li>

        </ul>

        <form method="post" action="index.php?todo=search_text" class="form-inline my-3 my-lg-2">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Rentrez un mot-clef." aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>


<!-- reaction aux potentielles tentatives de connection :
-log in
-log out
-sign up-->
<?php
$action = "";
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "rien_a_faire";
}

if ($action === "tente_login") {
    $pseudo = $_POST["login"];
    $password = $_POST["password"];

    if (check_login($pseudo, $password)) {
        connect_user($pseudo);
    } else {
        $message = "wrong credentials, please try again";

        echo "<script>alert('$message');</script>";
    }
} elseif ($action === "disconnect") {
    disconnect_user();
} elseif ($action === "sign_up") {
    $pseudo = $_POST["pseudo"];
    $promo = $_POST["promo"];
    $password_1 = $_POST["password_1"];
    $password_2 = $_POST["password_2"];

    # un petit peu d'histoire ne fait jamais de mal
    ($promo_is_valid = intval($promo) >= 1794) and intval($promo) <= 2021;
    # les verifications habituelles relatives a la creation d'un
    # nouveau compte
    if (!$promo_is_valid) {
        echo "<script> alert('Etes vous sûr d\'être réellement un polytechnicien ?');</script>";
    } elseif (login_already_exists($pseudo)) {
        echo "<script> alert('This login already exits, please choose another one.');</script>";
    } elseif ($password_1 != $password_2) {
        echo "<script> alert('The passwords are different, please try again.');</script>";
    } elseif (strlen($password_1) < 5) {
        echo "<script> alert('Le mot de passe doit contenir au moins 5 caractères.');</script>";
    } else {
        register_new_user($pseudo, $password_1, $promo);
        connect_user($pseudo);
    }
} else {
}


?>
