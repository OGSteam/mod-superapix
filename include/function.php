<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.fr/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");

// par defaut 19, nb de colonne dans l array 
function progress_barre($value, $nom, $valueMax = 19) {
    $pct = (int) ((int) $value * 100 / (int) $valueMax);

    $retour = '<progress value="' . $pct . '" max="100" width="80%" height="20%"  background-color="red">' . $nom . ' (' . $pct . '%)</progress>';

    return $retour;
}

/**
 * formatage_timestamp_for_rank
 * 
 * change l'horaire du classement avec un horaire compatible pour un affichage dans ogspy
 * 
 * @param int $time timestamp
 * @return int
 */
function formatage_timestamp_for_rank($time) {
/// il faut garder le format ogspy ( toutes les 8 heeures ... ) )
    $temp = getdate($time);

// on format la date
    $temp['seconds'] = 0;
    $temp['minutes'] = 0;
    if ($temp['hours'] >= 0 && $temp['hours'] < 8) {

        $temp['hours'] = 0;
    }
    if ($temp['hours'] >= 8 && $temp['hours'] < 16) {
        $temp['hours'] = 8;
    }
    if ($temp['hours'] >= 16 && $temp['hours'] < 24) {
        $temp['hours'] = 16;
    }

    $time = mktime($temp['hours'], $temp['minutes'], $temp['seconds'], $temp['mon'], $temp['mday'], $temp['year']);
    return $time;
}

function is_out_of_date($type) {
    return _is_out_of_date($type, 'bdd');
}

function xml_is_out_of_date($type) {
    return _is_out_of_date($type, 'xml');
}


function _is_out_of_date($type, $origin) {


    // cf : http://board.fr.ogame.gameforge.com/board1474-ogame-le-jeu/board641-les-cr-ations-ogamiennes/board642-logiciels-tableurs/1053082-ogame-api/
    // dans les limites d'ogspy
    $datadate = array(
        "CST_PLAYERS" => "24",
        "CST_ALLIANCES" => "24",
        "CST_PLAYERS_RANK_POINTS" => "8", // pour tout ce qui est classement joueur
        "CST_PLAYERS_RANK_ECO" => "8", // maj toutes les heures, mais comme decoupage par 8 heures, autzant laisser par jour
        "CST_PLAYERS_RANK_TECHNOLOGY" => "8",
        "CST_PLAYERS_RANK_MILITARY" => "8",
        "CST_PLAYERS_RANK_MILITARY_BUILT" => "8",
        "CST_PLAYERS_RANK_MILITARY_DESTROYED" => "8",
        "CST_PLAYERS_RANK_MILITARY_LOST" => "8",
        "CST_PLAYERS_RANK_MILITARY_HONNOR" => "8",
        "CST_ALLIANCES_RANK_POINTS" => "8",
        "CST_ALLIANCES_RANK_ECO" => "8",
        "CST_ALLIANCES_RANK_TECHNOLOGY" => "8",
        "CST_ALLIANCES_RANK_MILITARY" => "8",
        "CST_ALLIANCES_RANK_MILITARY_BUILT" => "8",
        "CST_ALLIANCES_RANK_MILITARY_DESTROYED" => "8",
        "CST_ALLIANCES_RANK_MILITARY_LOST" => "8",
        "CST_ALLIANCES_RANK_MILITARY_HONNOR" => "8",
        "CST_UNIVERSE" => "168" // modif suite a maj api ogame a tester ... ( pas d editeur sur pc pour le moment )
    );

    $retour = true; // retour par defaut

    $now = time();
    $last_update = 0;

//!\\ swith bdd <=> xml pour utiliserr meme fonction 
    if ($origin == "bdd") {
        $last_update = (int) find_config("last_" . $type);
    } else {
// ici on veut xml
        $sPathXml = MOD_ROOT_XML . $type . ".xml";
        loggeur($sPathXml);
        if (file_exists($sPathXml)) {
            $last_update = filemtime($sPathXml);
            loggeur(filemtime($sPathXml));
        }
    }
//!\\ fin swith bdd <=> xml pour utiliserr meme fonction 

    $datadate_maj = 0;
    if (isset($datadate[$type])) {
        $datadate_maj = (int) $datadate[$type];
    } else {

        $datadate_maj = 1; // modif suite a maj api ogame a tester ... ( pas d editeur sur pc pour le moment )
    }

    loggeur("est périmé : (".$now." - ".$last_update.") > (".$datadate_maj." * 60 * 60)" );
    //loggeur("est périmé : (".$now - $last_update.") > (".$datadate_maj * 60 * 60 .")" );
    if (($now - $last_update) > ($datadate_maj * 60 * 60)) { //($datadate_maj (en heure )) * nb de minutes * nb de secondes
        loggeur("Est périmé ".$origin);
        $retour = true;
    } else {
        loggeur("Est A jour ".$origin);
        $retour = false;
    }

    return $retour;
}

function my_encodage($str) {
// return utf8_decode($str);
    return $str;
}

function stream_copy($src, $dest) {
    $fsrc = fopen($src, 'r');
    $fdest = fopen($dest, 'w+');
    $len = stream_copy_to_stream($fsrc, $fdest);
    fclose($fsrc);
    fclose($fdest);
    return $len;
}

function f_chargement_fichier_xml($s_fichier_xml) {
// On test voir si les fichiers que l'on va traiter existe

    if (file_exists($s_fichier_xml)) {
        $o_xml = simplexml_load_file($s_fichier_xml);

        return $o_xml;
    } else {
        exit('Echec lors de l\'ouverture du fichier ' . $s_fichier_xml . '.');
    }
}

function loggeur($option) {
    global $pub_action;
    if (constant("DEBUG") == "1") {
        if (!isset($pub_action)) {
            $pub_action = "superapix"; // fix si appel exterieur 'IN_SPYOGAME'
        }
        if (is_array($option)) {
            $option = array_reverse($option);
            $sep = "=>";
            log_("mod", PHP_EOL . $sep . implode(PHP_EOL . $sep, $option));
            log_("mod", "tableau de variable : " . PHP_EOL);
        } else {
            log_("mod", $option);
        }
    }
}

function logmemoryusage($option)
{
    global $pub_action;
    // pk pas mettre option pour voir usage memoire
    if (constant("DEBUG") == "1") {
        if (!isset($pub_action)) {
            $pub_action = "superapix"; // fix si appel exterieur 'IN_SPYOGAME'
        }
        $usage = unitformat(memory_get_usage());
        $alloue= unitformat(memory_get_peak_usage());

        log_("mod", "Usage memoire : ".$usage." / ".$alloue." ".cpuusage()." [".$option."]");
    }
}

// returne Moyenne d'usage CPU sur la derniere minute
function cpuusage()
{
    if (function_exists (  "sys_getloadavg" ))
    {
        $load = sys_getloadavg();
        if (isset($load[0]))
        {
            return "[ CPU :".round($load[0], 2)." %]"  ;
        }
    }
    return "";
}


function unitformat($value)
{
    $value= (int)$value;
    if ($value === 0)
    {return '0b';}
    $unit=array('b','kb','mb','gb','tb','pb');
    $value = round($value/pow(1024,($i=floor(log($value,1024)))),2).' '.$unit[$i];
    return $value;
}


function jsonResponse($data) {
    $data = json_encode($data);
    loggeur("retour " . $data);
    header('Content-Type: application/json');
    echo $data;
    die();
}

function checkSecurity() {
    $error = FALSE;
    $tError = array();

// si pas actif pas acces au page on die de suite on attend pas les autres checks ..
    if (spaActive() == NULL) {
        $str = "Tentative d'accés via superapix IP : " . get_client_ip();
        jsonResponse(array("ERROR" => $str));
        die(); // deja fait dans jsonresponse
    }

// xml droit en ecriture
    if (!is_writable(MOD_ROOT_XML) || !file_exists(MOD_ROOT_XML)) {
        $error = TRUE;
        $str = "Dossier " . MOD_ROOT_XML . " nom accessible ";
        $tError[] = $str;
        loggeur($str);
    }

//verification présence joueur spa
    if (findSpaId() == NULL) {
        $error = TRUE;
        $str = "Aucun compte de service SuperApix";
        $tError[] = $str;
        loggeur($str);
    }

// verificatiopn des differentes constantes
    $tConfigName = array("uni", "requete_max", "pays");
    foreach ($tConfigName as $sConfigName) {
        $value = strval(find_config($sConfigName));
        if (($value == "" || $value == "0")) {
            $error = TRUE;
            $str = "Erreur Config " . $sConfigName . " => " . strval($value);
            $tError[] = $str;
            loggeur($str);
        }
    }

// config php
    if (ini_get('allow_url_fopen') == 0) {
        $error = TRUE;
        $str = "Erreur Config PHP : allow_url_fopen " . ini_get('allow_url_fopen');
        $tError[] = $str;
        loggeur($str);
    }


    if ($error) {
        return $tError;
    }
    return NULL;
}

// Function to get the client IP address
//http://stackoverflow.com/questions/15699101/get-the-client-ip-address-using-php
function get_client_ip() {
    global $_SERVER;
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

/**
 * GetTimer
 * 
 * Retourne la difference de temps
 * 
 * @param type float
 * @return float temps total (microtime)
 */
function GetTimer($utime) {
    $uEndTimer = microtime(1);
    $uTotal = $uEndTimer - $utime;

    return abs($uTotal);
}

function traitement_universe($value) {

    global $db, $user_data, $server_config, $pub_timestamp, $type;
    $table = TABLE_UNIVERS;
    $sender_id = $user_data['user_id'];

    $timestamp = find_timestamp($value);


    $query = array();

    $fields = "g, s, r, id_player  , datadate , name_planete ,name_moon , moon  , sender_id   ";

    foreach ($value->planet as $ta_planete_en_cours) {
        $t_coordonnee = explode(':', $ta_planete_en_cours[0]['coords']); // récuperation coord en cours
        $g = $t_coordonnee[0];
        $s = $t_coordonnee[1];
        $r = $t_coordonnee[2];
        $id_player = (int) strval($ta_planete_en_cours[0]['player']);
        $datadate = $timestamp;
        $name_planete = strval($ta_planete_en_cours[0]['name']);
        $name_moon = empty($ta_planete_en_cours[0]->moon['name']) ? '' : strval($ta_planete_en_cours[0]->moon['name']);
        $moon = empty($name_moon) ? '0' : '1';
//$sender_id = 



        $query[] = "( " . $g . ", " . $s . " , " . $r . "  , " . $id_player . " , " . $datadate . " , '" . my_encodage($name_planete) . "' , '" . $name_moon . "' , '" . $moon . "'  , " . $sender_id . " ) ";
    }

//$db->sql_query('REPLACE INTO '.$table.' ('.$fields.') VALUES '.implode(',', $query));
    mass_replace_into($table, $fields, $query);


    // on a plus qu a updater ...


    $sql = "UPDATE " . TABLE_UNIVERSE . " as U INNER JOIN " . TABLE_UNIVERS . " as T ";
    $sql .= " ON ";
    $sql .= "( U.galaxy = T.g AND U.row = T.r  AND U.system = T.s )   ";
    $sql .= "INNER JOIN " . TABLE_PLAYERS . " as P ";
    $sql .= " ON ";
    $sql .= "( T.id_player = P.id_player  )   ";
    $sql .= "INNER JOIN " . TABLE_ALLIANCES . " as A ";
    $sql .= " ON ";
    $sql .= "( A.id_alliance = P.id_ally  )   ";
    $sql .= " SET ";
    $sql .= "  U.player_id   = T.id_player  ,  U.ally_id   = P.id_ally   , U.moon = T.moon , U.name = T.name_planete  , U.ally = A.tag , U.player = P.name_player , U.status = P.status   , U.last_update = T.datadate   , U.last_update_user_id = T.sender_id  ";
    $sql .= " WHERE  ";
    $sql .= "  U.last_update <= T.datadate "; // <= pour permettre d ecraser la derniere importation si plantage de la derniere


    $db->sql_query($sql);


    prepare_table_universe($timestamp);


    insert_config("last_" . $type, $timestamp);
    change_date($type, $timestamp);
}

function traitement_player($value) {
    global $db, $type;
    $timestamp = find_timestamp($value);

     #3 etapes

    //step 1
    //récuperation des data de l'api'
    $fields = "id_player, name_player, status, id_ally, datadate ";
    $querys = array();
    $querys[] = "( 0, '' , '', 0 , ".$timestamp.") "; // player vide


    foreach ($value->player as $ta_xml_player) {
        $querys[] = "( " . (int) $ta_xml_player[0]['id'] . ", '" . my_encodage(strval($ta_xml_player[0]['name'])) .
                "' , '" . strval($ta_xml_player[0]['status']) . "', " . (int) strval($ta_xml_player[0]['alliance']) .
                " , ".$timestamp." ) ";
    }

    $db->sql_query('REPLACE INTO ' . TABLE_PLAYERS . ' (' . $fields . ') VALUES ' .
            implode(',', $querys));

    //step 2
    // copie des data plus recentes (xtense par exemple)
    $SQL = " REPLACE INTO";
    $SQL .= "   ".TABLE_PLAYERS."  ";
    $SQL .= "   ( ";
    $SQL .= "       `id_player`, `name_player`, `status`, `id_ally`, `datadate` ";
    $SQL .= "   ) ";
    $SQL .= "SELECT ";
    $SQL .= "       `player_id`," ;
    $SQL .= "       `player`,";
    $SQL .= "       `status`,";
    $SQL .= "       `ally_id`,";
    $SQL .= "       `datadate`";
    $SQL .= " FROM ";
    $SQL .= "       ".TABLE_GAME_PLAYER." ";
    $SQL .= "WHERE ";
    $SQL .= "       `datadate` > $timestamp";
    $SQL .= ";";
    $db->sql_query($SQL);



    //step 3
    // On transfert le tout pour avoir la base la plus a jour
    $SQL = " REPLACE INTO";
    $SQL .= "   ".TABLE_GAME_PLAYER."";
    $SQL .= "   ( ";
    $SQL .= "       `player_id`, `player`, `status`, `ally_id`, `datadate`";
    $SQL .= "   ) ";
    $SQL .= " SELECT ";
    $SQL .= "        `id_player`,";
    $SQL .= "        `name_player`, ";
    $SQL .= "        `status`, ";
    $SQL .= "        `id_ally`, ";
    $SQL .= "        `datadate` ";
    $SQL .= " FROM ";
    $SQL .= "       ".TABLE_PLAYERS."";
    $SQL .= ";";
    $db->sql_query($SQL);



    // a voir si possible de regrouper  requete en une seule ( replace into select avec des jointures semble impossible ....:s)

    insert_config("last_" . $type, $timestamp);
    change_date($type, $timestamp);
}

function traitement_alliance($value) {
    global $db, $type;
    $timestamp = find_timestamp($value);

    $fields = "id_alliance, tag, nb , name_ally , datadate ";
    $querys = array();
    $querys[] = "( 0 , '' , 0 ,  '' , ".$timestamp.") "; // ally vide



    foreach ($value->alliance as $ta_xml_alliance) {

        $count = count($ta_xml_alliance->children()); // PHP < 5.3

        $temp_query = "( " . intval($ta_xml_alliance[0]['id']) . ", '" . my_encodage(strval($ta_xml_alliance[0]['tag'])) . "' , '" . $count . "',  '" . my_encodage(strval($ta_xml_alliance[0]['name'])) . "' ,'" . $timestamp . "' ) ";
        $querys[] = $temp_query;
    }

    $db->sql_query('REPLACE INTO ' . TABLE_ALLIANCES . ' (' . $fields . ') VALUES ' .
            implode(',', $querys));


    //step 2
    // copie des data plus recentes (xtense par exemple)
    $SQL = " REPLACE INTO";
    $SQL .= "   ".TABLE_ALLIANCES."  ";
    $SQL .= "   ( ";
    $SQL .= "       `id_alliance`, `tag`, `nb`, `name_ally`, `datadate` ";
    $SQL .= "   ) ";
    $SQL .= "SELECT ";
    $SQL .= "       `ally_id`," ;
    $SQL .= "       `tag`,";
    $SQL .= "       `number_member`,";
    $SQL .= "       `ally`,";
    $SQL .= "       `datadate` " ;
    $SQL .= " FROM  ";
    $SQL .= "       ".TABLE_GAME_ALLY." ";
    $SQL .= "WHERE ";
    $SQL .= "       `datadate` > $timestamp";
    $SQL .= ";";
    $db->sql_query($SQL);



    //step 3
    // On transfert le tout pour avoir la base la plus a jour
    $SQL = " REPLACE INTO";
    $SQL .= "   ".TABLE_GAME_ALLY."";
    $SQL .= "   ( ";
    $SQL .= "       `ally_id`, `tag`, `number_member`, `ally`, `datadate`";
    $SQL .= "   ) ";
    $SQL .= " SELECT ";
    $SQL .= "        `id_alliance`,";
    $SQL .= "        `tag`, ";
    $SQL .= "        `nb`, ";
    $SQL .= "        `name_ally`, ";
    $SQL .= "        `datadate` ";
    $SQL .= " FROM ";
    $SQL .= "       ".TABLE_ALLIANCES."";
    $SQL .= ";";
    $db->sql_query($SQL);






    insert_config("last_" . $type, $timestamp);
    change_date($type, $timestamp);
}

function traitement_alliance_rank($value, $type) {
    global $db, $type, $user_data;
    $fields = "datadate, rank, id_alliance, points , sender_id ";
    $querys = array();
    $attribut = array();

// on recupere les attribut :


    $timestamp = formatage_timestamp_for_rank(find_timestamp($value));



    foreach ($value->alliance as $ta_xml_rank) {

        $datadate = $timestamp;
        $rank = (int) strval($ta_xml_rank[0]['position']);
        $id_alliance = (int) intval($ta_xml_rank[0]['id']);
        $points = (int) intval($ta_xml_rank[0]['score']);
        ;

        $temp_query = "( " . $timestamp . ", " . $rank . ", '" . $id_alliance . "' , '" . $points . "' , " . $user_data['user_id'] . " ) ";
        $querys[] = $temp_query;
    }

    $db->sql_query('REPLACE INTO ' . TABLE_RANK_ALLIANCES . ' (' . $fields . ') VALUES ' .
            implode(',', $querys));



// on fait la jointure qui va bien pour injecter le bon classement

    $sql = "REPLACE INTO " . find_table_rank_alliance($type) . "  ";
    $sql .= " ( `datadate`, `rank`, `ally`, `ally_id`, `number_member`, `points` , `sender_id`) ";
    $sql .= " SELECT sra.datadate, sra.rank, sa.tag, sra.id_alliance , sa.nb , sra.points , sra.sender_id ";
    $sql .= " FROM  " . TABLE_ALLIANCES . " as sa ";
    $sql .= "INNER JOIN " . TABLE_RANK_ALLIANCES . " as sra ";
    $sql .= " on sa.id_alliance	= sra.id_alliance ; ";

    $db->sql_query($sql);


// on efface la table rank
    $sql = "DELETE FROM " . TABLE_RANK_ALLIANCES . " ;";
    $db->sql_query($sql);

    insert_config("last_" . $type, $timestamp);
    change_date($type, $timestamp);
}

function find_table_rank_alliance($type) {
    $tab = array();
    $tab = array(
        "CST_ALLIANCES_RANK_POINTS" => TABLE_RANK_ALLY_POINTS,
        "CST_ALLIANCES_RANK_ECO" => TABLE_RANK_ALLY_ECO,
        "CST_ALLIANCES_RANK_TECHNOLOGY" => TABLE_RANK_ALLY_TECHNOLOGY,
        "CST_ALLIANCES_RANK_MILITARY" => TABLE_RANK_ALLY_MILITARY,
        "CST_ALLIANCES_RANK_MILITARY_BUILT" => TABLE_RANK_ALLY_MILITARY_BUILT,
        "CST_ALLIANCES_RANK_MILITARY_DESTROYED" => TABLE_RANK_ALLY_MILITARY_DESTRUCT,
        "CST_ALLIANCES_RANK_MILITARY_LOST" => TABLE_RANK_ALLY_MILITARY_LOOSE,
        "CST_ALLIANCES_RANK_MILITARY_HONNOR" => TABLE_RANK_ALLY_HONOR,
    );
    $retour = $tab[$type];
    return $retour;
}

function traitement_player_rank($value, $type) {
    global $db, $type, $user_data;
    $fields = "datadate, rank, id, points , nb_spacecraft , sender_id ";
    $querys = array();
    $attribut = array();

// on recupere les attribut :


    $timestamp = formatage_timestamp_for_rank(find_timestamp($value));



    foreach ($value->player as $ta_xml_rank) {

        $datadate = $timestamp;
        $rank = strval($ta_xml_rank[0]['position']);
        $id = intval($ta_xml_rank[0]['id']);
        $points = intval($ta_xml_rank[0]['score']);
        $ships = (int) ($ta_xml_rank[0]['ships']);
        $sender_id = (int) $user_data['user_id'];

        $temp_query = $temp_query = "( " . $datadate . ", " . $rank . ", " . $id . " , " . $points . " , " . (int) $ships . " , " . $user_data['user_id'] . " ) ";
        $querys[] = $temp_query;
    }

    $db->sql_query('REPLACE INTO ' . TABLE_RANK_PLAYERS . ' (' . $fields . ') VALUES ' .
            implode(',', $querys));



    $table = find_table_rank_player($type);
// on fait la jointure qui va bien pour injecter le bon classement
    $sql = "REPLACE INTO " . $table . "  ";
    $sql .= ($type != "CST_PLAYERS_RANK_MILITARY" ) ? " ( `datadate`, `rank`, `player`, `player_id`, `ally`, `ally_id`, `points` , `sender_id`) " : " ( `datadate`, `rank`, `player`, `player_id`, `ally`, `ally_id` , `points` , `nb_spacecraft` ,`sender_id`) ";
    $sql .= ($type != "CST_PLAYERS_RANK_MILITARY" ) ? " SELECT srp.datadate, srp.rank,sp.name_player  , sp.id_player  ,sa.tag,  sp.id_ally,  srp.points , srp.sender_id " : " SELECT srp.datadate, srp.rank,sp.name_player , sp.id_player   ,sa.tag,sp.id_ally, srp.points , srp.nb_spacecraft,srp.sender_id ";
    $sql .= " FROM  " . TABLE_PLAYERS . " as sp ";
    $sql .= "INNER JOIN " . TABLE_RANK_PLAYERS . " as srp ";
    $sql .= " on sp.id_player	= srp.id ";
    $sql .= "INNER JOIN " . TABLE_ALLIANCES . " as sa ";
    $sql .= " on sa.id_alliance	= sp.id_ally ; ";



    $db->sql_query($sql);


// on efface la table rank
    $sql = "DELETE FROM " . TABLE_RANK_PLAYERS . " ;";
    $db->sql_query($sql);

    insert_config("last_" . $type, $timestamp);
    change_date($type, $timestamp);
}

function find_table_rank_player($type) {
    $tab = array();
    $tab = array(
        "CST_PLAYERS_RANK_POINTS" => TABLE_RANK_PLAYER_POINTS,
        "CST_PLAYERS_RANK_ECO" => TABLE_RANK_PLAYER_ECO,
        "CST_PLAYERS_RANK_TECHNOLOGY" => TABLE_RANK_PLAYER_TECHNOLOGY,
        "CST_PLAYERS_RANK_MILITARY" => TABLE_RANK_PLAYER_MILITARY,
        "CST_PLAYERS_RANK_MILITARY_BUILT" => TABLE_RANK_PLAYER_MILITARY_BUILT,
        "CST_PLAYERS_RANK_MILITARY_DESTROYED" => TABLE_RANK_PLAYER_MILITARY_DESTRUCT,
        "CST_PLAYERS_RANK_MILITARY_LOST" => TABLE_RANK_PLAYER_MILITARY_LOOSE,
        "CST_PLAYERS_RANK_MILITARY_HONNOR" => TABLE_RANK_PLAYER_HONOR,
    );
    $retour = $tab[$type];
    return $retour;
}

function find_timestamp($value) {
    foreach ($value->attributes() as $a => $b) {
        $attribut[$a] = strval($b);
    }

    $timestamp = ((int) $attribut["timestamp"]);
    return $timestamp;
}

/// permet de mettre à niveau toutes les tables qui n'apparaissent pas dans le universe.xml
function prepare_table_universe($datadate) {
    global $db, $user_data, $server_config;
    $table = TABLE_UNIVERSE;
    $spaId = findSpaId();



    $sql = "";
    $sql .= " UPDATE  " . $table . "  ";
    $sql .= " set ";
    $sql .= " ally = '' , ";
    $sql .= " player = '' , ";
    $sql .= " status = '' , ";
    $sql .= " gate = '0' , ";
    $sql .= " phalanx = '0' , ";
    $sql .= " last_update = '" . $datadate . "' ,";
    $sql .= " name =  '', ";
    $sql .= " moon = '0', ";
    $sql .= " last_update_user_id = '".$spaId."' ";

    $sql .= " where last_update < '" . (int) $datadate . "' ";


    $db->sql_query($sql);
}

function findSpaId() {
    global $db;
    $sql = "select user_id from " . TABLE_USER . " WHERE user_name = '" . constant("SPA_PLAYER") . "';";
    $result = $db->sql_query($sql);
    while ($row = $db->sql_fetch_assoc($result)) {
        return $row["user_id"];
    }
    return NULL;
}

// le chemin distant renvoit il a un xml ?????
function DistantIsFileIXml($url) {
    if ($stream = fopen($url, 'r')) {
        // 5 premier octet => verif bidons
        $sStream = stream_get_contents($stream, 5);
        if ($sStream == "<?xml") {
            loggeur("check fichier XML ok " . $url);
            return TRUE;
        }
        loggeur("retour  " . $sStream);
        loggeur("check fichier XML No Ok " . $url);
        fclose($stream);
    }
    return FALSE;
}

//changen la date du fichier xml pour correspondre à la date du timestamp en base ( evite décalage ... )
function change_date($path, $time) {
    $path = MOD_ROOT_XML . $path . ".xml";
    touch($path, $time);
}

function fileInfoExist($sUri) {
    
     $sUri = str_replace("cron.php", "info.txt", $sUri); // récupération url
     $response = @get_headers($sUri, 1);
     if (isset($response[0]) &&  trim($response[0]) == "HTTP/1.1 200 OK" )
     {
         return true;
     }
             
      return false;
}
