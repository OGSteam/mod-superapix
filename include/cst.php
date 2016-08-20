<?php
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");

//debug 
global $server_config;
// player
define("CST_PLAYERS", "http://s{uni}-fr.ogame.gameforge.com/api/players.xml");
define("CST_PLAYER_DATA", "http://s{uni}-fr.ogame.gameforge.com/api/playerData.xml?id={id}");
// alliance
define("CST_ALLIANCES", "http://s{uni}-fr.ogame.gameforge.com/api/alliances.xml");
// uni
define("CST_UNIVERSE", "http://s{uni}-fr.ogame.gameforge.com/api/universe.xml");
// serverdata
define("CST_SERVERDATA", "http://s{uni}-fr.ogame.gameforge.com/api/serverData.xml");
//classement player
define("CST_PLAYERS_RANK_POINTS", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=1&type=0");
define("CST_PLAYERS_RANK_ECO", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=1&type=1");
define("CST_PLAYERS_RANK_TECHNOLOGY", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=1&type=2");
define("CST_PLAYERS_RANK_MILITARY", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=1&type=3");
define("CST_PLAYERS_RANK_MILITARY_BUILT", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=1&type=5");
define("CST_PLAYERS_RANK_MILITARY_DESTROYED", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=1&type=6");
define("CST_PLAYERS_RANK_MILITARY_LOST", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=1&type=4");
define("CST_PLAYERS_RANK_MILITARY_HONNOR", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=1&type=7");

//classement alliance
define("CST_ALLIANCES_RANK_POINTS", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=2&type=0");
define("CST_ALLIANCES_RANK_ECO", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=2&type=1");
define("CST_ALLIANCES_RANK_TECHNOLOGY", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=2&type=2");
define("CST_ALLIANCES_RANK_MILITARY", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=2&type=3");
define("CST_ALLIANCES_RANK_MILITARY_BUILT", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=2&type=5");
define("CST_ALLIANCES_RANK_MILITARY_DESTROYED", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=2&type=6");
define("CST_ALLIANCES_RANK_MILITARY_LOST", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=2&type=4");
define("CST_ALLIANCES_RANK_MILITARY_HONNOR", "http://s{uni}-fr.ogame.gameforge.com/api/highscore.xml?category=2&type=7");


function uni_replace($uni, $string)
{
    $str=str_replace("https", "http", $string);
    return str_replace("{uni}", (int)$uni, $str);
}


function constante_array()
{
    $tab = array("CST_PLAYERS" => CST_PLAYERS, "CST_ALLIANCES" => CST_ALLIANCES);
    $retour = array_merge($tab, constante_array_rank_alliance(), constante_array_rank_player(), constante_array_universe());
    return $retour;
}


function constante_array_rank_alliance()
{

    $retour = array("CST_ALLIANCES_RANK_POINTS" => CST_ALLIANCES_RANK_POINTS,
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

    $retour = array("CST_PLAYERS_RANK_POINTS" => CST_PLAYERS_RANK_POINTS,
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


function constante_stepper()
{
    global $server_config;

    $retour = array();
    $tab = array("CST_PLAYERS" => CST_PLAYERS, "CST_ALLIANCES" => CST_ALLIANCES);
    $retour = array_merge($tab, constante_array_rank_alliance(), constante_array_rank_player());

    $my_retour = array();


    foreach ($retour as $key => $val) {
        $my_retour[] = $key;
    }

    //on ajout les constantes uni :)
    //    for ($i = 1; $i <= $server_config['num_of_galaxies']; $i++) {

    //     $my_retour[] = "CST_UNIVERSE_".$i ;
    //  }
    $my_retour[] = "CST_UNIVERSE";

    return $my_retour;
}

//référence :
//cf : http://board.ogame.fr/board1474-ogame-le-jeu/board641-les-cr-ations-ogamiennes/board642-logiciels-tableurs/1053082-ogame-api/