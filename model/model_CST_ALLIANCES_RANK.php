<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.eu/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX')) die("Hacking attempt");
global $db, $user_data;
$timestamp = formatage_timestamp_for_rank((int)$pub_timestamp);;
$table = find_table($db->sql_escape_string($pub_type));

$total = 0;
$query = array();
$fields =  "datadate, rank, id_alliance, points , sender_id ";



foreach ($pub_value as $value) {
    $datadate = $timestamp;
    $rank = (int)$value["position"];
    $id_alliance = (int)$value["id"];
    $points = (int)$value["score"];
    $sender_id = (int)$user_data['user_id'];

    $temp_query = "( " . $timestamp . ", " . $rank . ", '" . $id_alliance . "' , '" . $points . "' , " . $user_data['user_id'] . " ) ";
    $query[] = $temp_query;
    $total++;
}

$db->sql_query('REPLACE INTO ' . TABLE_RANK_ALLIANCES . ' (' . $fields . ') VALUES ' . implode(',', $query));
echo "mise a jour de " . $total . " ligne(s) classement alliance d' alliance ";

// on fait la jointure qui va bien pour injecter le bon classement

$sql = "REPLACE INTO " . $table . "  ";
$sql .= " ( `datadate`, `rank`, `ally`, `number_member`, `points` , `sender_id`) ";
$sql .= " SELECT sra.datadate, sra.rank, sa.tag, sa.nb , sra.points , sra.sender_id ";
$sql .= " FROM  " . TABLE_ALLIANCES . " as sa ";
$sql .= "INNER JOIN " . TABLE_RANK_ALLIANCES . " as sra ";
$sql .= " on sa.id_alliance = sra.id_alliance ; ";

$db->sql_query($sql);

echo "injection de de " . $db->sql_affectedrows() . " ligne(s) classement alliance d' alliance ";

//REPLACE INTO ogspy_necrotg_rank_ally_points ( `datadate`, `rank`, `ally`, `number_member`, `points` )
//SELECT sra.datadate, sra.rank, sa.tag, sa.nb , sra.points  FROM  ogspy_necrotg_superapix_alliances as sa  INNER JOIN ogspy_necrotg_superapix_rank_alliance as sra on sa.id_alliance   = sra.id_alliance

// on efface la table rank
$sql = "DELETE FROM " . TABLE_RANK_ALLIANCES . " ;";
$db->sql_query($sql);

insert_config("last_" . $pub_type, $timestamp);



function find_table($type)
{
    $tab = array();
    $tab = array(
        "CST_ALLIANCES_RANK_POINTS" => TABLE_RANK_ALLY_POINTS,
        "CST_ALLIANCES_RANK_ECO" => TABLE_RANK_ALLY_ECO,
        "CST_ALLIANCES_RANK_TECHNOLOGY" => TABLE_RANK_ALLY_TECHNOLOGY,
        "CST_ALLIANCES_RANK_MILITARY" => TABLE_RANK_ALLY_MILITARY,
        "CST_ALLIANCES_RANK_MILITARY_BUILT" => TABLE_RANK_ALLY_MILITARY_BUILT,
        "CST_ALLIANCES_RANK_MILITARY_DESTROYED" => TABLE_RANK_ALLY_MILITARY_DESTRUCT,
        "CST_ALLIANCES_RANK_MILITARY_LOST" => TABLE_RANK_ALLY_MILITARY_LOOSE,
        "CST_ALLIANCES_RANK_MILITARY_HONNOR" => TABLE_RANK_ALLY_HONOR,
    );
    $retour = $tab[$type];
    return $retour;
}
