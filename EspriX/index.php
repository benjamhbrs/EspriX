<!DOCTYPE html>
<html>

<!--Toutes les pages du site sont en réalité des sous pages de ce fichier php,
index.php.todo, dans GET, precise dans quelle sous page nous nous trouvons-->

<head>
    <!--EspriX sera le titre de toutes les pages du site-->
    <title>EspriX</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="mon_css/general.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <script src="mon_js/index.js"></script>
    
</head>

<?php

# gestion session
session_start();
if (!isset($_SESSION["initiated"])) {
    session_regenerate_id();
    $_SESSION["initiated"] = true;
    if (!isset($_SESSION["connected"])) {
        $_SESSION["connected"] = false;
    }
}
# si l'utilisateur a utilisé le gadget de changement de couleur, on actualise 
# la nouvelle couleur, stockée dans Session
if (isset($_GET["change_color"])) {
    $color = $_GET["change_color"];

    $_SESSION["color"] = $color;
}

# La couleur rentrée par l'utilisateur est utilsée partout en background
if (isset($_SESSION["color"])) {
    echo "<body style='background-color : #".$_SESSION["color"]."'>";
} else {
    echo "<body style='background-color : beige'>";
}
?>

        <?php
        require "database.php";  # pour interragir avec la bdd
        require "head_bar.php";  # pour afficher la bare de navigation

        function lancer_inspi()
        {

            # differents liens amusants ou inspirants (choix subjectif)
            # Un des liens est selectionne aleatoirement quand on clique sur 
            # Inspiration dans la bare de navaigation
            $links = [
                "https://www.youtube.com/channel/UCfE1oQ47oqyJNzM-nFy_gjA/videos",
                "https://www.senscritique.com/",
                "https://www.ted.com/",
                "https://www.lesswrong.com/",
                "http://rationallyspeakingpodcast.org/",
                "https://www.youtube.com/user/measureofdoubt",
                "https://www.franceculture.fr/",
                "https://www.youtube.com/c/theschooloflifetv",
                "https://www.effectivealtruism.org/",
                "https://www.academie-francaise.fr/",
                "https://fr.wikipedia.org/wiki/Aaron_Swartz",
            ];
            $randomlink = array_rand($links, 1);
            $selected_url = $links[$randomlink];

            // on ouvre un nouvel onglet car on utilise _blank
            echo "<script>window.onload = function(){window.open('" .
                $selected_url .
                "', '_blank');}</script>";
        }


        # par defaut si aucune sous page n'est specifiee, on ramene a la page principale
        $todo = "";
        if (isset($_GET["todo"])) {
            $todo = $_GET["todo"];
        } else {
            $todo = "welcome_page";
        }

        # amener les diffentes sous pages
        if ($todo == "welcome_page") {
            include "welcome_page.php";
        } elseif ($todo == "afficher_textes") {
            include "textslist.php";
        } elseif ($todo == "ecrire_texte") {
            include "text_upload.php";
        } elseif ($todo == "display_text") {
            include "display_text.php";
        } elseif ($todo == "mes_textes") {
            include "mes_textes.php";
        } elseif ($todo == "search_text") {
            include "search_text.php";
        } elseif ($todo == "inspiration") {
            include "welcome_page.php";
            lancer_inspi();
        }
        ?>


    </body>

</html>