<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.fr/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */


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
    return NULL;
}

function  check_uni_vide()
{

}

/// devenu obsolete : rempli_table_univers() a l'install et update garantisse les datas
function create_uni_vide() {
    return null;
    // ce qui suit ne sera pas executé
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

function reinit(){
    //change last date
    $tab = constante_stepper();
foreach ($tab as $key => $value)
{
    insert_config("last_" . $value,0);
}

    // purge le dossier xml (voir pour glob dans prochaine maj )
    $rep=opendir(MOD_ROOT_XML);
    while($file = readdir($rep)){
        if($file != '..' && $file !='.' && $file !='' && $file!='.htaccess'&& $file!='index.php'){
            unlink(MOD_ROOT_XML.$file);
        }
    }




}

function defineDebug() {
    global $db;

            // Check if xtense_callbacks table exists :
    $query = 'SHOW TABLES LIKE "' . TABLE_CFG . '"';
    $result = $db->sql_query($query);
    if ($db->sql_numrows($result) != 0) {
        define("DEBUG", find_config("debug"));
    }


}
