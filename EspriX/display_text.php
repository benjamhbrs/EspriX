<link rel="stylesheet" href="mon_css/display_text.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<script src="mon_js/display_text.js"></script>

<?php

# Cette page est chargée d'afficher un texte (son titre, son image, son contenu, ses commentaires)

#quel texte afficher ?
$id_text = -1;
if (isset($_GET["id_text"])) {
    $id_text = $_GET["id_text"];
    if (!is_text_id_in_data_base($id_text)) {
        echo "<h1>ID not found in data base </h1>";
        exit();
    }
} else {
    echo "<h1>ID not found in GET </h1>";
    exit();
}

# y a t-il ordre de creer un nouveau topic sur ce texte ?
if (isset($_GET["action"]) && $_GET["action"] == "nouveau_topic") {
    register_new_topic($id_text, $_POST["nouveau_topic_str"]);
}

# si pas de topic precisé en GET, on prends le premier dans la BDD
# il y en a forcemennt un (general), cf la creation d'un nouveau texte
if (!isset($_GET["id_topic"])) {
    $first_id_topic = get_first_topic_id($id_text);

    echo "<script> window.location.replace('index.php?todo=display_text&id_text=" .$id_text ."&id_topic=" .$first_id_topic ."');</script>";
}

# ce qu'il faudra afficher (en pratique on a decidé de ne pas afficher le resume ici)
$text_to_display = nl2br(htmlspecialchars(get_main_text($id_text)));
$title = htmlspecialchars(get_title($id_text));
$summary = nl2br(htmlspecialchars(get_summary($id_text)));

# les titres des differents topics et leurs ids respectifs
$topics = get_topics($id_text);
$topic_ids = $topics[0];
$topic_names = $topics[1];

# securite supplementaire, mais normalement avec ce qui est au dessus, 
# on s'assure qu'il y a toujours l'id du topic en cours dans GET
# on parle ici de securite contre les bugs et non pas contre des attaques sur la bdd

$id_topic = -1;
if (isset($_GET["id_topic"])) {
    $id_topic = $_GET["id_topic"];
} else {
    $id_topic = get_first_topic_id($id_text);
}
?>


 <!--Si elle existe, on préparé l'affichage de l'image rentrée par l'utilsateur lors
de la creation du texte -->
<?php
$image = "images/" . $id_text . ".jpeg";

if (file_exists($image)) {
    $is_image_set = true;
}
else{ $is_image_set = false;}
?>

 <!--Affichage du titre du texte-->
 <?php echo "<h1 class='title'>$title</h1>"; ?>

 <!--Affichage éventuel de l'image-->
 <?php 
    if ($is_image_set) { echo "<img class='center' src='" .$image ."'>" ;}
    else { echo "<h1 class='center' style = 'font-size:10px'>Pas d'image, c'est dommage... </h1>"; }
?>

 <!--Affichage du texte principal-->
<?php echo "<div class='center2' style = 'font-size:10px; text-align:justify'>" . $text_to_display . "</div>"; ?>
<div class="small_space"> </div>


 <!--Affichage des differents topics existants sur ce texte.
Un form permets de creer un nouveau topic.-->

<div class="row">
    <div class="column_small" style = 'text-align:left ;margin-left:10px'>
        <div id="topic_above_title" style = 'text-align:left; font-weight:bold'> Topics : </div>
        <div class="topic_button_group" style = 'text-align:left'>
            <?php for ($i = 0; $i < count($topic_names); $i++) {
                echo "<button class='clickable_button' data-id_topic = '" .
                    $topic_ids[$i] .
                    "' data-id_text = '" .
                    $id_text .
                    "'>" .
                    $topic_names[$i] .
                    "</button>";
            } ?>

            <form method="post" id = "form_topic" class="form-style-4" action=<?php echo "'index.php?todo=display_text&id_text=$id_text&action=nouveau_topic&id_topic=$id_topic'"; ?>>
                <span style = 'font-weight:bold'>Une idée d'un nouveau sujet à aborder ?</span><br><br>
                    <textarea form="form_topic" name="nouveau_topic_str" required="required" style='color:black'></textarea><br>
                <span></span><input type="submit" value="Valider" />
            </form>

        </div>
    </div>

    <div class="column_big" >

     <!--affichage des commentaires relatifs au topic en cours-->

        <?php if ($_SESSION["connected"]) {
            if (are_comments_allowed($id_text)){
                $pseudo = $_SESSION["pseudo"];
                echo "<div class='comments'></div>";
            }else{
                echo "<h3> Les commentaires ne sont pas pas autorisés pour ce texte ...</h3>";
            }
        } else {
            echo "<h3> Veuillez d'abord vous connecter pour accéder à l'espace commentaire.</h3>";
        } ?>
        
    </div>
</div>