<?php
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
global $db , $user_data ,  $server_config;

$timestamp = (int)$pub_timestamp;
$table = TABLE_UNIVERS;
$sender_id = $user_data['user_id'] ;

$total = 0;
$query = array();
$pre_query = array();

$fields =  "g, s, r, id_player , datadate , name_planete ,name_moon , moon  , sender_id   " ;

$galaxie = 0 ;
 
   

foreach($pub_value as $value)
{
    
    $g = (int)$value["g"] ;
    $galaxie = $g ;
    $s = (int)$value["s"] ;
    $r = (int)$value["r"] ;
    $id_player = (int)$value["id_player"] ;
    $datadate = (int)$timestamp ;
    $name_planete = $db->sql_escape_string($value["name_planete"] ) ;
    $name_moon = $db->sql_escape_string($value["name_moon"] ) ;
    $moon = (int)$value["moon"] ;
    
    
    
     $temp_query = "( ".$g.", ".$s." , ".$r."  , ".$id_player." , ".$datadate." , '".my_encodage($name_planete)."' , '".$name_moon."' , '".$moon."'  , ".$sender_id." ) ";
     $query[] = $temp_query;
     $total ++; 
     
} 

 // avant de traiter le $_post, on va preparer uni vide avec le timestamp 
$uni = (int)$galaxie;

    for ($i = 1; $i < ((int)$server_config['num_of_systems'] + 1 ); $i++) {
         for ($j = 1; $j < 16 ; $j++)
         {
            $temp_query = "( ".$uni.", ".$i." , ".$j."  , 0 , ".$timestamp." , '' , '' , '0'  , ".$sender_id." ) ";
            $pre_query[] = $temp_query; 
            
         }
    }
 $db->sql_query('REPLACE INTO '.$table.' ('.$fields.') VALUES '.implode(',', $pre_query));
 // on vide prequery 
 $pre_query = array();
 
 
 

// et maintenant l envoi qui va bien ( $_post)
  

$db->sql_query('REPLACE INTO '.$table.' ('.$fields.') VALUES '.implode(',', $query));
echo "mise a jour de ".$total." ligne(s) univers ";
    
    
    
// requete de mise a jour    
$sql = "UPDATE ".TABLE_UNIVERSE." as U INNER JOIN ".TABLE_UNIVERS." as T ";
$sql .= " ON ";
$sql .= "( U.galaxy = T.g AND U.row = T.r  AND U.system = T.s )   ";
$sql .= "INNER JOIN ".TABLE_PLAYERS." as P ";
$sql .= " ON ";
$sql .= "( T.id_player = P.id_player  )   ";
$sql .= "INNER JOIN ".TABLE_ALLIANCES." as A ";
$sql .= " ON ";
$sql .= "( A.id_alliance = P.id_ally  )   ";
$sql .= " SET ";
$sql .= " U.moon = T.moon , U.name = T.name_planete  , U.ally = A.tag , U.player = P.name_player , U.status = P.status   , U.last_update = T.datadate   , U.last_update_user_id = T.sender_id  ";
$sql .= " WHERE  ";
$sql .= "  U.last_update <= T.datadate ";
$sql .= " AND ";
$sql .= " U.galaxy = ".$uni." ";


$db->sql_query($sql);

//$sql = "REPLACE INTO ".$table."  ";
//$sql .= ($table != "CST_PLAYERS_RANK_MILITARY" ) ? " ( `datadate`, `rank`, `player`, `ally`, `points` , `sender_id`) " : " ( `datadate`, `rank`, `player`, `ally`, `points` , `ships` ,`sender_id`) " ;
//$sql .= ($table != "CST_PLAYERS_RANK_MILITARY" ) ? " SELECT srp.datadate, srp.rank,sp.name_player  ,sa.tag,  srp.points , srp.sender_id " : " SELECT srp.datadate, srp.rank,sp.name_player  ,sa.tag, srp.points , srp.ships,srp.sender_id ";
//$sql .= " FROM  ".TABLE_PLAYERS." as sp ";
//$sql .= "INNER JOIN ".TABLE_RANK_PLAYERS." as srp "; 
//$sql .= " on sp.id_player	= srp.id " ;
//$sql .= "INNER JOIN ".TABLE_ALLIANCES." as sa "; 
//$sql .= " on sa.id_alliance	= sp.id_ally ; " ;

// requete de mise a jour a partir du tampon
//$req_update = "";
//$req_update .= " UPDATE ".TABLE_UNIVERSE." as U INNER JOIN ".APIX_TABLE_UNIVERS." as T ";
//$req_update .= " ON ";
//$req_update .= "  ( U.galaxy = T.galaxy AND U.row = T.row  AND U.system = T.system )   ";
//$req_update .= " SET ";
//$req_update .= " U.moon = T.moon , U.name = T.name  , U.ally = T.ally , U.player = T.player , U.status = T.status   , U.last_update = T.last_update   , U.last_update_user_id = T.last_update_user_id  ";
//$req_update .= " WHERE  ";
//$req_update .= "  U.last_update < T.last_update ";
//
//$db->sql_query($req_update);

//	galaxy	system	row	moon	phalanx	gate	name	ally	player	status	last_update	last_update_moon	last_update_user_id 
    
    //	g	s	r	id_player	datadate	name_planete	name_moon	moon	sender_id
    
    //	id_player	name_player	status	id_ally
    
    //	id_alliance	tag	nb
    
insert_config("last_".$pub_type,$timestamp );




