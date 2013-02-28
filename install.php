<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db;
include_once("mod/superapix/common.php");

$security = false;
$mod_folder = MOD_NAME;
$security = install_mod($mod_folder);
if ($security == true)
  {
    // on ajoute 
    include_once(MOD_ROOT_MODEL."install.php");
    
    // création tables
    create_table_config();
    create_table_players();
    create_table_alliances();
    create_table_rank_alliance();
    create_table_rank_player();
    create_table_univers();
    
    insert_config("uni",0);
    
    
  }
?>
