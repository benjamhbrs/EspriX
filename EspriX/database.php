<?php

class Database
{
    # Cette classe possède un grand nombre de fonctions qui sont appelées depuis
    # les autres fichiers .php pour interragir avec notre base de données.

    public static function connect()
    {
        $DATABASE_HOST = "localhost";
        $DATABASE_USER = "root";
        $DATABASE_PASS = "";
        $DATABASE_NAME = "modal";

        $dbh = null;
        try {
            $dbh = new PDO(
                "mysql:host=" .
                    $DATABASE_HOST .
                    ";dbname=" .
                    $DATABASE_NAME .
                    ";charset=utf8",
                $DATABASE_USER,
                $DATABASE_PASS
            );
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connexion échouée : " . $e->getMessage();
            exit(0);
        }
        return $dbh;
    }
}

function login_already_exists($pseudo)
{
    //renvoie un bool
    $dbh = Database::connect();
    $sth = $dbh->prepare("SELECT * FROM `users` WHERE `pseudo` = ?");
    $sth->execute([$pseudo]);
    $dbh = null;
    return !($sth->rowCount() == 0);
}

function get_topics($id_texte)
{
    $dbh = Database::connect();
    $sth = $dbh->prepare(
        "SELECT `id`,`title` FROM `topics` WHERE `id_texte` = ?"
    );
    $sth->execute([$id_texte]);
    $ids = [];
    $titles = [];

    while ($donnees = $sth->fetch(PDO::FETCH_ASSOC)) {
        array_push($ids, $donnees["id"]);
        array_push($titles, $donnees["title"]);
    }
    $dbh = null;
    return [$ids, $titles];
}

function get_first_topic_id($id_texte)
{
      // retourne l'id (le premier) d'un topic tu texte en paramètre
      // utile quand il faut choisir par defaut un topic afficher pour l'utilisateur
    $ids = get_topics($id_texte)[0];
    return $ids[0];
}


function are_comments_allowed($id_text)
{
    $dbh = Database::connect();
    $sth = $dbh->prepare("SELECT `comment` FROM `textes` WHERE `id` = ?");
    $result_bool = $sth->execute([$id_text]);
    $row = $sth->fetch($mode = PDO::FETCH_ASSOC);
    $dbh = null;

    // 1 signifie que les commenataires sont autorisés
    // 0 qu'ils ne le sont pas
    return $row["comment"] == "1";
}

function check_login($pseudo, $password_to_test)
{
      // verifie que le mot de passe correspond au login (et que le login existe !)
      // evidemment le mdp est haché
    $dbh = Database::connect();
    $sth = $dbh->prepare("SELECT * FROM `users` WHERE `pseudo` = ?");
    $sth->execute([$pseudo]);
    if ($sth->rowCount() == 0) {
        $dbh = null;
        return false;
    } else {
        $sth = $dbh->prepare("SELECT `mdp` FROM `users` WHERE `pseudo`= ?");
        $request = $sth->execute([$pseudo]);
        $password = $sth->fetch(PDO::FETCH_ASSOC);
        $dbh = null;
        return password_verify($password_to_test, $password["mdp"]);
    }
}

function register_new_user($pseudo, $password, $promo)
{
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $dbh = Database::connect();
    # le 2 dans les valeurs ci dessous -> pour un role de non admin (admin = 1)
    $sth = $dbh->prepare(
        "INSERT INTO `users` (`pseudo`, `mdp`, `promo`, `admin`) VALUES(?,?,?,2)"
    );
    $sth->execute([$pseudo, $hashed_password, $promo]);
    $dbh = null;
}

function register_new_topic($id_texte, $title)
{
    $dbh = Database::connect();
    $sth = $dbh->prepare(
        "INSERT INTO `topics` (`id_texte`, `title`) VALUES(?,?)"
    );
    $sth->execute([$id_texte, $title]);
    $dbh = null;
}

function inserer_nouveau_texte(
    $pseudo,
    $title,
    $date,
    $summary,
    $main,
    $comment
) {
    if ($date == "") {
        $date = date("Y-m-d");
    }


    $dbh = Database::connect();
    $sth = $dbh->prepare(
        "INSERT INTO `textes` (`pseudo`, `title`, `date`, `summary`, `main`, `comment`) VALUES(?,?,?,?,?,?)"
    );

    $sth->execute([$pseudo, $title, $date, $summary, $main, intval($comment)]);

    //finding the id of the text we just insered
    $sth = $dbh->prepare(
        "SELECT `id` FROM `textes` ORDER BY `id` DESC LIMIT 1"
    );
    $result_bool = $sth->execute();
    $row = $sth->fetch($mode = PDO::FETCH_ASSOC);
    $id_text = $row["id"];

    // IMPORTANT : a chaque nouveau texte on insere un topic par defaut : général
    $sth = $dbh->prepare(
        "INSERT INTO `topics` (`id_texte`, `title`) VALUES(?,?)"
    );
    $sth->execute([$id_text, "Général"]);
    $dbh = null;
}

function is_text_id_in_data_base($text_id)
{
    $dbh = Database::connect();
    $sth = $dbh->prepare("SELECT * FROM `textes` WHERE `id` = ?");
    $sth->execute([intval($text_id)]);
    $dbh = null;
    if ($sth->rowCount() == 0) {
        return false;
    } else {
        return true;
    }
}

// supprimer un texte, les verifs de securite doivent deja avoir ete faites
function remove($text_id)
{
    $dbh = Database::connect();
    $sth = $dbh->prepare("DELETE FROM `textes` WHERE `id` = ?");
    $sth->execute([$text_id]);
    $dbh = null;

    //supprimer l'image si elle existe
    $file_name = 'images/' . strval($text_id) . '.jpeg';
    if(file_exists($file_name)){
        unlink($file_name);
    }
}

// supprimer un compte utilisateur
function remove_user($pseudo)
{
    $dbh = Database::connect();
    $sth = $dbh->prepare("DELETE FROM `users` WHERE `pseudo` = ?");
    $sth->execute([$pseudo]);
    $dbh = null;
}



function format_date($originalDate){
    $english_months = array('01 ', '02 ', '03' , '04 ' , '05 ', '06 ', '07 ', '08 ', '09 ', '10 ', '11 ', '12 ');
    $french_months = array('Janvier ', 'Février ', 'Mars ', 'Avril ', 'Mai ', 'Juin ', 'Juillet ', 'Août ', 'Septembre ', 'Octobre ', 'Novembre ', 'Décembre ');
    $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $french_days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    $DateTime = DateTime::createFromFormat('Y-m-d', $originalDate);
    $newDate2 = $DateTime->format('m Y');
    $newDate1 = $DateTime->format('l d');
    return str_replace($english_months,$french_months,str_replace($english_days, $french_days, $newDate1)).' '.str_replace($english_months,$french_months,str_replace($english_days, $french_days, $newDate2));
   }


function get_topic_title($id_topic)
{
    $dbh = Database::connect();
    $sth = $dbh->prepare("SELECT `title` FROM `topics` WHERE `id` = ?");
    $result_bool = $sth->execute([intval($id_topic)]);
    $row = $sth->fetch($mode = PDO::FETCH_ASSOC);
    $dbh = null;
    return $row["title"];
}



function get_title_id_based_on_topic($id_topic)
{
    $dbh = Database::connect();
    $sth = $dbh->prepare("SELECT `id_texte` FROM `topics` WHERE `id` = ?");
    $result_bool = $sth->execute([intval($id_topic)]);
    $row = $sth->fetch($mode = PDO::FETCH_ASSOC);
    $dbh = null;
    return $row["id_texte"];
}

function is_admin($pseudo)
{
    $dbh = Database::connect();
    $sth = $dbh->prepare("SELECT `admin` FROM `users` WHERE `pseudo` = ?");
    $result_bool = $sth->execute([$pseudo]);
    $row = $sth->fetch($mode = PDO::FETCH_ASSOC);
    $dbh = null;
    return $row["admin"] == "1";
}

function get_main_text($text_id)
{
    $dbh = Database::connect();
    $sth = $dbh->prepare("SELECT `main` FROM `textes` WHERE `id` = ?");
    $result_bool = $sth->execute([intval($text_id)]);
    $row = $sth->fetch($mode = PDO::FETCH_ASSOC);
    $dbh = null;
    return $row["main"];
}

function get_text_author($text_id)
{
    $dbh = Database::connect();
    $sth = $dbh->prepare("SELECT `pseudo` FROM `textes` WHERE `id` = ?");
    $result_bool = $sth->execute([intval($text_id)]);
    $row = $sth->fetch($mode = PDO::FETCH_ASSOC);
    $dbh = null;
    return $row["pseudo"];
}

function get_title($text_id)
{
    $dbh = Database::connect();
    $sth = $dbh->prepare("SELECT `title` FROM `textes` WHERE `id` = ?");
    $result_bool = $sth->execute([intval($text_id)]);
    $row = $sth->fetch($mode = PDO::FETCH_ASSOC);
    $dbh = null;
    return $row["title"];
}

function get_summary($text_id)
{
    $dbh = Database::connect();
    $sth = $dbh->prepare("SELECT `summary` FROM `textes` WHERE `id` = ?");
    $result_bool = $sth->execute([intval($text_id)]);
    $row = $sth->fetch($mode = PDO::FETCH_ASSOC);
    $dbh = null;
    return $row["summary"];
}

function get_last_text_id()
{
    $dbh = Database::connect();
    $sth = $dbh->prepare(
        "SELECT `id` FROM `textes` ORDER BY `id` DESC LIMIT 1"
    );
    $sth->execute();
    $donnees = $sth->fetch(PDO::FETCH_ASSOC);
    $id_texte = $donnees["id"];
    $dbh = null;
    return $id_texte;
}