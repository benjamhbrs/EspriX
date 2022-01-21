<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="mon_js/mes_textes.js"></script>
<link rel="stylesheet" href="mon_css/mes_textes.css" />

<?php

/*Ici sera affichée la liste des textes de l'utilisateur. 
Il a la capcité de les supprimer. On affiche a droite de l'ecran le resumé, 
mais il y a la possibilité de l'afficher integralement via un bouton.
*/

# Pour acceder a cette setion, il faut évidemment etre connecte.
# Dans le cas contraire, un message d'erreur est affiché pour inviter l'utilsateur
# a se connecter
if ($_SESSION['connected']) {
    $pseudo = $_SESSION["pseudo"];
} else {
    echo "<pre> Veuillez d'abbord vous connecter.</pre>";
    exit();
}


// on gere la requette GET de suppression du compte, la confirmation 
// par l'utilisateur a deja eu lieu
if (isset($_GET['action']) && $_GET['action'] == 'supprimer_compte') {
    remove_user($pseudo);
    $_SESSION['connected'] = false;
    echo "<script> window.location.replace('index.php');</script>";
    exit();
}


// TRES IMPORTANT
// sécurité: pour supprimer un texte il faut etre son auteur
// Mais on refait la verifaction en back, on ne se contente pas du GET
if (isset($_GET['action']) && $_GET['action'] == 'supprimer_texte') {
    if (isset($_GET['id_texte'])) {
        $id_texte = $_GET['id_texte'];
        if (is_text_id_in_data_base($id_texte)) { //pas vraiment nécessaire car SQL ne buggerait pas
            if ($pseudo == get_text_author($id_texte)) {
                remove($id_texte);
            }
        }
    }
}
?>


<div style="margin:10px">
    <?php
    echo '<a class = "button3" > <span> Supprimer mon compte</span> </a> ';
    ?>

</div>


<!--La structure html permettant l'affiche a gauche des noms, auteurs, et dates des textes,
et a droite dy resume + bouton pour etendre le texte + supprimer-->

<div class="row" style="padding : 40px">
    <div class="col-5 rounded afftitres">
        <div class="list-group" id="list-tab" role="tablist">
            <?php
            $dbh = Database::connect();
            $sth = $dbh->prepare("SELECT `id`,`pseudo`,`title`,`date`,`summary` FROM `textes` WHERE `pseudo`= ? ORDER BY `date` DESC");
            $sth->execute(array($pseudo));
            while ($donnees = $sth->fetch(PDO::FETCH_ASSOC)) {
                echo '<a class="list-group-item list-group-item-action rounded" id = "list-' . $donnees["id"] . '-list" data-toggle="tab" href="#list-' . $donnees["id"] . '" role="tab" aria-controls="list-' . $donnees["id"] . '" style = "background-color :#a4bfb6; border:0px; color:black"><b>' . $donnees["title"] . '</b>, écrit le ' . $donnees["date"] . ' par ' . $donnees["pseudo"] . ' </a> ';
            }
            ?>
        </div>
    </div>
    <div class="col-7 rounded affsummary">
        <div class="tab-content" id="nav-tabContent" style="overflow:scroll">
            <?php
            $sth = $dbh->prepare("SELECT `id`,`pseudo`,`title`,`date`,`summary` FROM `textes` ORDER BY `date` DESC");
            $sth->execute();
            while ($donnees = $sth->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="tab-pane fade" id = "list-' . $donnees["id"] . '" role="tabpanel" aria-labelledby="list-' . $donnees["id"] . '-list">';
                echo '<p> Résumé : ' . $donnees["summary"] . '</p>';

                /* Un bouton pour afficher l'integralite du texte.*/

                $first_id_topic = get_first_topic_id($donnees["id"]); /* topic général est le premier ajouté pour chaque texte */
                echo '<br><bouton class="button2" data-id_texte = "' . $donnees['id'] . '" data-first_id_topic = "' . $first_id_topic . '"> <span> En savoir plus </span> </bouton> ';

                /* Le bouton pour supprimer un texte (pas de condition administrateur comme pour la page textslist.php):
                on lui rajoute un tag avec son identifiant qui sera
                ensuite recupéré par /mon_js/mes_textes.js. Avec ce tag,
                javascript lancera l'URL, avec l'id du texte en POST, pour initier
                la suppression. ON refait des verifications de securite ensuite en
                back pour s'assurer que la suppression est autorisée*/

                echo '<bouton class = "button1" data-id_texte = "' . $donnees['id'] . '"> <span> Supprimer  </span> </bouton> ';

                echo '</div>';
            }
            $dbh = null;
            ?>
        </div>
    </div>
</div>