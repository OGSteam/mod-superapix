<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.fr/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('IN_SPYOGAME'))
    die("Hacking attempt");
define('IN_SUPERAPIX', true);

global $db;
include_once("mod/superapix/common.php");

$security = false;
$mod_folder = MOD_NAME;
$security = install_mod($mod_folder);
if ($security == true) {
    // on ajoute 
  
   
    // création tables
    create_table_config();
    create_table_players();
    create_table_alliances();
    create_table_rank_alliance();
    create_table_rank_player();
    create_table_univers();

    rempli_table_univers();

    insert_config("uni", 0);
    
    // installation d un joueur 
    newPlayer();
   
}



