<?php


#La page que l'on fetch pour afficher les commentaires en bas à droite de la page
# de presentation d'un texte


# contrairement a la plupart des autres fichiers php, il faut ici re-importer 
# database.ph car ce fichier php est fetched, alors que les autres sont required
# au sein du code de index.php et beneficient donc de l'import préalablement réalisé
# dans index.php
include "database.php";
session_start();

function get_pseudo_connected()
{
    return $_SESSION["pseudo"];
}

try {
    $pdo = Database::connect();
} catch (PDOException $exception) {

    exit("Failed to connect to database!");
}

# se charge de déduire le temps écoulé 
function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = [
        "y" => "year",
        "m" => "month",
        "w" => "week",
        "d" => "day",
        "h" => "hour",
        "i" => "minute",
        "s" => "second",
    ];
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . " " . $v . ($diff->$k > 1 ? "s" : "");
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) {
        $string = array_slice($string, 0, 1);
    }
    return $string ? implode(", ", $string) . " ago" : "just now";
}

# affichage RECURSIF des identifiants
function show_comments($comments, $id_prec = -1)
{
    $html = "";
    if ($id_prec != -1) {
        array_multisort(array_column($comments, "date"), SORT_ASC, $comments);
    }
    foreach ($comments as $comment) {
        if ($comment["id_prec"] == $id_prec) {
            $html .=
                '
            <div class="comment">
                <div>
                <hr>
                    <h3 class="pseudo">' .
                htmlspecialchars($comment["pseudo"], ENT_QUOTES) .
                '</h3>
                    <span class="date">' .
                time_elapsed_string($comment["date"]) .
                '</span>
                </div>
                <p class="content">' .
                nl2br(htmlspecialchars($comment["content"], ENT_QUOTES)) .
                '</p>
                <a class="reply_comment_btn" href="#" data-comment-id="' .
                $comment["id"] .
                '">Reply</a>
                ' .
                show_write_comment_form($comment["id"]) .
                '
                <div class="replies">
                ' .
                show_comments($comments, $comment["id"]) .
                '
                </div>
            </div>
            ';
        }
    }
    return $html;
}

# le form permettant d'ecrire un nouveau commentaire
function show_write_comment_form($id_prec = -1)
{
    $html =
        '
    <div class="write_comment" data-comment-id="' .
        $id_prec .
        '">
        <form>
            <input name="id_prec" type="hidden" value="' .
        $id_prec .
        '">
            <textarea name="content" placeholder="Write your comment here..." required></textarea>
            <button type="submit">Submit Comment</button>
        </form>
    </div>
    ';
    return $html;
}

$id_topic = $_GET["id_topic"];


/* insertion dans la bdd d'un nouveau commenataire
IMPORTANT : On n'affiche pas l'espace commentaires si 
l'auteur du texte a précisé que les commenataires étaient 
interdits. Cela n'empeche pas un petit filou de faire une
requete adequate ou il tente de poster un commentaire.
Il faut donc, a chaque demande (recu via GET, dans l'URL),
vérifier que les commenatires sont autorisés. Dans le reste du site,
on accede a l'id du texte via GET, mais ici un pirate rusé
pourrait rentrer l'id d'un texte acceptant les commentaires
pour poster un commentaire dans un topic lié a un texte qui n'est
pas censé accepter les commentaires.
Donc cette fois ci on va chercher l'id du texte via la base de
donnée, pour etre sur et certain qu'il correpond bien au topic
ou le commentaire va etre poste.
*/
if (isset($_POST["content"])) {
    $id_texte = get_title_id_based_on_topic($_GET["id_topic"]);
    if (are_comments_allowed($id_texte)) {
        $pseudo_connected = get_pseudo_connected();
        $stmt = $pdo->prepare(
            "INSERT INTO commentaires (id_topic, id_prec, pseudo, content, date) VALUES (?,?,?,?,NOW())"
        );
        $status = $stmt->execute([
            intval($id_topic),
            intval($_POST["id_prec"]),
            $pseudo_connected,
            $_POST["content"],
        ]);

        //exit("Your comment has been submitted!");
        echo "<script> location.reload(); </script>";
    }
}



// Affichage du nombre total de commentaires dans le topic concerné
$stmt = $pdo->prepare(
    "SELECT * FROM commentaires WHERE id_topic = ? ORDER BY date ASC"
);
$stmt->execute([$id_topic]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $pdo->prepare(
    "SELECT COUNT(*) AS total_comments FROM commentaires WHERE id_topic = ?"
);
$stmt->execute([$id_topic]);
$comments_info = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="comment_header">
    <span class="total"><?= $comments_info["total_comments"] ?> comments</span>
    <h2><?php echo get_topic_title($id_topic); ?></h2>

    <a href="#" class="write_comment_btn" data-comment-id="-1">Write Comment</a>
</div>

<?= show_write_comment_form() ?>

<?= show_comments($comments) ?>