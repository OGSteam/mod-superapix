<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, https://ogsteam.eu/
 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX')) die("Hacking attempt");
global $db, $user_data,  $server_config;

global $db, $user_data,  $server_config, $pub_timestamp;
$timestamp = (int)$pub_timestamp;

$table = TABLE_UNIVERS;
$sender_id = $user_data['user_id'];

$total = 0;
$query = array();
$pre_query = array();

$fields =  "g, s, r, id_player , datadate , name_planete ,name_moon , moon  , sender_id   ";

$galaxie = 0;

foreach ($pub_value as $value) {

    $g = (int)$value["g"];
    $galaxie = $g;
    $s = (int)$value["s"];
    $r = (int)$value["r"];
    $id_player = (int)$value["id_player"];
    $datadate = (int)$timestamp;
    $name_planete = $db->sql_escape_string($value["name_planete"]);
    $name_moon = $db->sql_escape_string($value["name_moon"]);
    $moon = (int)$value["moon"];



    $temp_query = "( " . $g . ", " . $s . " , " . $r . "  , " . $id_player . " , " . $datadate . " , '" . my_encodage($name_planete) . "' , '" . $name_moon . "' , '" . $moon . "'  , " . $sender_id . " ) ";
    $query[] = $temp_query;
    $total++;
}

$db->sql_query('REPLACE INTO ' . $table . ' (' . $fields . ') VALUES ' . implode(',', $query));
echo "mise a jour de " . $total . " ligne(s) univers ";

update_table_universe($uni);
insert_config("last_" . $pub_type, $timestamp);

function update_table_universe($uni = 0)
{
    global $db;
    // requete de mise a jour
    $sql = "UPDATE " . TABLE_UNIVERSE . " as U INNER JOIN " . TABLE_UNIVERS . " as T ";
    $sql .= " ON ";
    $sql .= "( U.galaxy = T.g AND U.row = T.r  AND U.system = T.s )   ";
    $sql .= "INNER JOIN " . TABLE_PLAYERS . " as P ";
    $sql .= " ON ";
    $sql .= "( T.id_player = P.id_player  )   ";
    $sql .= "INNER JOIN " . TABLE_ALLIANCES . " as A ";
    $sql .= " ON ";
    $sql .= "( A.id_alliance = P.id_ally  )   ";
    $sql .= " SET ";
    $sql .= " U.moon = T.moon , U.name = T.name_planete  , U.ally = A.tag , U.player = P.name_player , U.status = P.status   , U.last_update = T.datadate, U.last_update_user_id = T.sender_id  ";
    $sql .= " WHERE  ";
    $sql .= "  U.last_update < T.datadate ";
    if ($uni != 0) {
        $sql .= " AND ";
        $sql .= " U.galaxy = " . $uni . " ";
    }

    $db->sql_query($sql);

    prepare_table_universe($datadate);
    /// ensuite il faut une requete d update pour mettre a 0 tout ce qui a pas le bon timestamps min : c que pas dans universe.xml
}
