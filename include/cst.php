<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, https://ogsteam.eu/
 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");

//debug
global $server_config;
// player
define("CST_PLAYERS", "https://s{uni}-{pays}.ogame.gameforge.com/api/players.xml");
define("CST_PLAYER_DATA", "https://s{uni}-{pays}.ogame.gameforge.com/api/playerData.xml?id={id}");
// alliance
define("CST_ALLIANCES", "https://s{uni}-{pays}.ogame.gameforge.com/api/alliances.xml");
// uni
define("CST_UNIVERSE", "https://s{uni}-{pays}.ogame.gameforge.com/api/universe.xml");
// serverdata
define("CST_SERVERDATA", "https://s{uni}-{pays}.ogame.gameforge.com/api/serverData.xml");
//classement player
define("CST_PLAYERS_RANK_POINTS", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=1&type=0");
define("CST_PLAYERS_RANK_ECO", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=1&type=1");
define("CST_PLAYERS_RANK_TECHNOLOGY", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=1&type=2");
define("CST_PLAYERS_RANK_MILITARY", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=1&type=3");
define("CST_PLAYERS_RANK_MILITARY_BUILT", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=1&type=5");
define("CST_PLAYERS_RANK_MILITARY_DESTROYED", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=1&type=6");
define("CST_PLAYERS_RANK_MILITARY_LOST", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=1&type=4");
define("CST_PLAYERS_RANK_MILITARY_HONNOR", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=1&type=7");

//classement alliance
define("CST_ALLIANCES_RANK_POINTS", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=2&type=0");
define("CST_ALLIANCES_RANK_ECO", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=2&type=1");
define("CST_ALLIANCES_RANK_TECHNOLOGY", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=2&type=2");
define("CST_ALLIANCES_RANK_MILITARY", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=2&type=3");
define("CST_ALLIANCES_RANK_MILITARY_BUILT", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=2&type=5");
define("CST_ALLIANCES_RANK_MILITARY_DESTROYED", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=2&type=6");
define("CST_ALLIANCES_RANK_MILITARY_LOST", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=2&type=4");
define("CST_ALLIANCES_RANK_MILITARY_HONNOR", "https://s{uni}-{pays}.ogame.gameforge.com/api/highscore.xml?category=2&type=7");

function uni_replace($string)
{
    $string = constant($string);
    $tRemplacement = array("pays", "uni");
    foreach ($tRemplacement as $sRemplacement) {
        $string = str_replace("{" . $sRemplacement . "}", find_config($sRemplacement), $string);
    }
    return $string;
}

function constante_array()
{
    $tab = array("CST_PLAYERS" => CST_PLAYERS, "CST_ALLIANCES" => CST_ALLIANCES , "CST_SERVERDATA" => CST_SERVERDATA);
    $retour = array_merge($tab, constante_array_rank_alliance(), constante_array_rank_player(), constante_array_universe());
    return $retour;
}

function constante_array_rank_alliance()
{

    $retour = array(
        "CST_ALLIANCES_RANK_POINTS" => CST_ALLIANCES_RANK_POINTS,
        "CST_ALLIANCES_RANK_ECO" => CST_ALLIANCES_RANK_ECO,
        "CST_ALLIANCES_RANK_TECHNOLOGY" => CST_ALLIANCES_RANK_TECHNOLOGY,
        "CST_ALLIANCES_RANK_MILITARY" => CST_ALLIANCES_RANK_MILITARY,
        "CST_ALLIANCES_RANK_MILITARY_BUILT" => CST_ALLIANCES_RANK_MILITARY_BUILT,
        "CST_ALLIANCES_RANK_MILITARY_DESTROYED" => CST_ALLIANCES_RANK_MILITARY_DESTROYED,
        "CST_ALLIANCES_RANK_MILITARY_LOST" => CST_ALLIANCES_RANK_MILITARY_LOST,
        "CST_ALLIANCES_RANK_MILITARY_HONNOR" => CST_ALLIANCES_RANK_MILITARY_HONNOR,
    );
    return $retour;
}

function constante_array_rank_player()
{

    $retour = array(
        "CST_PLAYERS_RANK_POINTS" => CST_PLAYERS_RANK_POINTS,
        "CST_PLAYERS_RANK_ECO" => CST_PLAYERS_RANK_ECO,
        "CST_PLAYERS_RANK_TECHNOLOGY" => CST_PLAYERS_RANK_TECHNOLOGY,
        "CST_PLAYERS_RANK_MILITARY" => CST_PLAYERS_RANK_MILITARY,
        "CST_PLAYERS_RANK_MILITARY_BUILT" => CST_PLAYERS_RANK_MILITARY_BUILT,
        "CST_PLAYERS_RANK_MILITARY_DESTROYED" => CST_PLAYERS_RANK_MILITARY_DESTROYED,
        "CST_PLAYERS_RANK_MILITARY_LOST" => CST_PLAYERS_RANK_MILITARY_LOST,
        "CST_PLAYERS_RANK_MILITARY_HONNOR" => CST_PLAYERS_RANK_MILITARY_HONNOR,
    );
    return $retour;
}

function constante_array_universe()
{

    $retour = array("CST_UNIVERSE" => CST_UNIVERSE);
    return $retour;
}

function constante_xtense_callbacks()
{
    $retour = array("spy", "ennemy_spy", "rc", "msg", "ally_msg", "expedition",  "overview", "buildings", "research", "fleet", "defense");
    return $retour;
}

function constante_stepper()
{
    global $server_config;

    $retour = array();
    //$tab = array("CST_PLAYERS" => CST_PLAYERS, "CST_ALLIANCES" => CST_ALLIANCES);
    //$retour = array_merge($tab, constante_array_rank_alliance(), constante_array_rank_player());
    $retour = constante_array();
    $my_retour = array();

    foreach ($retour as $key => $val) {
        $my_retour[] = $key;
    }

    //on ajout les constantes uni :)
    //    for ($i = 1; $i <= $server_config['num_of_galaxies']; $i++) {
    //     $my_retour[] = "CST_UNIVERSE_".$i ;
    //  }
   // $my_retour[] = "CST_UNIVERSE";

    return $my_retour;
}

//référence :
//cf : https://board.ogame.fr/board1474-ogame-le-jeu/board641-les-cr-ations-ogamiennes/board642-logiciels-tableurs/1053082-ogame-api/
