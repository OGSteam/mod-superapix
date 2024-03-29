<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, https://ogsteam.eu/
 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
 */


if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");

function lang($str)
{
    $retour = "";
    $lang = variable_lang();

    if (!isset($lang[$str])) {
        // $retour =  str_replace ( 'CST_UNIVERSE_', $lang['CST_UNIVERSE_'], $str);
        return $str;
    } else {
        $retour = $lang[$str];
        return $retour;
    }
}

function variable_lang()
{
    $lang = array();
    $lang['CST_PLAYERS'] = "Liste joueurs";
    $lang['CST_ALLIANCES'] = "Liste alliance";
    $lang['CST_ALLIANCES_RANK_POINTS'] = "Classement Alliance G&eacute;n&eacute;ral";
    $lang['CST_ALLIANCES_RANK_ECO'] = "Classement Alliance Economique";
    $lang['CST_ALLIANCES_RANK_TECHNOLOGY'] = "Classement Alliance Recherche";
    $lang['CST_ALLIANCES_RANK_MILITARY'] = "Classement Alliance Militaire";
    $lang['CST_ALLIANCES_RANK_MILITARY_BUILT'] = "Classement Alliance Mil. construit";
    $lang['CST_ALLIANCES_RANK_MILITARY_LOST'] = "Classement Alliance Mil. perdu";
    $lang['CST_ALLIANCES_RANK_MILITARY_DESTROYED'] = "Classement Alliance Mil. d&eacute;truit";
    $lang['CST_ALLIANCES_RANK_MILITARY_HONNOR'] = "Classement Alliance Mil. honneur";
    $lang['CST_PLAYERS_RANK_POINTS'] = "Classement Joueur G&eacute;n&eacute;ral";
    $lang['CST_PLAYERS_RANK_ECO'] = "Classement Joueur Economique";
    $lang['CST_PLAYERS_RANK_MILITARY'] = "Classement Joueur Militaire";
    $lang['CST_PLAYERS_RANK_TECHNOLOGY'] = "Classement Joueur Recherche";
    $lang['CST_PLAYERS_RANK_MILITARY_BUILT'] = "Classement Joueur Mil. construit";
    $lang['CST_PLAYERS_RANK_MILITARY_DESTROYED'] = "Classement Joueur Mil. perdu";
    $lang['CST_PLAYERS_RANK_MILITARY_HONNOR'] = "Classement Joueur Mil. d&eacute;truit";
    $lang['CST_PLAYERS_RANK_MILITARY_LOST'] = "Classement Joueur Mil. honneur";
    $lang['CST_UNIVERSE'] = "Galaxie ";


    return $lang;
}
