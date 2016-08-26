<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.fr/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");
global $table_prefix;


// constante de table
define("MOD_NAME", "superapix");
define("TABLE_CFG", $table_prefix . MOD_NAME . "_cfg");
define("TABLE_PLAYERS", $table_prefix . MOD_NAME . "_players");
define("TABLE_ALLIANCES", $table_prefix . MOD_NAME . "_alliances");
define("TABLE_RANK_ALLIANCES", $table_prefix . MOD_NAME . "_rank_alliance");
define("TABLE_RANK_PLAYERS", $table_prefix . MOD_NAME . "_rank_player");
define("TABLE_UNIVERS", $table_prefix . MOD_NAME . "_universe");

// paths
define("MOD_ROOT", "mod/" . MOD_NAME . "/");
define("MOD_ROOT_MODEL", MOD_ROOT . "model/");
define("MOD_ROOT_VUE", MOD_ROOT . "vue/");
define("MOD_ROOT_JS", MOD_ROOT . "js/");
define("MOD_ROOT_INCLUDE", MOD_ROOT . "include/");
define("MOD_ROOT_XML", MOD_ROOT . "xml/");
define("MOD_ROOT_PARSER", MOD_ROOT . "parser/");

//joueur superapix
define("SPA_PLAYER", "SPA_WebService");

// include générique
include(MOD_ROOT_MODEL . "config.php");
include(MOD_ROOT_MODEL . "db.php");
include(MOD_ROOT_INCLUDE . "function.php");
include(MOD_ROOT_INCLUDE . "cst.php");
include(MOD_ROOT_INCLUDE . "lang.php");
include_once(MOD_ROOT_MODEL . "install.php");


//degug
define("DEBUG", find_config("debug"));

