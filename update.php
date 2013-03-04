<?php


if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db, $table_prefix;

$filename = 'mod/superapix/version.txt';
if (file_exists($filename)) $file = file($filename);

$security = false;
$security = update_mod('superapix','superapix');


if ($security == true){
insert_config("requete_max",500);
}

?>
