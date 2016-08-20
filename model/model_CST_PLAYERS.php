<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.fr/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX')) die("Hacking attempt");
global $db;
$timestamp = (int)$pub_timestamp;

$total = 0;
$query = array();
$fields =  "id_player, name_player, status, id_ally" ;


$query[] = "( 0, '' , '', 0 ) ";

foreach($pub_value as $value)
{
    $id_player = (int)$value["id"] ;
    $name_player = $db->sql_escape_string($value["name"]) ;
    $status = $db->sql_escape_string($value["status"]) ;
    $id_ally = (int)$value["alliance"] ;
    
     $temp_query = "( ".$id_player.", '".my_encodage($name_player)."' , '".$status."', ".$id_ally." ) ";
     $query[] = $temp_query;
     $total ++; 
     
}    

$db->sql_query('REPLACE INTO '.TABLE_PLAYERS.' ('.$fields.') VALUES '.implode(',', $query));
echo "mise a jour de ".$total." ligne(s) de joueur ";
    
 

insert_config("last_".$pub_type,$timestamp );

