<?php

/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, https://ogsteam.eu/
 * @license https://opensource.org/licenses/gpl-license.php GNU Public License
 */

define('IN_SUPERAPIX', true);
define('IN_XTENSE', false);

if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");

    include_once("mod/superapix/common.php");

    if (!ini_get('allow_url_fopen')) {
        die("allow_url_fopen non activé, vérifiez votre configuration PHP");
    }
    
    if (isset($pub_reinit)) {
        reinit();
        header("Refresh: 0; url=index.php?action=superapix&admin=1");
        exit;
    }
    
    if (isset($pub_sub_action)) {
        switch ($pub_sub_action) {
            case "cross":
                require_once("views/page_header.php");
                if (isset($pub_step) && is_numeric($pub_step)) {
                    echo progress_barre((int) $pub_step, "");
                }
                include(MOD_ROOT_JS . "cst_javascript.php");
                echo '<script src="' . MOD_ROOT_JS . 'cross_domain.js" type="text/javascript"></script>';
                include(MOD_ROOT_VUE . "cross_domain.php");
                require_once("views/page_tail.php");
                exit;
    
            case "send":
                $temp_ally = constante_array_rank_alliance();
                $temp_player = constante_array_rank_player();
    
                if (file_exists(MOD_ROOT_MODEL . "model_" . $pub_type . ".php")) {
                    include(MOD_ROOT_MODEL . "model_" . $pub_type . ".php");
                } elseif (isset($temp_ally[$pub_type])) {
                    include(MOD_ROOT_MODEL . "model_CST_ALLIANCES_RANK.php");
                } elseif (isset($temp_player[$pub_type])) {
                    include(MOD_ROOT_MODEL . "model_CST_PLAYERS_RANK.php");
                } elseif (strstr($pub_type, "CST_UNIVERSE")) {
                    include(MOD_ROOT_MODEL . "model_CST_UNIVERSE.php");
                } else {
                    die("Moi pas comprendre");
                }
                exit;
    
            case "step":
                if (isset($pub_step) && is_numeric($pub_step)) {
                    require_once("views/page_header.php");
                    echo progress_barre((int) $pub_step, "");
                    include(MOD_ROOT_JS . "cst_javascript.php");
                    include(MOD_ROOT_VUE . "step.php");
                    require_once("views/page_tail.php");
                }
                exit;
        }
    }
    
    require_once("views/page_header.php");
    include(MOD_ROOT_VUE . "page_header_mod.php");
    include(MOD_ROOT_VUE . "page_menu_mod.php");
    echo '<script src="' . MOD_ROOT_JS . 'step.js" type="text/javascript"></script>';
    
    $views = [
        "link" => "link.php",
        "admin" => "admin.php",
        "superapix" => "index.php",
        "xml" => "xml.php"
    ];
    
    include(MOD_ROOT_VUE . ($views[$pub_subaction] ?? "index.php"));
    
    include(MOD_ROOT_VUE . "page_footer_mod.php");
    require_once("views/page_tail.php");
    ?>