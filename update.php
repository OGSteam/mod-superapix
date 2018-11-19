<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.fr/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */


if (!defined('IN_SPYOGAME')) die("Hacking attempt");
define('IN_SUPERAPIX', true);
global $db, $table_prefix;
include_once("mod/superapix/common.php");
include_once(MOD_ROOT_MODEL."install.php");   


$filename = 'mod/superapix/version.txt';
if (file_exists($filename)) $file = file($filename);

//Migrattion des config vers OGSpy
$current_version = mod_version();
if(version_compare($current_version, "0.2.7", "<=")) {

    $query = "SELECT config_name, config_value FROM " . TABLE_CFG ;
    $result = $db->sql_query($query);

    while($row = $db->sql_fetch_row($result)){

        mod_set_option($row[0],$row[1]);
    }

    delete_table_config();
}

$security = false;
$security = update_mod('superapix','superapix');

if ($security == true){
// on ajoute 
 
mod_set_option("requete_max",500);
rempli_table_univers();

newPlayer();

fixPtPerMember();

// reinitialisation de le table player
delete_table_rank_player();
create_table_rank_player() ;


  
}

