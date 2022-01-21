// En fonction de l'etat de connexion, on ne présente pas les mêmes boutons 
// (login, sign out, sign up) dans la bare de navigation superieure

$(document).ready(function() {
        hide_show();
    });

function hide_show() {
    if (connected){
        $("#disconnect_button" ).show();
        $("#sign_up_component" ).hide(0, function() {});
        $("#sign_in_component" ).hide(0, function() {});
        
    }else{
        $("#disconnect_button" ).hide(0, function() {});
        $("#sign_up_component" ).show();
        $("#sign_in_component" ).show();

    }
}
  

