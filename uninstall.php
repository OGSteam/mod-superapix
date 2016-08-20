<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.fr/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('IN_SPYOGAME')) die("Hacking attempt");
define('IN_SUPERAPIX', true);
global $db;
include_once("mod/superapix/common.php");

$mod_uninstall_name = MOD_NAME;


uninstall_mod($mod_uninstall_name,null);

 // on supp en manuel 
include_once(MOD_ROOT_MODEL."install.php");
delete_table_config();
delete_table_players();
delete_table_alliances();
delete_table_rank_alliance();
delete_table_rank_player();
delete_table_univers();
delPlayer();
?>
