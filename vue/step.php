<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.fr/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");

include_once ("mod/superapix/common.php");


$step = (int)$pub_step;

$tab_stepper = constante_stepper();
$type = $tab_stepper[(int)$step];
$fields = array();

// on charge le xml
$value = f_chargement_fichier_xml(MOD_ROOT_XML . $type . ".xml");
//var_dump($value);

if ($type == "CST_PLAYERS")
{
    traitement_player($value);
}

if ($type == "CST_ALLIANCES")
{
    traitement_alliance($value);
}

if ($type == "CST_UNIVERSE")
{
    traitement_universe($value);
}

if ( strstr($type, "CST_ALLIANCES_RANK_"))
{
    traitement_alliance_rank($value, $type);
}

if ( strstr($type, "CST_PLAYERS_RANK_"))
{
    traitement_player_rank($value, $type);
}

