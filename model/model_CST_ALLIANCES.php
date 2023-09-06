<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, https://ogsteam.eu/
 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('IN_SPYOGAME')) die("Hacking attempt");
global $db;

$timestamp = (int)$pub_timestamp;

$total = 0;
$query = array();
$fields =  "id_alliance, tag, nb ";
$query[] = "( 0 , '' , 0 ) ";

foreach ($pub_value as $value) {
    $id_alliance = (int)$value["id"];
    $tag = $db->sql_escape_string($value["tag"]);
    $nb = $db->sql_escape_string($value["nb"]);


    $temp_query = "( " . $id_alliance . ", '" . my_encodage($tag) . "' , '" . $nb . "' ) ";
    $query[] = $temp_query;
    $total++;
}

$db->sql_query('REPLACE INTO ' . TABLE_ALLIANCES . ' (' . $fields . ') VALUES ' . implode(',', $query));
echo "mise a jour de " . $total . " ligne(s) d' alliance ";


insert_config("last_" . $pub_type, $timestamp);
