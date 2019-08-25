<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.fr/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");


if (!defined('TABLE_XTENSE_CALLBACKS')) {
    define('TABLE_XTENSE_CALLBACKS', $table_prefix.'xtense_callbacks');
}

function IsXtenseInstalled() {
    global $db;
    // Check if xtense_callbacks table exists :
    $query = 'SHOW TABLES LIKE "' . TABLE_XTENSE_CALLBACKS . '"';
    $result = $db->sql_query($query);
    if ($db->sql_numrows($result) != 0) {
        return TRUE;
    }
    return FALSE;
}

function AddCallback($appels, $uIdMod) {
    global $db;
    $query = 'REPLACE INTO ' . TABLE_XTENSE_CALLBACKS . ' (mod_id, function, type, active) VALUES (' . $uIdMod . ', "spaXtense", "' . $appels . '", 1)';
    $db->sql_query($query);
}

function DelCallback($appels , $uIdMod) {
    global $db;
    $query = 'DELETE FROM ' . TABLE_XTENSE_CALLBACKS . ' WHERE type = \'' . $appels . '\' and mod_id = ' . $uIdMod;
    $db->sql_query($query);
}

function DelAllCallbacks($uIdMod) {
    global $db;
    $query = 'DELETE FROM ' . TABLE_XTENSE_CALLBACKS . ' WHERE mod_id = ' . $uIdMod;
    $db->sql_query($query);
}

function GetAllCallBacks($uIdMod) {
    global $db;
    $sql = "select type from " . TABLE_XTENSE_CALLBACKS . " WHERE mod_id = ".$uIdMod." ;";
    $result = $db->sql_query($sql);
    $tResult = array();
    while ($row = $db->sql_fetch_assoc($result)) {
        $tResult[] = $row["type"];
    }
    return $tResult;
}
