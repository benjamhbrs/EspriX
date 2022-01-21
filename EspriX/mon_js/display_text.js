$(document).ready(function() {
    // l'utilisateur vient de cliquer sur un topic,
    // il faut recharger l'espace commenataire
    $(".clickable_button").click(function() {

        var id_topic = $(this).attr('data-id_topic');
        var id_text = $(this).attr('data-id_text');

        open("https://localhost/EspriX/index.php?todo=display_text&id_text=" + id_text + "&id_topic=" + id_topic, "_self");

    });
});


// affichage des commentaires, avec la recursion (possibilité de repondre directement à l'infini)

var parts = window.location.search.substr(1).split("&");
var $_GET = {};
for (var i = 0; i < parts.length; i++) {
    var temp = parts[i].split("=");
    $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
}

const id_topic = $_GET['id_topic'];

fetch("comments.php?id_topic=" + id_topic, {
    credentials: "same-origin"
    
}).then(response => response.text()).then(data => {
    document.querySelector(".comments").innerHTML = data;
    document.querySelectorAll(".comments .write_comment_btn, .comments .reply_comment_btn").forEach(element => {
        element.onclick = event => {
            event.preventDefault();
            document.querySelectorAll(".comments .write_comment").forEach(element => element.style.display = 'none');
            document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "']").style.display = 'block';
            document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "'] input[name='name']").focus();
        };
    });

    // ecriture d'un nouveau commentaire
    document.querySelectorAll(".comments .write_comment form").forEach(element => {
        element.onsubmit = event => {
            event.preventDefault();
            fetch("comments.php?id_topic=" + id_topic, {
                method: 'POST',
                body: new FormData(element),
                credentials: "same-origin"
            }).then(response => response.text()).then(data => {
                element.parentElement.innerHTML = data;
                location.reload();
            });
        };
    });
});


//auto expand textarea
function adjust_textarea(h) {
    h.style.height = "20px";
    h.style.height = (h.scrollHeight)+"px";
}