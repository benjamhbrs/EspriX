<script  src="mon_js/search_text.js"></script>
<link rel="stylesheet" type="text/css" href="mon_css/search_text.css">

<?php

/*Ici sera affichée la liste des textes issus de la recherche. 
On affiche a droite de l'ecran le resumé, mais il y a la possibilité d'fficher 
integralement le texte via un bouton.

Si la personne qui est connectée est admin (dans la bdd, cela se traduit par admin=1),
on rajoute des boutons pour supprimer les textes.
*/

// TRES IMPORTANT
// sécurité: pour supprimer un texte il faut etre administrateur
// Mais on refait la verifaction en back, on ne se contente pas du GET
if (isset($_GET['action']) && $_GET['action'] == 'supprimer_texte') {
    if (isset($_GET['id_texte'])) {
        $id_texte = $_GET['id_texte'];
        if ($_SESSION['connected'] and is_text_id_in_data_base($id_texte)) { //pas vraiment nécessaire car SQL ne buggerait pas
            $pseudo = $_SESSION["pseudo"];
            if(is_admin($pseudo)){
                remove($id_texte);
            }
            
        }
    }
}
?>

<!--La structure bootstrap permettant l'affiche à gauche des noms, auteurs, et dates des textes,
et à droite : résumé + bouton pour étendre le texte et supprimer si l'utilsateur est admin-->

<div class="row" style="padding : 30px; height:100%">
    <div class="col-5 rounded afftitres"> <!-- affichage des noms -->
        <div class="list-group" id="list-tab" role="tablist">
                    <?php 
                        $dbh = Database::connect();
                        $sth = $dbh->prepare("SELECT `id`,`pseudo`,`summary`,`date`,`title` FROM `textes` WHERE `pseudo` LIKE ? OR `main` LIKE ?");
                        $sth->execute(array('%'.$_POST['search'].'%','%'.$_POST['search'].'%'));
                        while($donnees = $sth->fetch(PDO::FETCH_ASSOC)){
                            echo '<a class="list-group-item list-group-item-action rounded" id = "list-'.$donnees["id"].'-list" data-toggle="tab" href="#list-'.$donnees["id"].'" role="tab" aria-controls="list-'.$donnees["id"].'" style = "background-color :#a4bfb6; border:0px; color:black"><b>'.$donnees["title"].'</b>, écrit le '.$donnees["date"].' par '.$donnees["pseudo"].' </a> '; 
                        }
                    ?>
                </div>
            </div>
            <div class="col-7 rounded affsummary"> <!-- affichage des summaries -->
        <div class="tab-content" id="nav-tabContent" style="overflow:scroll">
                    <?php 
                        $sth = $dbh->prepare("SELECT `id`,`pseudo`,`summary`,`date`,`title` FROM `textes` WHERE `pseudo` LIKE ? OR `main` LIKE ?");
                        $sth->execute(array('%'.$_POST['search'].'%','%'.$_POST['search'].'%'));
                        while($donnees = $sth->fetch(PDO::FETCH_ASSOC)){
                            echo '<div class="tab-pane fade" id = "list-'.$donnees["id"].'" role="tabpanel" aria-labelledby="list-'.$donnees["id"].'-list">';
                            echo '<p> Résumé : '.$donnees["summary"].'</p>';

                            /* Un bouton pour afficher l'integralite du texte.*/

                            $first_id_topic = get_first_topic_id($donnees["id"]); /* topic général est le premier ajouté pour chaque texte */
                            echo '<br><bouton class="button2" data-id_texte = "' . $donnees['id'] . '" data-first_id_topic = "' . $first_id_topic. '"> <span> En savoir plus </span> </bouton> ';
                            
                            /* SI LA PERSONNE CONNECTEE EST ADMIN :
                            On ajoute un bouton pour supprimer un texte,
                            on luit rajoute un tag avec son identifiant qui sera
                            ensuite recupere par /mon_js/textslist.js. Avec ce tag,
                            javascript lancera l'URL, avec l'id du texte en POST, pour initier
                            la suppression. ON refait des verifications de securite ensuite en
                            back pour s'assurer que la suppression est autorisée*/
                            
                            if ($_SESSION['connected']) {
                                $pseudo = $_SESSION["pseudo"];
                                $admin = is_admin($pseudo);
                            } else {
                                $admin = false;
                            }

                            if ($admin) {
                                echo '<bouton class = "button1" data-id_texte = "' . $donnees['id'] . '"> <span> Supprimer  </span> </bouton> ';
                            }
                            
                            echo '</div>';

                        }
                        $dbh = null;
                    ?>
                </div>
            </div>
        </div>

