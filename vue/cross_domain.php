<?php
if (!defined('IN_SPYOGAME'))die("Hacking attempt");

include_once ("mod/superapix/common.php");

?>




<?php

$url = null;

$tab_stepper = constante_stepper();
$pub_url = $tab_stepper[(int)$pub_step];
$must_down = is_out_of_date($pub_url);




switch ($pub_url) {
    case "CST_PLAYERS":
        $url = CST_PLAYERS;
        break;
    case "CST_PLAYER_DATA":
        $url = CST_PLAYER_DATA;
         break;
    case "CST_ALLIANCES":
        $url = CST_ALLIANCES;
         break;
    case "CST_UNIVERSE":
        $url = CST_UNIVERSE;
         break;
    case "CST_SERVERDATA":
        $url = CST_SERVERDATA;
         break;
    case "CST_PLAYERS_RANK_POINTS":
        $url = CST_PLAYERS_RANK_POINTS;
         break;
    case "CST_PLAYERS_RANK_ECO":
        $url = CST_PLAYERS_RANK_ECO;
         break;
    case "CST_PLAYERS_RANK_TECHNOLOGY":
         $url = CST_PLAYERS_RANK_TECHNOLOGY;
         break;
    case "CST_PLAYERS_RANK_MILITARY":
        $url = CST_PLAYERS_RANK_MILITARY;
         break;
    case "CST_PLAYERS_RANK_MILITARY_BUILT":
        $url = CST_PLAYERS_RANK_MILITARY_BUILT;
         break;
    case "CST_PLAYERS_RANK_MILITARY_DESTROYED":
        $url = CST_PLAYERS_RANK_MILITARY_DESTROYED;
         break;
    case "CST_PLAYERS_RANK_MILITARY_LOST":
        $url = CST_PLAYERS_RANK_MILITARY_LOST;
         break;
    case "CST_PLAYERS_RANK_MILITARY_HONNOR":
        $url = CST_PLAYERS_RANK_MILITARY_HONNOR;
         break;
    case "CST_ALLIANCES_RANK_POINTS":
        $url = CST_ALLIANCES_RANK_POINTS;
         break;
    case "CST_ALLIANCES_RANK_ECO":
        $url = CST_ALLIANCES_RANK_ECO;
         break;
    case "CST_ALLIANCES_RANK_TECHNOLOGY":
        $url = CST_ALLIANCES_RANK_TECHNOLOGY;
         break;
    case "CST_ALLIANCES_RANK_MILITARY":
        $url = CST_ALLIANCES_RANK_MILITARY;
         break;
    case "CST_ALLIANCES_RANK_MILITARY_BUILT":
        $url = CST_ALLIANCES_RANK_MILITARY_BUILT;
          break;
    case "CST_ALLIANCES_RANK_MILITARY_DESTROYED":
        $url = CST_ALLIANCES_RANK_MILITARY_DESTROYED;
         break;
    case "CST_ALLIANCES_RANK_MILITARY_LOST":
        $url = CST_ALLIANCES_RANK_MILITARY_LOST;
         break;
    case "CST_ALLIANCES_RANK_MILITARY_HONNOR":
        $url = CST_ALLIANCES_RANK_MILITARY_HONNOR;
         break;
}


//$url = "http://uni67.ogame.fr/api/players.xml";
if ($must_down)
{
    $url = uni_replace(find_config('uni'),$url);
    // on telecharge le fichier distant
    
    //file_put_contents(MOD_ROOT_XML.$pub_url.'.xml', file_get_contents($url));
        
    copy($url, MOD_ROOT_XML.$pub_url.'.xml');
}
 //  $url = uni_replace(find_config('uni'),$url);
  
  // header("Content-type: text/xml");
//  readfile($url);
  //var_dump($url);
//var_dump($pub_url);

