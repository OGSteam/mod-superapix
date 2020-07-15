<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.fr/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX')) die("Hacking attempt");
global $db , $user_data;

$timestamp = formatage_timestamp_for_rank((int)$pub_timestamp);;
$table = find_table($db->sql_escape_string($pub_type)); 

$total = 0;
$query = array();

$fields =  "datadate, rank, id, points , ships , sender_id " ;


foreach($pub_value as $value)
{
    $datadate = $timestamp ;
    $rank = (int)$value["position"] ;
    $id = (int)$value["id"] ;
    $points = (int)$value["score"] ;
    $ships = isset($value["ships"]) ? $value["ships"] : 0;
    $sender_id = (int)$user_data['user_id'] ;
    
     $temp_query = "( ".$datadate.", ".$rank.", ".$id." , ".$points." , ".(int)$ships." , ".$user_data['user_id'] ." ) ";
     $query[] = $temp_query;
     $total ++; 
     
}   


$db->sql_query('REPLACE INTO '.TABLE_RANK_PLAYERS.' ('.$fields.') VALUES '.implode(',', $query));
echo "mise a jour de ".$total." ligne(s) classement player ";


// on fait la jointure qui va bien pour injecter le bon classement

$sql = "REPLACE INTO ".$table."  ";
$sql .= ($table != "CST_PLAYERS_RANK_MILITARY" ) ? " ( `datadate`, `rank`, `player`, `ally`, `points` , `sender_id`) " : " ( `datadate`, `rank`, `player`, `ally`, `points` , `ships` ,`sender_id`) " ;
$sql .= ($table != "CST_PLAYERS_RANK_MILITARY" ) ? " SELECT srp.datadate, srp.rank,sp.name_player  ,sa.tag,  srp.points , srp.sender_id " : " SELECT srp.datadate, srp.rank,sp.name_player  ,sa.tag, srp.points , srp.ships,srp.sender_id ";
$sql .= " FROM  ".TABLE_PLAYERS." as sp ";
$sql .= "INNER JOIN ".TABLE_RANK_PLAYERS." as srp "; 
$sql .= " on sp.id_player	= srp.id " ;
$sql .= "INNER JOIN ".TABLE_ALLIANCES." as sa "; 
$sql .= " on sa.id_alliance	= sp.id_ally ; " ;

$db->sql_query($sql);
//var_dump($sql);

//datadate	rank	player	ally	points ships	sender_id

echo "injection de de ".$db->sql_affectedrows()." ligne(s) classement player ";

//REPLACE INTO ogspy_necrotg_rank_ally_points ( `datadate`, `rank`, `ally`, `number_member`, `points` )
//SELECT sra.datadate, sra.rank, sa.tag, sa.nb , sra.points  FROM  ogspy_necrotg_superapix_alliances as sa  INNER JOIN ogspy_necrotg_superapix_rank_alliance as sra on sa.id_alliance	= sra.id_alliance

// on efface la table rank
$sql = "DELETE FROM ".TABLE_RANK_PLAYERS." ;";
$db->sql_query($sql);

insert_config("last_".$pub_type,$timestamp );















function find_table($type)
{
    $tab = array();
    $tab = array(
    "CST_PLAYERS_RANK_POINTS" => TABLE_RANK_PLAYER_POINTS,
    "CST_PLAYERS_RANK_ECO" => TABLE_RANK_PLAYER_ECO,
   "CST_PLAYERS_RANK_TECHNOLOGY" => TABLE_RANK_PLAYER_TECHNOLOGY,
   "CST_PLAYERS_RANK_MILITARY" => TABLE_RANK_PLAYER_MILITARY,
   "CST_PLAYERS_RANK_MILITARY_BUILT" => TABLE_RANK_PLAYER_MILITARY_BUILT,
   "CST_PLAYERS_RANK_MILITARY_DESTROYED" => TABLE_RANK_PLAYER_MILITARY_DESTRUCT,
   "CST_PLAYERS_RANK_MILITARY_LOST" => TABLE_RANK_PLAYER_MILITARY_LOOSE,
   "CST_PLAYERS_RANK_MILITARY_HONNOR" => TABLE_RANK_PLAYER_HONOR,
    );
    $retour = $tab[$type];
    return $retour;
    
}