// tentative de suppression d'un texte depuis textslist.php (et non pas mes_textes.php)
$(document).ready(function() {
    $(".button1").click(function() {

        // on recupere l'id du texte dans le bouton 'supprimer' relatif au texte,
        // ou il a été stockée
        var id_texte = $(this).attr('data-id_texte');
        
        if (confirm('Voulez-vous vraiment supprimer ce texte ?')) {
            open("https://localhost/EspriX/index.php?todo=afficher_textes&action=supprimer_texte&id_texte=" + id_texte, "_self");
        }

    });

    $(".button2").click(function() {

        // analogue
        var id_texte = $(this).attr('data-id_texte');
        var id_topic = $(this).attr('data-first_id_topic');
        
        open("https://localhost/EspriX/index.php?todo=display_text&id_text=" + id_texte + "&id_topic="+ id_topic, "_self");
    console.log('a');

    });
});


