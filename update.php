<?php


if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db, $table_prefix;
include_once("mod/superapix/common.php");
include_once(MOD_ROOT_MODEL."install.php");   


$filename = 'mod/superapix/version.txt';
if (file_exists($filename)) $file = file($filename);

$security = false;
$security = update_mod('superapix','superapix');


if ($security == true){
// on ajoute 
 
insert_config("requete_max",500);
rempli_table_univers();
  
}

?>
