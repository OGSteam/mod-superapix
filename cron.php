<?php

// plagiat xtense
define('IN_SPYOGAME', true);
define('IN_SUPERAPIX', true);

date_default_timezone_set(date_default_timezone_get());

if (preg_match('#mod#', getcwd()))
    chdir('../../');
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', preg_replace('#\/mod\/(.*)\/#', '/', $_SERVER['SCRIPT_FILENAME']));
include("common.php");
list($root, $active) = $db->sql_fetch_row($db->sql_query("SELECT root, active FROM " . TABLE_MOD . " WHERE action = 'superapix'"));

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
} else {
    header("Access-Control-Allow-Origin: *");
}
//fin plagiat xtense
include_once("mod/superapix/common.php");
loggeur("Lancement script");

// verification ecriture
if (!is_writable(MOD_ROOT_XML) || !file_exists(MOD_ROOT_XML)) {
    loggeur("Dossier " . MOD_ROOT_XML . " nom accessible ");
    die();
}

// differents array necessaires
$tNameXml = constante_stepper(); // tab principal
// variable
$uDate = time();
$uStartTimer = microtime();

// on va parcourir le tableau de constante name
// si c'est out of date on regarde le xml pour savoir si necessaire de modifier également
foreach ($tNameXml as $uId => $sNameXml) {
    loggeur($sNameXml);
    if (is_out_of_date($sNameXml)) {
        loggeur($sNameXml . " est périmé ");
        // verification xml 
        if (xml_is_out_of_date($sNameXml)) {
            loggeur("XML " . $sNameXml . " est périmé ou absent");
            $url = uni_replace(find_config('uni'), constant($sNameXml));
            loggeur("Telecharement XML " . $sNameXml . " " . $url);
            copy($url, MOD_ROOT_XML . $sNameXml . '.xml');
            loggeur("Telechargement " . $sNameXml);
            jsonResponse(array("ok" => "Telechargement " . $sNameXml, "temps" => GetTimer($uStartTimer)));
        } else {
            // si on arrive la c que le xml est ok mais pas encore la bdd
            loggeur("xml " . $sNameXml . " est ok, Injection BDD");

            // on charge le xml
            
            loggeur("Chargement fichier XML");
           loggeur("link  fichier XML" .MOD_ROOT_XML . $sNameXml . ".xml");
            $value = f_chargement_fichier_xml(MOD_ROOT_XML . $sNameXml . ".xml");
            loggeur("Traitement fichier XML");

            // fix pour utilisation web(js) <=>  cron
            // cf traitement_xxx
            global $type, $user_data;
            $type = $sNameXml;
            $user_data['user_id'] = 0;
            // fin fix
            // ROUTINE DE CONTROLE
            if ($sNameXml == "CST_PLAYERS") {
                traitement_player($value);
            } else if ($sNameXml == "CST_ALLIANCES") {
                traitement_alliance($value);
            } else if ($sNameXml == "CST_UNIVERSE") {
                traitement_universe($value);
            } else if (strstr($sNameXml, "CST_ALLIANCES_RANK_")) {
                traitement_alliance_rank($value, $sNameXml);
            } else if (strstr($sNameXml, "CST_PLAYERS_RANK_")) {
                traitement_player_rank($value, $sNameXml);
            } else {
                // si pas pris en charge
                jsonResponse(array("ERROR" => "Moi pas comprendre", "temps" => GetTimer($uStartTimer)));
            }
            jsonResponse(array("ok" => "Injection " . $sNameXml, "temps" => GetTimer($uStartTimer)));
        }
    }
}


jsonResponse(array("ok" => "Aucune Action", "temps" => GetTimer($uStartTimer)));
