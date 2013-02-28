<?php


if (!defined('IN_SPYOGAME')) die("Hacking attempt");

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

?>
