<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.eu/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */


if (!defined('IN_SPYOGAME')) die("Hacking attempt");
define('IN_SUPERAPIX', true);
global $db, $table_prefix;
include_once("mod/superapix/common.php");
include_once(MOD_ROOT_MODEL . "install.php");


$filename = 'mod/superapix/version.txt';
if (file_exists($filename)) $file = file($filename);

$security = false;
$security = update_mod('superapix', 'superapix');

if ($security == true) {
    // on ajoute

    insert_config("requete_max", 500);
    rempli_table_univers();

    newPlayer();

    fixPtPerMember();


    // reinitialisation de le table player
    delete_table_rank_player();
    create_table_rank_player();

    // ajout datadate et tag ally_name
    delete_table_players();
    create_table_players();
    delete_table_alliances();
    create_table_alliances();
    delete_table_univers();
    create_table_univers();
    rempli_table_univers();
    create_uni_vide();
}
