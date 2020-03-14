<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.fr/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");

function create_table_config() {
    global $db;

    $sql = " CREATE TABLE If NOT EXISTS " . TABLE_CFG . " ( ";
    $sql .= " config_name varchar(50) NOT NULL default '', ";
    $sql .= " config_value varchar(255) NOT NULL default '', ";
    $sql .= " PRIMARY KEY  (config_name) ) ;";

    $db->sql_query($sql);
}

function delete_table_config() {
    global $db;

    $sql = " DROP TABLE IF EXISTS " . TABLE_CFG . " ;";

    $db->sql_query($sql);
}

function create_table_players() {
    global $db;

    $sql = " CREATE TABLE If NOT EXISTS " . TABLE_PLAYERS . " ( ";
    $sql .= " id_player INT(6) NOT NULL , ";
    $sql .= " name_player varchar(65) NOT NULL , ";
    $sql .= " status varchar(6) NOT NULL default '', ";
    $sql .= " id_ally INT(6) NOT NULL ,  ";
    $sql .= " datadate INT(11) NOT NULL , ";
    $sql .= " PRIMARY KEY  (id_player) ) ;";

    $db->sql_query($sql);
}

function delete_table_players() {
    global $db;

    $sql = " DROP TABLE IF EXISTS " . TABLE_PLAYERS . " ;";

    $db->sql_query($sql);
}

function create_table_alliances() {
    global $db;

    $sql = " CREATE TABLE If NOT EXISTS " . TABLE_ALLIANCES . " ( ";
    $sql .= " id_alliance INT(6) NOT NULL , ";
    $sql .= " tag varchar(65) NOT NULL , ";
    $sql .= " name_ally varchar(65) NOT NULL , ";
    $sql .= " nb varchar(6) NOT NULL default '', ";
    $sql .= " datadate INT(11) NOT NULL , ";
    $sql .= " PRIMARY KEY  (id_alliance) ) ;";

    $db->sql_query($sql);
}

function delete_table_alliances() {
    global $db;

    $sql = " DROP TABLE IF EXISTS " . TABLE_ALLIANCES . " ;";

    $db->sql_query($sql);
}

function create_table_rank_alliance() {
    global $db;

    $sql = " CREATE TABLE If NOT EXISTS " . TABLE_RANK_ALLIANCES . " ( ";
    $sql .= " datadate INT(11) NOT NULL , ";
    $sql .= " rank INT(11) NOT NULL , ";
    $sql .= " id_alliance INT(11) NOT NULL , ";
    $sql .= " points INT(11) NOT NULL, ";
    $sql .= " sender_id INT(11) NOT NULL, ";
    $sql .= " PRIMARY KEY (`rank`,`datadate`,`id_alliance`));";


    $db->sql_query($sql);
}

function delete_table_rank_alliance() {
    global $db;

    $sql = " DROP TABLE IF EXISTS " . TABLE_RANK_ALLIANCES . " ;";

    $db->sql_query($sql);
}

function create_table_rank_player() {
    global $db;

    $sql = " CREATE TABLE If NOT EXISTS " . TABLE_RANK_PLAYERS . " ( ";
    $sql .= " datadate INT(11) NOT NULL , ";
    $sql .= " rank INT(11) NOT NULL , ";
    $sql .= " id INT(11) NOT NULL , ";
    $sql .= " points INT(11) NOT NULL, ";
    $sql .= " nb_spacecraft INT(11) NOT NULL default '0' , ";
    $sql .= " sender_id INT(11) NOT NULL, ";
    $sql .= " PRIMARY KEY (`rank`,`datadate`,`id`));";


    $db->sql_query($sql);
}

function delete_table_rank_player() {
    global $db;

    $sql = " DROP TABLE IF EXISTS " . TABLE_RANK_PLAYERS . " ;";

    $db->sql_query($sql);
}

function create_table_univers() {
    global $db;

    $sql = " CREATE TABLE If NOT EXISTS " . TABLE_UNIVERS . " ( ";
    $sql .= " g INT(2) NOT NULL , ";
    $sql .= " s INT(3) NOT NULL , ";
    $sql .= " r INT(2) NOT NULL , ";
    $sql .= " id_player INT(11) NOT NULL, ";
    $sql .= " datadate INT(11) NOT NULL, ";
    $sql .= " name_planete VARCHAR(40) NOT NULL  , ";
    $sql .= " name_moon VARCHAR(40) NOT NULL  , ";
    $sql .= " moon VARCHAR(1) NOT NULL  , ";
    $sql .= " sender_id INT(11) NOT NULL, ";
    $sql .= " UNIQUE KEY univers (g,s,r) );";


    $db->sql_query($sql);
}

function rempli_table_univers() {
    global $db, $user_data, $server_config;

    $table = TABLE_UNIVERS;
    $sender_id = $user_data['user_id'];

    $total = 0;
    $query = array();


    $fields = "g, s, r, id_player ,  datadate , name_planete ,name_moon , moon  , sender_id   ";




    $g = (int) $server_config["num_of_galaxies"];
    $s = (int) $server_config["num_of_systems"];
    $r = 15;

    for ($galaxie = 1; $galaxie <= $g; $galaxie++) {
        for ($system = 1; $system <= $s; $system++) {
            for ($row = 1; $row <= $r; $row++) {
                $query[] = "( " . $galaxie . ", " . $system . " , " . $row . "  , " . 0 . " , " . 0 . " , '' , '' , '0'  , " . $sender_id . " ) ";
            }
        }
        $db->sql_query('REPLACE INTO ' . $table . ' (' . $fields . ') VALUES ' . implode
                        (',', $query));
        $query = array();
    }
}

function delete_table_univers() {
    global $db;

    $sql = " DROP TABLE IF EXISTS " . TABLE_UNIVERS . " ;";

    $db->sql_query($sql);
}

function newPlayer() {
    if (!playerExist()) {
        global $db;
        $sql = "  replace INTO " . TABLE_USER . "  (`user_id`, `user_name`, `user_password`) VALUES (NULL, '" . constant("SPA_PLAYER") . "' , 'noconnection');";
        $db->sql_query($sql);
    }
}

function playerExist($name = NULL) {
    global $db;
    if ($name == NULL) {
        $name = constant("SPA_PLAYER");
    }
    $query = "SELECT user_id FROM " . TABLE_USER . " WHERE user_name = '" . constant("SPA_PLAYER") . "' ";
    $result = $db->sql_query($query);
    $row = $db->sql_fetch_assoc($result);
    if ($row) {
        return TRUE;
    }
    return FALSE;
}

function delPlayer() {
    global $db;
    $sql = "delete from " . TABLE_USER . " where user_name = '" . constant("SPA_PLAYER") . "';";
    $db->sql_query($sql);
}

function spaActive() {
    global $db;

    $query = "SELECT active FROM " . TABLE_MOD . " WHERE root = 'superapix' ";
    $result = $db->sql_query($query);
    $row = $db->sql_fetch_assoc($result);
    if ($row) {
        if ($row['active'] == 1) {
            return $row['active'];
        }
    }
    return NULL;
}

function spaModId() {
    global $db;

    $query = "SELECT id FROM " . TABLE_MOD . " WHERE root = 'superapix' ";
    $result = $db->sql_query($query);
    $row = $db->sql_fetch_assoc($result);
    if ($row) {
        return $row['id'];
    }
    return 0;
}


function fixPtPerMember()
{
    global $db;
    $output = array();
    $query = "describe ".TABLE_RANK_ALLY_POINTS."; ";
    $result = $db->sql_query($query);

    while ($row = $db->sql_fetch_row($result))
    {
        $output[$row[0]] = $row[4];
    }
    if ($output['points_per_member'] == null)
    {
      // la valeur n'est pas correcte
        $qeury2 =   "ALTER TABLE ".TABLE_RANK_ALLY_POINTS." ALTER COLUMN points_per_member SET DEFAULT '0'";
        $result = $db->sql_query($qeury2);
    }


}


