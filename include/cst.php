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

/**
 * Returns an array of constants.
 *
 * @return array
 */
function constante_array() {
    return array_merge(
        [
            "CST_PLAYERS" => CST_PLAYERS,
            "CST_ALLIANCES" => CST_ALLIANCES,
            "CST_SERVERDATA" => CST_SERVERDATA,
        ],
        constante_array_rank_alliance(),
        constante_array_rank_player(),
        constante_array_universe()
    );
}

/**
 * Returns an array of alliance rank constants.
 *
 * @return array
 */
function constante_array_rank_alliance() {
    return [
        "CST_ALLIANCES_RANK_POINTS" => CST_ALLIANCES_RANK_POINTS,
        "CST_ALLIANCES_RANK_ECO" => CST_ALLIANCES_RANK_ECO,
        "CST_ALLIANCES_RANK_TECHNOLOGY" => CST_ALLIANCES_RANK_TECHNOLOGY,
        "CST_ALLIANCES_RANK_MILITARY" => CST_ALLIANCES_RANK_MILITARY,
        "CST_ALLIANCES_RANK_MILITARY_BUILT" => CST_ALLIANCES_RANK_MILITARY_BUILT,
        "CST_ALLIANCES_RANK_MILITARY_DESTROYED" => CST_ALLIANCES_RANK_MILITARY_DESTROYED,
        "CST_ALLIANCES_RANK_MILITARY_LOST" => CST_ALLIANCES_RANK_MILITARY_LOST,
        "CST_ALLIANCES_RANK_MILITARY_HONNOR" => CST_ALLIANCES_RANK_MILITARY_HONNOR,
    ];
}

/**
 * Returns an array of player rank constants.
 *
 * @return array
 */
function constante_array_rank_player() {
    return [
        "CST_PLAYERS_RANK_POINTS" => CST_PLAYERS_RANK_POINTS,
        "CST_PLAYERS_RANK_ECO" => CST_PLAYERS_RANK_ECO,
        "CST_PLAYERS_RANK_TECHNOLOGY" => CST_PLAYERS_RANK_TECHNOLOGY,
        "CST_PLAYERS_RANK_MILITARY" => CST_PLAYERS_RANK_MILITARY,
        "CST_PLAYERS_RANK_MILITARY_BUILT" => CST_PLAYERS_RANK_MILITARY_BUILT,
        "CST_PLAYERS_RANK_MILITARY_DESTROYED" => CST_PLAYERS_RANK_MILITARY_DESTROYED,
        "CST_PLAYERS_RANK_MILITARY_LOST" => CST_PLAYERS_RANK_MILITARY_LOST,
        "CST_PLAYERS_RANK_MILITARY_HONNOR" => CST_PLAYERS_RANK_MILITARY_HONNOR,
    ];
}

/**
 * Returns an array of universe constants.
 *
 * @return array
 */
function constante_array_universe() {
    return ["CST_UNIVERSE" => CST_UNIVERSE];
}

/**
 * Returns an array of Xtense callbacks.
 *
 * @return array
 */
function constante_xtense_callbacks() {
    return ["spy", "ennemy_spy", "rc", "msg", "ally_msg", "expedition", "overview", "buildings", "research", "fleet", "defense"];
}

/**
 * Returns an array of stepper constants.
 *
 * @return array
 */
function constante_stepper() {
    return array_keys(constante_array());
}

//référence :
//cf : https://board.ogame.fr/board1474-ogame-le-jeu/board641-les-cr-ations-ogamiennes/board642-logiciels-tableurs/1053082-ogame-api/
