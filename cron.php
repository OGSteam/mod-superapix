<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, https://ogsteam.eu/
 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
 */
// plagiat xtense
define('IN_SPYOGAME', true);
define('IN_SUPERAPIX', true);
define('IN_XTENSE', true);

date_default_timezone_set(date_default_timezone_get());

if (preg_match('#mod#', getcwd())) {
    chdir('../../');
}

$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', preg_replace('#\/mod\/(.*)\/#', '/', $_SERVER['SCRIPT_FILENAME']));
include("common.php");
include_once("mod/superapix/common.php");

header("Access-Control-Allow-Origin: " . ($_SERVER['HTTP_ORIGIN'] ?? '*'));
header('Access-Control-Max-Age: 86400'); // cache for 1 day

$securityErrors = checkSecurity();
if ($securityErrors !== null) {
    loggeur(["ERREUR checkSecurity", $securityErrors]);
    jsonResponse(["ERROR" => "checkSecurity error"]);
    die();
}

loggeur("Lancement script");
logmemoryusage("Lancement script");

$tNameXml = constante_stepper();
$uDate = time();
$uStartTimer = microtime(true);

foreach ($tNameXml as $uId => $sNameXml) {
    global $type, $user_data;
    $type = $sNameXml;
    $user_data['user_id'] = findSpaId();
    $user_data['user_name'] = SPA_PLAYER;

    loggeur($sNameXml);
    if (is_out_of_date($sNameXml)) {
        loggeur("$sNameXml est périmé");

        if (xml_is_out_of_date($sNameXml)) {
            loggeur("XML $sNameXml est périmé ou absent");
            $url = uni_replace($sNameXml);
            loggeur("Téléchargement XML $sNameXml $url");

            if (!DistantIsFileIXml($url)) {
                jsonResponse([
                    "nook" => "Erreur XML distant $url",
                    "temps" => GetTimer($uStartTimer),
                    "CPU" => getCPUUsage(),
                    "memory" => getMemoryUsage(),
                    "State" => "Error"
                ]);
            }

            logmemoryusage("Téléchargement");
            copy($url, MOD_ROOT_XML . $sNameXml . '.xml');
            loggeur("Téléchargement $sNameXml");
            logmemoryusage("fin Téléchargement");

            $tempo = (int) find_config("tempo");
            sleep($tempo);
            logmemoryusage("fin Pause $tempo s");

            jsonResponse([
                "ok" => "Téléchargement $sNameXml",
                "temps" => GetTimer($uStartTimer),
                "CPU" => getCPUUsage(),
                "memory" => getMemoryUsage(),
                "State" => "AtWork"
            ]);
        } else {
            loggeur("XML $sNameXml est ok, Injection BDD");
            loggeur("Chargement fichier XML");
            loggeur("Lien fichier XML " . MOD_ROOT_XML . $sNameXml . ".xml");
            logmemoryusage("Chargement XML " . MOD_ROOT_XML . $sNameXml . ".xml");

            $value = f_chargement_fichier_xml(MOD_ROOT_XML . $sNameXml . ".xml");
            logmemoryusage("Fin chargement XML " . MOD_ROOT_XML . $sNameXml . ".xml");
            loggeur("Traitement fichier XML");

            switch (true) {
                case $sNameXml == "CST_PLAYERS":
                    traitement_player($value);
                    logmemoryusage("fin traitement_player");
                    break;
                case $sNameXml == "CST_ALLIANCES":
                    traitement_alliance($value);
                    logmemoryusage("fin traitement_alliance");
                    break;
                case $sNameXml == "CST_UNIVERSE":
                    traitement_universe($value);
                    logmemoryusage("fin traitement_universe");
                    break;
                case strstr($sNameXml, "CST_ALLIANCES_RANK_"):
                    traitement_alliance_rank($value, $sNameXml);
                    logmemoryusage("fin traitement_alliance_rank $sNameXml");
                    break;
                case strstr($sNameXml, "CST_PLAYERS_RANK_"):
                    traitement_player_rank($value, $sNameXml);
                    logmemoryusage("fin traitement_player_rank $sNameXml");
                    break;
                case strstr($sNameXml, "CST_SERVERDATA"):
                    traitement_serverdata($value);
                    logmemoryusage("Pas de traitement d'insertion pour $sNameXml");
                    break;
                default:
                    jsonResponse([
                        "ERROR" => "Moi pas comprendre",
                        "temps" => GetTimer($uStartTimer),
                        "State" => "Error"
                    ]);
            }

            logmemoryusage("fin script $sNameXml");
            unset($value);

            jsonResponse([
                "ok" => "Injection $sNameXml",
                "temps" => GetTimer($uStartTimer),
                "CPU" => getCPUUsage(),
                "memory" => getMemoryUsage(),
                "State" => "AtWork"
            ]);
        }
    }
}

jsonResponse([
    "ok" => "Aucune Action",
    "temps" => GetTimer($uStartTimer),
    "State" => "NoWork"
]);
?>