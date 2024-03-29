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
    echo " allow_url_fopen non activé, verifier votre configuration php ";
    die();
}

if (isset($pub_create_uni)) {
    //plus necessaire
    create_uni_vide();
}

if (isset($pub_reinit)) {

    reinit();
    header("Refresh: 0; url=index.php?action=superapix&admin=1");
    die();
}




// point d access à supprimer
if (isset($pub_sub_action) && $pub_sub_action == "cross") {
    require_once("views/page_header.php");
    // avant traitement on met la progress barre
    if (isset($pub_step) && is_numeric($pub_step)) {
        echo progress_barre((int) $pub_step, "");
    }
    include(MOD_ROOT_JS . "cst_javascript.php");
    echo '<script src="' . MOD_ROOT_JS . 'cross_domain.js" type="text/javascript"> </script>';
    include(MOD_ROOT_VUE . "cross_domain.php");
    require_once("views/page_tail.php");
    die;
}

if (isset($pub_sub_action) && $pub_sub_action == "send") {
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

        echo " moi pas comprendre";
    }

    die;
}

if (isset($pub_step) && is_numeric($pub_step)) {
    require_once("views/page_header.php");
    // avant traitement on met la progress barre
    if (isset($pub_step) && is_numeric($pub_step)) {
        echo progress_barre((int) $pub_step, "");
    }

    include(MOD_ROOT_JS . "cst_javascript.php");
    //  echo '<script src="'.MOD_ROOT_JS.'superapix.js" type="text/javascript"> </script>';
    // echo '<script src="'.MOD_ROOT_JS.'player.js" type="text/javascript"> </script>';
    //echo '<script src="'.MOD_ROOT_JS.'alliance.js" type="text/javascript"> </script>';
    //echo '<script src="'.MOD_ROOT_JS.'rank_alliance.js" type="text/javascript"> </script>';
    //echo '<script src="'.MOD_ROOT_JS.'rank_player.js" type="text/javascript"> </script>';

    // on va d ailleurs pas se casser la tete, le decode on le met ici :
    include(MOD_ROOT_VUE . "step.php"); // traitement des envois
    require_once("views/page_tail.php");
    die;
}


require_once("views/page_header.php");
echo '<script src="' . MOD_ROOT_JS . 'step.js" type="text/javascript"> </script>';

if (!IsXtenseInstalled()) {
    $errormsg = array();
    $errormsg[] = "Le mod xtense doit etre installé !!!";
    include(MOD_ROOT_VUE . "error.php");
} elseif (isset($pub_help)) {
    //page d'aide
    include(MOD_ROOT_VUE . "help.php");
} else {
    // page d acceuil
    include(MOD_ROOT_VUE . "index.php");
}


require_once("views/page_tail.php");
