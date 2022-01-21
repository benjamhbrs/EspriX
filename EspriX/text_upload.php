<script src="mon_js/text_upload.js"></script>
<link href="mon_css/text_upload.css" rel="stylesheet">


<!--Si l'utilsateur est connecté, on affiche le form pour soumettre un nouveau texte.-->
<?php if ($_SESSION["connected"]) {
    echo <<<a

      <div id='centereddiv'>
      <form method='post' id='log' action='index.php?todo=ecrire_texte&action=soumettre_texte' enctype="multipart/form-data">
          <fieldset>

              <legend>Informations</legend>
      
              <input name='title' id='title' placeholder='Titre' required style='width:100%'> <br><br>
      
              <label > 
              <input type="date" id='datepicker' name="date" size="30" style = 'margin-right:10px'>La date sera fixée à aujourd'hui par défaut.
              </label>
              <br><br>

              <span>Commentaires autorisés : </span>
              <br><br>
                <label class="containere">Oui, vive la libre circulation des idées
                    <input type = "radio" checked="checked" value = "1" name="commentaires_autorises">
                    <span class="checkmark"></span>
                </label>
                <label class="containere">Non, vive la pensée unique
                    <input type = "radio" value = "0" name="commentaires_autorises">
                    <span class="checkmark"></span>
                </label>
      
          </fieldset>
          <br>
          <fieldset>
              
              <legend>Texte et illustration</legend>
              <textarea form='log' name='summary' required rows='3' cols='100' id='summary' placeholder='Résumé' style="padding:5px"></textarea> <br>
      
              <textarea form='log' name='texte' rows='15' required cols='100' placeholder="Texte" style="padding:5px"></textarea> <br>
              <label for='img'>Importez une image illustrative (JPEG):
                  <input type="file" id='img' name="fichier" /><br><br>
                  </label>
          </fieldset>
          <br>
         
        <input type='submit' value='Submit'>
           
      
      
      </form>
      </div>


a;
} else {
    echo "<pre> Veuillez d'abbord vous connecter.</pre>";
} ?>


<?php
$action = "";
if (isset($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "rien_a_faire";
}
if ($action == "soumettre_texte") {
    /*L'utilsateur vient de remplir le form*/

    $title = $_POST["title"];
    $summary = $_POST["summary"];
    $main = $_POST["texte"];
    $date = $_POST["date"];
    if (isset($_POST["commentaires_autorises"]) and $_POST["commentaires_autorises"] == "1") {
        $commentaires_autorises = 1;
    } else {
        $commentaires_autorises = 0;
    }
    /* On interdit de poster anonymement des textes au petits filous
    qui auraient reussis a contourner le blocage de l'affichage du formulaire 
    pour nouveau texte.*/
    if ($_SESSION["connected"]) {

        /*On verifie que la taille des differents champs rentrés
        par l'utilsateur n'excede pas les limites fixées par notre 
        base de donnees. Si c'est le cas, on affiche un message d'erreur.*/
        if(strlen($title) > 100){
            echo "<script>alert('Le titre ne doit pas excéder 100 caractères... Alea jacta est');</script>";
        } else if(strlen($summary) > 5000){
            echo "<script>alert('Le résumé ne doit pas excéder 5000 caractères... Alea jacta est');</script>";
        } else if(strlen($main) > 10000){
            echo "<script>alert('Le texte ne doit pas excéder 10000 caractères... Alea jacta est');</script>";
        } else {

            $pseudo = $_SESSION["pseudo"];
            inserer_nouveau_texte(
                $pseudo,
                $title,
                $date,
                $summary,
                $main,
                $commentaires_autorises
            );
            //Si il ya une image donnée par l'utilsateur, on l'enregistre sous la forme:
            //    images/id.jpeg

            if (
                !empty($_FILES["fichier"]["tmp_name"]) &&
                is_uploaded_file($_FILES["fichier"]["tmp_name"])
            ) {
                list($larg, $haut, $type, $attr) = getimagesize(
                    $_FILES["fichier"]["tmp_name"]
                );

                var_dump("fichier trouvé");

                $id_texte = get_last_text_id();
                if ($type == 2) {
                    //on impose un format jpeg
                    var_dump("cest un jpeg");

                    if (
                        move_uploaded_file(
                            $_FILES["fichier"]["tmp_name"],
                            "images/" . $id_texte . ".jpeg"
                        )
                    ) {
                        echo "Copie réussie";
                    } else {
                        echo "echec de la copie";
                    }
                }
            }


            /*Une fois le nouveau texte créé, on redirige l'utilisateur vers l'affichage de ce dernier.*/

            $id_texte = get_last_text_id();
            $first_id_topic = get_first_topic_id($id_texte);
            echo <<<a
            <script>
                    window.location.replace("index.php?todo=display_text&id_text=$id_texte&id_topic=$first_id_topic");
            </script>

            a;
        }
    }
}


?>