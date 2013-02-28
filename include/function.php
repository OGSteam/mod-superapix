<?php 
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//cf xtense et reinette
function formatage_timestamp_for_rank($time)
{
    /// il faut garder le format ogspy ( toutes les 8 heeures ... ) )
   $temp= getdate($time);
   
   // on format la date
   $temp['seconds'] = 0;
   $temp['minutes'] = 0;
   if ($temp['hours'] >= 0 && $temp['hours'] < 8 ){ $temp['hours'] = 0; } 
   if ($temp['hours'] >= 8 && $temp['hours'] < 16 ){ $temp['hours'] = 8; } 
   if ($temp['hours'] >= 16 && $temp['hours'] < 24 ){ $temp['hours'] = 16; } 
   $temp['hours'] = 0;
    
   $time = mktime($temp['hours'], $temp['minutes'], $temp['seconds'], $temp['mon'], $temp['mday'],$temp['year'] ); 
   return $time;
}


function is_out_of_date($type)
{
    $datadate = array(
    "CST_PLAYERS" => "1",
    "CST_ALLIANCES" => "1",
    "CST_ALLIANCES_RANK_POINTS" =>"1",
    "CST_ALLIANCES_RANK_ECO" => "1",
   "CST_ALLIANCES_RANK_TECHNOLOGY" => "1",
   "CST_ALLIANCES_RANK_MILITARY" => "1",
   "CST_ALLIANCES_RANK_MILITARY_BUILT" => "1",
   "CST_ALLIANCES_RANK_MILITARY_DESTROYED" => "1",
   "CST_ALLIANCES_RANK_MILITARY_LOST" => "1",
   "CST_ALLIANCES_RANK_MILITARY_HONNOR" => "1",
   "CST_PLAYERS_RANK_POINTS" => "1",                                // pour tout ce qui est classement joueur
   "CST_PLAYERS_RANK_ECO" => "1",                                  // maj toutes les heures, mais comme decoupage par 8 heures, autzant laisser par jour
   "CST_PLAYERS_RANK_TECHNOLOGY" => "1",
   "CST_PLAYERS_RANK_MILITARY" => "1",
   "CST_PLAYERS_RANK_MILITARY_BUILT" => "1",
   "CST_PLAYERS_RANK_MILITARY_DESTROYED" =>"1",
   "CST_PLAYERS_RANK_MILITARY_LOST" => "1",
   "CST_PLAYERS_RANK_MILITARY_HONNOR" => "1",
   "CST_UNIVERSE" => "7"
   
    );
    
    
    $retour = true ; 
    
    $now = time();
    $last_update = (int)find_config("last_".$type);
    
    $datadate_maj = 0;
    if (isset($datadate[$type])){ $datadate_maj =  (int)$datadate[$type] ;}
    else
    {
        // univers dont 7 jours
        $datadate_maj = 7;
        
    }
    
    
    
    
    if ( ($now - $last_update) >  ($datadate_maj * 24 * 60 * 60) ) 
    {$retour = true ;  }
    else
    {$retour = false ;}
    
    
    
    
    
    
    
 return $retour;
}


function my_encodage($str)
{
    return utf8_decode($str);
}