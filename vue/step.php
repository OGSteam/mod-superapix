<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, https://ogsteam.eu/
 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");

include_once("mod/superapix/common.php");


$step = (int)$pub_step;

$tab_stepper = constante_stepper();
$type = $tab_stepper[(int)$step];
$fields = array();

// on charge le xml
$value = f_chargement_fichier_xml(MOD_ROOT_XML . $type . ".xml");

switch ($type) {
    case "CST_PLAYERS":
        traitement_player($value);
        break;
    case "CST_ALLIANCES":
        traitement_alliance($value);
        break;
    case "CST_UNIVERSE":
        traitement_universe($value);
        break;
    default:
        if (strstr($type, "CST_ALLIANCES_RANK_")) {
            traitement_alliance_rank($value, $type);
        } elseif (strstr($type, "CST_PLAYERS_RANK_")) {
            traitement_player_rank($value, $type);
        }
}
