<link rel="stylesheet" type="text/css" href="mon_css/welcome_page.css">


<!--La page d'accueil du projet.-->



<!--Obtention des textes, pour ensuite les faire defiler a l'ecran, avec le resume et la possibilité 
d'aller les lire dans leur integralité-->
<?php
$dbh = Database::connect();
$sth = $dbh->prepare(
    "SELECT `id`,`pseudo`,`title`,`date`,`summary` FROM `textes` ORDER BY `date` DESC"
);
$sth->execute();
$tableau = [];
while ($donnees = $sth->fetch(PDO::FETCH_ASSOC)) {
    $tableau_tamp = [];
    array_push($tableau_tamp, $donnees["pseudo"]);
    array_push($tableau_tamp, $donnees["title"]);
    array_push($tableau_tamp, $donnees["summary"]);
    array_push($tableau_tamp, $donnees["id"]);
    array_push($tableau, $tableau_tamp);
}
$encoded_tab = json_encode($tableau);
?>


<!--Affichage en grand du titre du projet-->

<h1 style="margin:2cm; text-align:center; font-family:'Gill Sans Extrabold', cursive;">
  EspriX : Espace de débat de l'Ecole Polytechnique.
</h1>

<link href="mon_css/general.css" rel="stylesheet">

<!--Un petit espacement par esthetique-->

<div class="small_space"> </div>


<!--Choix de la couleur d'arriere plan + message personnalisé-->

<div id=center_me_large> 

<span><h2 id="couleur_esprit_txt" style = "font-family:'Gill Sans Extrabold', cursive;">Quelle est la couleur de l'espriX
  <?php if ($_SESSION["connected"]) {
          echo ", " . $_SESSION["pseudo"];
            if (is_admin($_SESSION["pseudo"])) {
              echo " (admin)";
            }
        } 
  ?> ?
  </h2> </span>

</div>


   <div id=center_me_small> 
        <br>  <br>
   <input type="color" value="#000000" id="colorWell">

   </div>


<!--un peu de java script pour choisir la couleur-->
<script>
  var colorWell;
  var defaultColor = "#000000";

  window.addEventListener("load", startup, false);
  colorWell = document.querySelector("#colorWell");

  function startup() {
    colorWell.value = defaultColor;
    console.log('a');
    colorWell.addEventListener("input", update, false);
    colorWell.addEventListener("change", update_html, false);
    colorWell.select();
    console.log(colorWell);
  }

  function update(event) {
    //récupère la value de l'input (la target de l'event est le champ input de couleur)
    document.body.style.background = event.target.value;
  }

  function update_html(event) {
    var couleur = colorWell.value.slice(1);
    open('index.php?change_color=' + couleur, "_self");
    console.log('a');
  }
</script>

<br><br>
<!--On fait defiler les textes-->

<div class="classname" onmouseenter=pause() onmouseleave=reprendre() style="text-align:justify">
<div>
    <p>Cher homme d'EspriX, passez votre souris ici si un titre vous interpelle...</p>
  </div>
  <div id="title">
    <p>Voici quelques textes plein d'EspriX.</p>
  </div>
  <div id="author">
    <p></p>
  </div>
  <div id="summary">
    <p></p>
  </div>
  <div id="access_article">
    <p></p>
  </div>


  <script>
    var title = document.getElementById("title");
    var author = document.getElementById("author");
    var summary = document.getElementById("summary");
    var button = document.getElementById("access_article");

    var tab = <?php echo json_encode($tableau); ?>;
    var nb_texts = tab.length;
    console.log(nb_texts);
    var count = 0;
    var interval = setInterval(newtext, 3000); // 3 seconde allouée par texte avant le prochain defilement


    function newtext() {
      var valtitle = tab[count][1];
      var valauthor = tab[count][0];
      var valsummary = tab[count][2];
      var valid = tab[count][3];

      count++;
      count = count % nb_texts;

      var access_text_html = `<button onclick="location.href='index.php?todo=display_text&id_text=` + valid + `'"><span>Aller voir ce texte</span></button>`;

      setTimeout(function() {
        title.innerHTML = '<p> <b>Titre </b> : ' + valtitle + '</p>';
      }, 100);
      setTimeout(function() {
        author.innerHTML = '<p><b>Auteur </b>: ' + valauthor + '</p>';
      }, 100);
      setTimeout(function() {
        summary.innerHTML = '<p><b>Résumé </b>: ' + valsummary + '</p>';
      }, 100);
      setTimeout(function() {
        button.innerHTML = access_text_html;
      }, 100);

    }


    //IMPORTANT : Quand la souris de l'utilisateur passe sur un texte, on mets en pause
    // le defilement
    function pause() {
      clearInterval(interval); 
    }

    // et quand la souris sort de la zone de texte, on reprends le defilement
    function reprendre() {
      interval = setInterval(newtext, 3000);
    }
  </script>
</div>