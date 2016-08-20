<?php

if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");

function insert_config($name, $value) {
    global $db;
    $query = "REPLACE INTO " . TABLE_CFG . " (config_name, config_value) VALUES ('" . $name . "','" . $value . "')";
    $db->sql_query($query);
}

function find_config($name) {
    global $db;

    $query = "SELECT config_value FROM " . TABLE_CFG . " WHERE config_name = '" . $name . "' ";
    $result = $db->sql_query($query);
    $row = $db->sql_fetch_assoc($result);
    if ($row) {
        return $row['config_value'];
    }
}

function create_uni_vide() {
    global $db, $server_config;

    $query = array();
    for ($g = 1; $g <= $server_config['num_of_galaxies']; $g++) {
        for ($s = 1; $s <= $server_config['num_of_systems']; $s++) {
            for ($r = 1; $r <= 15; $r++) {
                $query[] = '("' . (int) ($g) . '", "' . (int) ($s) . '", "' . (int) ($r) . '")';
            }
        }

        // on lance les requetes
        $db->sql_query('INSERT  IGNORE  INTO ' . TABLE_UNIVERSE . ' ( galaxy,system,row) VALUES ' . implode(',', $query));
        $query = array();
    }
}
